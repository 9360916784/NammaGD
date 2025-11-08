<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include "connection.php";

// Fetch random GD topic
$topic_sql = "SELECT topic FROM gd_topics ORDER BY RAND() LIMIT 1";
$topic_result = mysqli_query($conn, $topic_sql);
$topic_row = mysqli_fetch_assoc($topic_result);
$gd_topic = $topic_row['topic'] ?? "No topics available. Please add topics in admin panel.";
$_SESSION['gd_topic'] = $gd_topic;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Practice GD - Namma GD</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
  <style>
    video { width: 100%; height: auto; background: black; border-radius:8px; }
    #video-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 10px; }
    #transcript { font-family: monospace; white-space: pre-wrap; }
    .highlight-filler { color: red; font-weight: bold; }
    .highlight-positive { color: green; font-weight: bold; }
    .highlight-grammar { background-color: yellow; }
    #feedback-box { display: none; margin-top: 20px; }
    .transcript-block { background: #f8f9fa; padding: 10px; border-radius: 8px; margin-bottom: 10px; font-family: monospace; }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><i class="bi bi-chat"></i> Namma GD</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="learning.php">Learning Module</a></li>
        <li class="nav-item"><a class="nav-link active" href="practice.php">Practice GD</a></li>
        <li class="nav-item"><a class="nav-link" href="feedback.php">My Feedback</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Topic -->
<div class="container my-4">
  <h2 class="text-center">Today's GD Topic</h2>
  <div class="alert alert-info text-center fs-5">
    <?php echo htmlspecialchars($gd_topic); ?>
  </div>
</div>

<!-- Video -->
<div class="container">
  <div id="video-grid"></div>
</div>

<!-- Transcript -->
<div class="container mt-3">
  <h4>Live Transcript</h4>
  <div id="transcript" class="form-control p-3" style="min-height:150px; overflow-y:auto;"></div>
</div>

<!-- Feedback -->
<div class="container mt-4" id="feedback-box">
  <h4>AI Feedback</h4>
  <div class="card p-3 shadow-sm">
    <p><strong>Grammar Score:</strong> <span id="grammar-score"></span></p>
    <p><strong>Sentiment Score:</strong> <span id="sentiment-score"></span></p>
    <p><strong>Speaking Time:</strong> <span id="speaking-time"></span> sec</p>

    <h5>Transcript Comparison</h5>
    <div class="transcript-block"><strong>Original:</strong><br><span id="original-text"></span></div>
    <div class="transcript-block"><strong>Corrected:</strong><br><span id="corrected-text"></span></div>
    <div class="transcript-block"><strong>Polite Recommended:</strong><br><span id="polite-text"></span></div>

    <h5>Improvement Tips</h5>
    <ul id="improvement-tips"></ul>
  </div>
</div>

<!-- Controls -->
<div class="container text-center mt-3">
  <button id="start-btn" class="btn btn-success"><i class="bi bi-camera-video"></i> Start GD</button>
  <button id="stop-btn" class="btn btn-danger" disabled><i class="bi bi-stop-circle"></i> End GD</button>
</div>

<footer class="bg-dark text-light py-3 text-center mt-4">
  <p class="mb-0">&copy; <?php echo date('Y'); ?> Namma GD | AI-Powered Group Discussion Platform</p>
</footer>

<!-- Socket.IO client + Gemini -->
<script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
<script type="module">
import { GoogleGenerativeAI } from "https://esm.run/@google/generative-ai";

// --- CONFIG ---
// Replace this with your deployed Render/Glitch/Ngrok URL (without trailing slash)
const SIGNALING_SERVER_URL = "https://nammagd-hosting.onrender.com"; // <-- REPLACE
const API_KEY = "AIzaSyDDKrioKsUFVLPz-R4RLpBV7uyBnZa7bAU";
const ai = new GoogleGenerativeAI(API_KEY);

// --- DOM ---
const videoGrid = document.getElementById('video-grid');
const startBtn = document.getElementById('start-btn');
const stopBtn = document.getElementById('stop-btn');
const transcriptBox = document.getElementById('transcript');

let localStream = null;
let recognition = null;
let finalTranscript = "";
let socket = null;
const peers = {}; // RTCPeerConnections by socketId
const remoteVideos = {}; // video elements by socketId

// STUN servers help with NAT traversal
const RTC_CONFIG = {
  iceServers: [
    { urls: "stun:stun.l.google.com:19302" },
    { urls: "stun:global.stun.twilio.com:3478?transport=udp" }
  ]
};

// highlight function (unchanged)
function highlightText(text) {
  return text
    .replace(/\b(uh|um)\b/gi, '<span class="highlight-filler">$1</span>')
    .replace(/\b(good|excellent|great|well done)\b/gi, '<span class="highlight-positive">$1</span>')
    .replace(/\b(is are|was were)\b/gi, '<span class="highlight-grammar">$1</span>');
}

// attach stream to video element
function addVideoStreamEl(stream, muted=false, id=null) {
  const video = document.createElement('video');
  video.autoplay = true;
  video.playsInline = true;
  video.srcObject = stream;
  video.muted = muted;
  video.addEventListener('loadedmetadata', () => video.play());
  if (id) {
    // tag video
    video.dataset.peer = id;
    remoteVideos[id] = video;
  }
  videoGrid.appendChild(video);
  return video;
}

// create RTCPeerConnection and attach handlers
function createPeerConnection(remoteId) {
  const pc = new RTCPeerConnection(RTC_CONFIG);

  // add local tracks
  if (localStream) {
    localStream.getTracks().forEach(track => pc.addTrack(track, localStream));
  }

  // when remote track arrives
  pc.ontrack = (e) => {
    // e.streams[0] is the remote MediaStream
    if (!remoteVideos[remoteId]) {
      addVideoStreamEl(e.streams[0], false, remoteId);
    }
  };

  // ICE candidate -> send to other peer via signaling
  pc.onicecandidate = (event) => {
    if (event.candidate) {
      socket.emit("candidate", event.candidate, remoteId);
    }
  };

  return pc;
}

// Start GD (join room & set up signaling)
startBtn.addEventListener('click', async () => {
  startBtn.disabled = true;
  stopBtn.disabled = false;

  // get media
  try {
    localStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
  } catch (err) {
    alert("Camera/microphone access denied.");
    startBtn.disabled = false;
    stopBtn.disabled = true;
    return;
  }

  // show local video (muted)
  addVideoStreamEl(localStream, true, "local");

  // connect to signaling server
  socket = io(SIGNALING_SERVER_URL, { transports: ["websocket"] });

  // join a room — using a simple room name derived from topic (safe)
  const ROOM = "gd_room_" + encodeURIComponent("<?php echo addslashes($gd_topic); ?>").slice(0,50);

  socket.on("connect", () => {
    console.log("connected to signaling server:", socket.id);
    socket.emit("join-room", ROOM);
  });

  // someone connected -> we should create peer connection and offer
  socket.on("user-connected", async (id) => {
    console.log("user-connected", id);
    // create peer
    const pc = createPeerConnection(id);
    peers[id] = pc;

    // create offer
    const offer = await pc.createOffer();
    await pc.setLocalDescription(offer);

    // send to remote
    socket.emit("offer", offer, id);
  });

  // when receiving an offer
  socket.on("offer", async (offer, fromId) => {
    console.log("offer from", fromId);
    const pc = createPeerConnection(fromId);
    peers[fromId] = pc;
    await pc.setRemoteDescription(offer);
    const answer = await pc.createAnswer();
    await pc.setLocalDescription(answer);
    socket.emit("answer", answer, fromId);
  });

  // when receiving an answer
  socket.on("answer", async (answer, fromId) => {
    console.log("answer from", fromId);
    const pc = peers[fromId];
    if (pc) {
      await pc.setRemoteDescription(answer);
    }
  });

  // ICE candidates
  socket.on("candidate", async (candidate, fromId) => {
    const pc = peers[fromId];
    if (pc && candidate) {
      try {
        await pc.addIceCandidate(candidate);
      } catch (e) {
        console.warn("Error adding candidate", e);
      }
    }
  });

  // user disconnected
  socket.on("user-disconnected", (id) => {
    console.log("user-disconnected", id);
    if (peers[id]) {
      peers[id].close();
      delete peers[id];
    }
    // remove remote video
    const v = remoteVideos[id];
    if (v && v.parentNode) v.parentNode.removeChild(v);
  });

  // Start speech recognition (same as before)
  window.SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
  recognition = new SpeechRecognition();
  recognition.lang = "en-US";
  recognition.interimResults = true;
  recognition.continuous = true;

  recognition.onresult = (e) => {
    let interim = '';
    for (let i = e.resultIndex; i < e.results.length; ++i) {
      if (e.results[i].isFinal) finalTranscript += e.results[i][0].transcript + ' ';
      else interim += e.results[i][0].transcript;
    }
    transcriptBox.innerHTML = highlightText(finalTranscript + interim);
  };
  recognition.start();
});

// Stop GD / End session (send transcript to Gemini as before)
stopBtn.addEventListener('click', async () => {
  stopBtn.disabled = true;
  startBtn.disabled = false;

  if (recognition) recognition.stop();
  if (localStream) localStream.getTracks().forEach(t => t.stop());
  // close peer connections
  Object.values(peers).forEach(pc => pc.close());
  // disconnect signaling socket
  if (socket) {
    socket.emit("leave-room", ""); // optional
    socket.disconnect();
    socket = null;
  }

  // clear video grid
  document.getElementById('video-grid').innerHTML = '';

  const gdText = finalTranscript.trim();
  if (!gdText) return alert("No speech detected!");

  // Build prompt (same as before)
  const prompt = `
You are an AI language coach. Analyze this transcript:

${gdText}

Return ONLY JSON (no explanations, no markdown):
{
  "original_text": "original transcript",
  "corrected_text": "grammar corrected transcript",
  "polite_text": "polite professional rewrite",
  "grammar_score": number 0-100,
  "sentiment_score": number 0-100,
  "improvement_tips": ["tip1", "tip2", "tip3"]
}`;

  try {
    const model = ai.getGenerativeModel({ model: "gemini-2.0-flash" });
    const result = await model.generateContent(prompt);
    let reply = result.response.text();
    reply = reply.replace(/```json|```/g, "").trim();
    const data = JSON.parse(reply);

    // Show feedback (same display)
    document.getElementById("feedback-box").style.display = "block";
    document.getElementById("grammar-score").innerText = data.grammar_score;
    document.getElementById("sentiment-score").innerText = data.sentiment_score;
    document.getElementById("speaking-time").innerText = Math.round(gdText.length / 5);
    document.getElementById("original-text").innerText = data.original_text;
    document.getElementById("corrected-text").innerText = data.corrected_text;
    document.getElementById("polite-text").innerText = data.polite_text;

    const tipsList = document.getElementById("improvement-tips");
    tipsList.innerHTML = "";
    (data.improvement_tips || []).forEach(tip => {
      const li = document.createElement("li");
      li.innerText = tip;
      tipsList.appendChild(li);
    });

    // Save feedback to your PHP save endpoint (same payload as previous)
    await fetch("save_feedback.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        topic: "<?php echo addslashes($gd_topic); ?>",
        original_text: data.original_text,
        corrected_text: data.corrected_text,
        polite_text: data.polite_text,
        grammar_score: data.grammar_score,
        sentiment_score: data.sentiment_score,
        improvement_tips: data.improvement_tips
      })
    });

  } catch (err) {
    console.error("Gemini Error:", err);
    alert("Failed to analyze feedback.");
  }
});
</script>
</body>
</html>
