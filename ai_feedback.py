from flask import Flask, request, jsonify
import whisper
import language_tool_python
from transformers import pipeline
from pydub import AudioSegment
import tempfile
import os

app = Flask(__name__)

# Load AI models
print("Loading AI models...")
stt_model = whisper.load_model("base")  # Speech-to-text
tool = language_tool_python.LanguageTool('en-US')  # Grammar check
sentiment_analyzer = pipeline("sentiment-analysis")  # Sentiment

@app.route('/analyze', methods=['POST'])
def analyze_audio():
    if 'audio' not in request.files:
        return jsonify({"error": "No audio file uploaded"}), 400

    # Save temp file (keep original extension)
    audio_file = request.files['audio']
    ext = os.path.splitext(audio_file.filename)[-1] or ".wav"
    temp_path = tempfile.mktemp(suffix=ext)
    audio_file.save(temp_path)

    # Speech-to-text
    transcription = stt_model.transcribe(temp_path)
    transcript_text = transcription['text']

    # Grammar check
    matches = tool.check(transcript_text)
    grammar_errors = len(matches)
    words_count = len(transcript_text.split())
    grammar_score = max(0, 100 - (grammar_errors / max(1, words_count) * 100))

    # Sentiment analysis
    sentiment_results = sentiment_analyzer(transcript_text)
    sentiment_score = sentiment_results[0]['score'] * 100

    # Speaking time with pydub
    audio = AudioSegment.from_file(temp_path)
    duration = len(audio) / 1000.0  # seconds

    # Improvement tips
    tips = []
    if grammar_score < 80:
        tips.append("Work on grammar accuracy. Practice sentence structuring.")
    if sentiment_score < 50:
        tips.append("Maintain a positive and confident tone.")
    if duration < 60:
        tips.append("Try to speak for longer to express your points clearly.")

    os.remove(temp_path)

    return jsonify({
        "transcript": transcript_text,
        "grammar_score": round(grammar_score, 2),
        "sentiment_score": round(sentiment_score, 2),
        "speaking_time": int(duration),
        "improvement_tips": " ".join(tips)
    })

if __name__ == '__main__':
    app.run(host="0.0.0.0", port=5000)
