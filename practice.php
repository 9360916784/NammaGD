<?php
session_start();
include "connection.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];
$room_id = null;
$gd_topic = "";
$is_host = false;

// 1. CHECK IF USER IS ALREADY IN A SESSION
if (isset($_SESSION['current_room_id'])) {
    $room_id = $_SESSION['current_room_id'];
    // Validate room still exists and is active using prepared statement
    $check_sql = "SELECT topic, host_id, participants FROM active_gd_rooms WHERE id = ? AND status='active'";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $room_id);
    $check_stmt->execute();
    $check_res = $check_stmt->get_result();
    
    if ($check_res->num_rows > 0) {
        $row = $check_res->fetch_assoc();
        $gd_topic = $row['topic'];
        // Check if current user is the host
        if($row['host_id'] == $user_id) $is_host = true;
    } else {
        // Room no longer active - clear session
        unset($_SESSION['current_room_id']);
        $room_id = null;
    }
}

// 2. ASSIGN NEW ROOM IF NOT IN ONE
if (!isset($_SESSION['current_room_id']) || $room_id === null) {
    // Try to join existing room
    $find_sql = "SELECT * FROM active_gd_rooms WHERE participants < 6 AND status='active' ORDER BY created_at DESC LIMIT 1";
    $find_res = mysqli_query($conn, $find_sql);

    if (mysqli_num_rows($find_res) > 0) {
        $room = mysqli_fetch_assoc($find_res);
        $room_id = $room['id'];
        $gd_topic = $room['topic'];
        // Use prepared statement to prevent SQL injection
        $update_stmt = $conn->prepare("UPDATE active_gd_rooms SET participants = participants + 1 WHERE id = ?");
        $update_stmt->bind_param("i", $room_id);
        $update_stmt->execute();
        
        // Failsafe: If room has no host, make this user host
        if(empty($room['host_id'])) {
            $host_update = $conn->prepare("UPDATE active_gd_rooms SET host_id = ? WHERE id = ?");
            $host_update->bind_param("ii", $user_id, $room_id);
            $host_update->execute();
            $is_host = true;
        }
    } else {
        // Create new room (User becomes Host)
        $topic_sql = "SELECT topic FROM gd_topics ORDER BY RAND() LIMIT 1";
        $topic_res = mysqli_query($conn, $topic_sql);
        $topic_row = mysqli_fetch_assoc($topic_res);
        $gd_topic = $topic_row['topic'] ?? "General Discussion";

        $stmt = $conn->prepare("INSERT INTO active_gd_rooms (topic, participants, status, host_id) VALUES (?, 1, 'active', ?)");
        $stmt->bind_param("si", $gd_topic, $user_id);
        $stmt->execute();
        $room_id = $stmt->insert_id;
        $is_host = true;
    }
    $_SESSION['current_room_id'] = $room_id;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Practice GD - Room #<?php echo $room_id; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
  <style>
    /* Dynamic Video Grid */
    #video-grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      align-items: center;
      gap: 20px;
      padding: 20px;
      min-height: 60vh;
    }
    .video-wrapper {
      position: relative;
      flex: 1 1 400px;
      aspect-ratio: 16/9;
      max-width: 90%;
      background: #000;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
      border: 2px solid #444;
    }
    #video-grid:has(> .video-wrapper:only-child) .video-wrapper {
        flex: 0 0 70%;
        max-height: 70vh;
    }
    video {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transform: scaleX(-1);
    }
    .video-label {
        position: absolute; bottom: 15px; left: 15px;
        background: rgba(0,0,0,0.6); color: white;
        padding: 5px 12px; border-radius: 20px; font-size: 0.9rem;
    }
    
    /* Transcript & Feedback Styles */
    .transcript-box {
      height: 250px;
      overflow-y: auto;
      background: #f8f9fa;
      border: 1px solid #dee2e6;
      font-size: 0.95rem;
    }
    .feedback-text-box {
        font-size: 0.85rem; padding: 10px; border-radius: 5px; margin-bottom: 8px; border: 1px solid #ddd;
    }
    .bg-original { background-color: #f8f9fa; color: #666; }
    .bg-corrected { background-color: #d1e7dd; color: #0f5132; border-color: #badbcc; }
    .bg-polite { background-color: #cfe2ff; color: #084298; border-color: #b6d4fe; }
    
    #timer-badge { font-size: 1.2rem; font-weight: bold; min-width: 100px; text-align: center; }
  </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><i class="bi bi-chat-dots"></i> Namma GD</a>
    
    <div class="ms-auto text-white d-flex align-items-center">
        <span id="timer-badge" class="badge bg-warning text-dark me-3" style="display:none;">15:00</span>

        <span class="me-3">
            Room ID: <strong><?php echo $room_id !== null ? $room_id : 'Not joined'; ?></strong> | 
            Topic: <strong><?php echo htmlspecialchars($gd_topic); ?></strong>
        </span>
        <a href="dashboard.php" class="btn btn-danger btn-sm fw-bold" style="display:<?php echo ($room_id === null) ? 'inline-block' : 'none'; ?>">
            <i class="bi bi-box-arrow-left"></i> Exit
        </a>
    </div>
  </div>
</nav>

<div class="container-fluid mt-3">
  <div class="row">
    <div class="col-lg-9">
        <div id="video-grid"></div>
        
        <div class="text-center mt-3 mb-4">
            <button id="join-btn" class="btn btn-primary px-4 btn-lg"><i class="bi bi-camera-video"></i> Join Room</button>
            
            <?php if($is_host): ?>
                <button id="start-gd-btn" class="btn btn-success px-4 btn-lg" style="display:none;" disabled>
                    <i class="bi bi-play-circle"></i> Start GD Session
                </button>
            <?php else: ?>
                <button id="waiting-msg" class="btn btn-secondary px-4 btn-lg" style="display:none;" disabled>
                    <i class="bi bi-hourglass-split"></i> Waiting for Host to Start...
                </button>
            <?php endif; ?>

            <button id="leave-btn" class="btn btn-danger px-4 btn-lg" style="display:none;"><i class="bi bi-stop-circle"></i> End Session & Get Feedback</button>
        </div>

    <div class="col-lg-3">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-mic"></i> Your Live Transcript
            </div>
            <div class="card-body p-0">
                <div id="transcript" class="transcript-box p-3">
                    <em class="text-muted">Join the room to enable microphone. Transcript starts when the Host starts the GD.</em>
                </div>
            </div>
            
            <div class="card-footer" id="feedback-area" style="display:none; overflow-y:auto; max-height: 600px;">
                <h6 class="border-bottom pb-2"><i class="bi bi-robot"></i> AI Analysis</h6>
                
                <div class="d-flex justify-content-between mb-3">
                    <span class="badge bg-info text-dark p-2">Grammar: <span id="grammar-score">-</span>%</span>
                    <span class="badge bg-warning text-dark p-2">Sentiment: <span id="sentiment-score">-</span>%</span>
                </div>

                <strong>Original:</strong> <div id="disp-original" class="feedback-text-box bg-original"></div>
                <strong>Corrected:</strong> <div id="disp-corrected" class="feedback-text-box bg-corrected"></div>
                <strong>Polite Version:</strong> <div id="disp-polite" class="feedback-text-box bg-polite"></div>
                <strong class="text-danger">Tips:</strong> <div class="mt-1 small" id="ai-tips"></div>
            </div>
        </div>
    </div>
  </div>
</div>

<script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
<script type="module">
import { GoogleGenerativeAI } from "https://esm.run/@google/generative-ai";

// --- CONFIGURATION ---
const SIGNALING_SERVER_URL = "http://10.114.139.63:3000"; // Ensure this matches your server IP
const API_KEY = "AIzaSyBix7HplD3rqnUOkuawaNvjFTA99nA6GXM"; 
const ai = new GoogleGenerativeAI(API_KEY);

const ROOM_ID = "room_<?php echo $room_id; ?>"; 
const ROOM_DB_ID = "<?php echo $room_id; ?>";
const TOPIC = "<?php echo addslashes($gd_topic); ?>";
const IS_HOST = <?php echo $is_host ? 'true' : 'false'; ?>;

// DOM Elements
const videoGrid = document.getElementById('video-grid');
const joinBtn = document.getElementById('join-btn');
const startGDBtn = document.getElementById('start-gd-btn');
const waitingMsg = document.getElementById('waiting-msg');
const leaveBtn = document.getElementById('leave-btn');
const transcriptBox = document.getElementById('transcript');
const timerBadge = document.getElementById('timer-badge');

let localStream;
let recognition;
let finalTranscript = "";
let socket;
let timerInterval;
const peers = {}; 

const RTC_CONFIG = { iceServers: [{ urls: "stun:stun.l.google.com:19302" }] };

// --- 1. JOIN ROOM FUNCTION ---
joinBtn.addEventListener('click', async () => {
    try {
        // Get Camera Permission
        localStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
        addVideoStream(localStream, true, 'You');
        
        joinBtn.style.display = 'none';
        
        // Show controls depending on role
        if(IS_HOST) {
            if(startGDBtn) {
                startGDBtn.style.display = 'inline-block';
                startGDBtn.disabled = false;
            }
        } else {
            if(waitingMsg) {
                waitingMsg.style.display = 'inline-block';
            }
        }

        // Connect to Socket Server
        socket = io(SIGNALING_SERVER_URL, { transports: ["websocket"] });
        
        socket.on("connect", () => {
            socket.emit("join-room", ROOM_ID);
        });

        // WebRTC Events
        socket.on("user-connected", userId => connectToNewUser(userId, localStream));
        socket.on("offer", async (offer, userId) => handleOffer(offer, userId));
        socket.on("answer", async (answer, userId) => { if(peers[userId]) await peers[userId].setRemoteDescription(answer); });
        socket.on("candidate", async (candidate, userId) => { if(peers[userId]) await peers[userId].addIceCandidate(candidate); });
        socket.on("user-disconnected", userId => { 
            if(peers[userId]) peers[userId].close(); 
            const el = document.getElementById(userId);
            if(el) el.remove();
        });

        // --- LISTENER: START GD COMMAND ---
        // This runs for EVERYONE when the host clicks start
        socket.on("start-timer", () => {
            console.log("GD Started!");
            
            // Hide waiting/start buttons
            if(waitingMsg) waitingMsg.style.display = 'none';
            if(startGDBtn) startGDBtn.style.display = 'none';
            
            // Show leave button
            leaveBtn.style.display = 'inline-block';
            
            // Start features
            startTimer(15 * 60); 
            startRecognition(); // Transcript ONLY starts here
        });

    } catch (e) {
        console.error(e);
        alert("Camera Access Denied or Server Error. Check console.");
    }
});

// --- 2. HOST STARTS GD ---
if(startGDBtn) {
    startGDBtn.addEventListener('click', () => {
        if(socket) {
            // Send signal to server to start for everyone
            socket.emit("start-signal", ROOM_ID); 
        }
    });
}

// --- 3. TIMER ---
function startTimer(duration) {
    timerBadge.style.display = 'inline-block';
    transcriptBox.innerText = ""; // Clear placeholder text
    
    let timer = duration, minutes, seconds;
    timerInterval = setInterval(() => {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        timerBadge.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            clearInterval(timerInterval);
            timerBadge.textContent = "Times Up!";
            stopGD(); // Auto-stop
        }
    }, 1000);
}

// --- 4. WebRTC Helpers ---
function createPeer(userId) {
    const pc = new RTCPeerConnection(RTC_CONFIG);
    peers[userId] = pc;
    localStream.getTracks().forEach(track => pc.addTrack(track, localStream));
    pc.ontrack = event => { if(!document.getElementById(userId)) addVideoStream(event.streams[0], false, userId); };
    pc.onicecandidate = event => { if(event.candidate) socket.emit("candidate", event.candidate, userId); };
    return pc;
}

function connectToNewUser(userId, stream) {
    const pc = createPeer(userId);
    pc.createOffer().then(offer => {
        pc.setLocalDescription(offer);
        socket.emit("offer", offer, userId);
    });
}

async function handleOffer(offer, userId) {
    const pc = createPeer(userId);
    await pc.setRemoteDescription(offer);
    const answer = await pc.createAnswer();
    await pc.setLocalDescription(answer);
    socket.emit("answer", answer, userId);
}

function addVideoStream(stream, muted, id) {
    const div = document.createElement('div');
    div.id = id;
    div.className = "video-wrapper";
    const video = document.createElement('video');
    video.srcObject = stream;
    video.muted = muted;
    video.autoplay = true;
    const label = document.createElement('span');
    label.className = "video-label";
    label.innerText = id === 'You' ? 'You' : 'Participant';
    div.appendChild(video);
    div.appendChild(label);
    videoGrid.appendChild(div);
}

// --- 5. SPEECH RECOGNITION (Only runs after Start) ---
function startRecognition() {
    if (!('webkitSpeechRecognition' in window) && !('SpeechRecognition' in window)) {
        transcriptBox.innerText = "Speech Recognition not supported in this browser.";
        return;
    }
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    recognition = new SpeechRecognition();
    recognition.lang = 'en-US';
    recognition.continuous = true;
    recognition.interimResults = true;

    recognition.onresult = (event) => {
        let interim = '';
        for (let i = event.resultIndex; i < event.results.length; ++i) {
            if (event.results[i].isFinal) finalTranscript += event.results[i][0].transcript + ' ';
            else interim += event.results[i][0].transcript;
        }
        transcriptBox.innerText = finalTranscript + interim;
    };
    recognition.start();
}

// --- 6. LEAVE & ANALYZE ---
function stopGD() {
    leaveBtn.click();
}

leaveBtn.addEventListener('click', async () => {
    leaveBtn.disabled = true;
    clearInterval(timerInterval);
    leaveRoom(); // Updates DB count
    
    // Stop services
    if(recognition) recognition.stop();
    if(socket) socket.disconnect();
    if(localStream) localStream.getTracks().forEach(t => t.stop());
    
    // Capture Text (Fix for "Analysis Failed" on empty)
    const speechText = transcriptBox.innerText.trim();
    
    if (speechText.length < 5 || speechText === "Transcript will appear once GD starts...") {
        alert("Session Ended. No significant speech detected for analysis.");
        window.location.href = "dashboard.php";
        return; 
    }

    document.getElementById("feedback-area").style.display = 'block';
    document.getElementById("ai-tips").innerText = "Analyzing your speech... Please wait.";

    // AI Prompt
    const prompt = `
    You are an expert communication coach analyzing a student's speech in a Group Discussion.
    
    Context:
    - Topic: '${TOPIC}'
    - The Input Text below is a **raw transcription from speech-to-text**.
    - It implies the text has **NO punctuation**, no capitalization, and may contain filler words or minor transcription errors.
    
    Input Text:
    "${speechText}"
    
    Your Task:
    1. **Reconstruct:** intelligently add punctuation and capitalization to the raw text for the 'corrected_text'.
    2. **Refine:** Create a 'polite_text' version that is more professional, structured, and formal suitable for a corporate interview.
    3. **Evaluate:** Rate the grammar and sentiment (0-100) based on the clarity of the speech.
    
    Output Format:
    Return purely valid JSON (no markdown, no backticks) with this structure:
    {
        "original_text": "the raw input text",
        "corrected_text": "Grammatically correct version with proper punctuation.",
        "polite_text": "Professional and formal version of the speech.",
        "grammar_score": number 0-100,
        "sentiment_score": number 0-100,
        "improvement_tips": ["Specific tip 1", "Specific tip 2"]
    }`;

    try {
        const model = ai.getGenerativeModel({ model: "gemini-2.5-flash-lite" });
        const result = await model.generateContent(prompt);
        let text = await result.response.text();
        
        // Clean JSON
        text = text.replace(/```json/g, "").replace(/```/g, "").trim();
        console.log("AI Output:", text); 
        
        const data = JSON.parse(text);

        // Display results
        document.getElementById("disp-original").innerText = data.original_text || speechText;
        document.getElementById("disp-corrected").innerText = data.corrected_text;
        document.getElementById("disp-polite").innerText = data.polite_text;
        document.getElementById("grammar-score").innerText = data.grammar_score;
        document.getElementById("sentiment-score").innerText = data.sentiment_score;
        
        let tipsHtml = "<ul>";
        (data.improvement_tips || []).forEach(t => tipsHtml += `<li>${t}</li>`);
        tipsHtml += "</ul>";
        document.getElementById("ai-tips").innerHTML = tipsHtml;

        // Save
        await fetch("save_feedback.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                topic: TOPIC,
                original_text: speechText,
                corrected_text: data.corrected_text,
                polite_text: data.polite_text,
                grammar_score: data.grammar_score,
                sentiment_score: data.sentiment_score,
                improvement_tips: data.improvement_tips
            })
        });

    } catch (e) {
        console.error(e);
        alert("Analysis failed. Error: " + e.message);
    }
});

function leaveRoom() {
    if (navigator.sendBeacon) {
        let data = new FormData();
        data.append('room_id', ROOM_DB_ID);
        navigator.sendBeacon('leave_room.php', data);
    }
}
</script>

</body>
</html>