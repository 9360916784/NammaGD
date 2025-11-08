<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$type = $_GET['type'] ?? 'tips';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Content library with multiple pages
$content = [
    "tips" => [
        ["TIP 1: Initiation Techniques", 
         "Initiating a GD is a high profit-high loss strategy. When you initiate a GD, you not only grab the opportunity to speak, you also grab the attention of the examiner and your fellow candidates.

If you can make a favorable first impression with your content and communication skills after you initiate a GD, it will help you sail through the discussion. But if you initiate a GD and stammer/ stutter/ quote wrong facts and figures, the damage might be irreparable.

If you initiate a GD impeccably but don't speak much after that, it gives the impression that you started the GD for the sake of starting it or getting those initial kitty of points earmarked for an initiator!

When you start a GD, you are responsible for putting it into the right perspective or framework. So initiate one only if you have in-depth knowledge about the topic at hand."],
        ["TIP 2: Body of The Group Discussion", 
         "Different techniques to initiate a GD and make a good first impressions are:

1. Quotes
2. Definition
3. Question
4. Shock statement
5. Facts, figures and statistics
6. Short story
7. General statement

1. Quotes - are an effective way of initiating a GD.

Example: If the topic of a GD is - Should the Censor Board be abolished? you could start with a quote like, 'Hidden apples are always sweet'. Or if a topic is like, Customer is King, you could quote Sam (Wall-mart) Walton's famous saying, 'There is only one boss: the customer.' And he can fire everybody in the company from the chairman on down, simply by spending his money somewhere else.

2. Definition - Start a GD by defining the topic or an important term in the topic.

Example: If the topic of the GD is Advertising is a Diplomatic Way of Telling a Lie, why not start the GD by defining advertising as, 'Any paid form of non-personal presentation and promotion of ideas, goods or services through mass media like newspapers, magazines, television or radio by an identified sponsor'?

Example: If a topic like The Malthusian Economic Prophecy is no longer relevant, you could start by explaining the definition of the Malthusian Economic Prophecy.

3. Question - Asking a question is an impact way of starting a GD.

It does not signify asking a question to any of the candidates in a GD so as to hamper the flow. It implies asking a question, and answering it yourself. Any question that might hamper the flow of a GD or insult a participant or play devil's advocate must be discouraged.

Questions that promote a flow of ideas are always appreciated. For a topic like, Should India go to war with Pakistan, you could start by asking, 'What does war bring to the people of a nation? We have had four clashes with Pakistan. The pertinent question is: what have we achieved?

4. Shock Statement - Initiating a GD with a shocking statement is the best way to grab immediate attention and put forth your point.

Example: If a GD topic is 'The Impact of Population on the Indian Economy' then you could start with, 'At the center of the Indian capital stands a population clock that ticks away relentlessly. It tracks 33 births a minute, 2,000 an hour, 48,000 a day. It calculates to about 12 million every year. That is roughly the size of Australia. As a current political slogan puts it, 'Nothing's impossible when 1 billion Indians work together.'

5. Facts, figures and statistics - If you decide to initiate your GD with facts, figure and statistics then make sure to quote them accurately.

Approximation is allowed in macro level figures, but micro level figures need to be correct and accurate.

Example: You can say, approximately 70 per cent of the Indian population stays in rural areas (macro figures, approximation allowed), but you cannot say 30 states of India instead of 28 (micro figures, no approximations).

Stating wrong facts works to your disadvantage. For a GD topic like, China, a Rising Tiger, you could start with, 'In 1983, when China was still in its initial stages of reform and opening up, China's real use of Foreign Direct Investment only stood at $636 million. China actually utilized $60 billion of FID in 2004, which is almost 100 times that of its 1983 statistics.'

6. Short Story - Use a short story in a GD topic like 'Attitude is Everything'

Example: This can be initiated with, 'A child once asked a balloon vendor, who was selling helium gas-filled balloons, whether a blue-colored balloon will go as high in the sky as a green-colored balloon. The balloon vendor told the child, it is not the color of the balloon but what is inside it that makes it go high.

7. General Statement - Use a general statement to put the GD in proper perspective

Example: If the topic is Should Sonia Gandhi be the prime minister of India?' You could start by saying, 'Before jumping to conclusions like, 'Yes, Sonia Gandhi should be', or 'No, Sonia Gandhi should not be', let's first find out the qualities one needs to be a good prime minister of India. Then we can compare these qualities with those that Mrs. Gandhi possesses. This will help us reach the conclusion in a more objective and effective manner."],
        ["TIP 3: Summarizing or Concluding", 
         "Most GD's don't really have conclusions. A conclusion is where the whole group decides in favor or against the topic, but every GD is summarized. You can take the opportunity to summaries what the group has discussed in the GD in a nutshell.

Keep the following points in mind while summarizing a discussion:

Avoid raising new points.
Avoid stating only your viewpoint.
Avoid dwelling only on one aspect of the GD.
Keep it brief and concise.
It must incorporate all the important points that came out during the GD.
If the examiner asks you to summaries a GD, it means the GD has come to an end.
Do not add anything once the GD has been summarized."],
        ["TIP 4:", 
         "Always be the initiator and concluder of the Group Discussion then being a participant.

But if you are participant always try to be the most key participant.

Put points firmly and always try to get others support too.

If you find that the discussion is going off the track then never loose an opportunity to bring it back to stream this is the best point to score max.

Try to keep latest information on the topic.

Be very polite, people may try to provoke you to get more points but try to keep cool.

Most important, don't wait for your turn to speak when discussion is on. Interrupt politely if you want to put forward your points.

Last but not the least keep a tab on the time given for discussion. Score points by wrapping up the discussion if you feel that the discussion is heating but the time is going to be over.

During conclusion, do end with the conclusion note.

That shows your leadership quality."]
    ],
    "dosdonts" => [
        ["Be Yourself", 
         "You should try to be as natural as possible. Do not try & be someone you are not."],
        ["Speak Out:", 
         "Make the best of this opportunity, the evaluator wants to hear you speak. A GD is a chance to be more vocal."],
        ["Think before you speak:", 
         "Take time to organize your thoughts. Think of what you are going to say."],
        ["Seek clarification:", 
         "If you are not clear and you have doubts regarding the subject, ask for clarification before the GD begins."],
        ["Be confident before you speak:", 
         "Don't start speaking until you have clearly understood and analyzed the subject."],
        ["Begin smartly:", 
         "Work out various strategies to help you make an entry, initiate the discussion or agree with someone else's point and then move onto express your views."],
        ["Adding valuable thoughts:", 
         "Opening the discussion is not the only way of gaining attention and recognition. If you do not give valuable insights during the discussion, all your efforts of initiating the discussion will be in vain."],
        ["Good body language:", 
         "Your body language says a lot about you your gestures and mannerisms are more likely to reflect your attitude than what you say."],
        ["Usage of effective language:", 
         "Language skills are important only to the effect as to how you get your points across clearly and fluently."],
        ["Maintain your tone while communicating:", 
         "Be assertive not dominating; try to maintain a balanced tone in your discussion and analysis."],
        ["Be Patience", 
         "Don't lose your cool if anyone says anything you object to. The key is to stay objective: Don't take the discussion personally."],
        ["Be polite:", 
         "Try to avoid using extreme phrases like: `I strongly object' or 'I disagree'. Instead try phrases like: `I would like to share my views on... or 'One difference between your point and mine... or 'I beg to differ with you'"],
        ["Motivating others to speak:", 
         "This will demonstrate your leadership skills. You may motivate the other team members to speak but you need to identify the right time to do that. Also, don't keep repeating the same thing as you may lose your time to speak and this may show too much of leadership. Be receptive to others opinions and do not be abrasive or aggressive."],
        ["Practice:", 
         "If you have a group of like-minded friends, you can have a mock group discussion where you can learn from each other through giving and receiving feedback.

Apart from the above points, the panel will also judge team members for their alertness and presence of mind, problem-solving abilities, ability to work as a team without alienating certain members, and creativity."],
        ["Do's", 
         "✔ Listen to others. It is not necessary to initiate a Group Discussion.
✔ Initiate the discussion if you are familiar with the topic.
✔ Intervene if the discussion is turning out to be hostile.It
✔ reflects your leadership.
✔ Speak to the point without Repeating.
✔ Back your points with Facts and Figures.
✔ Be gentle with your presentation.
✔ Be Natural, Calm and Maintain your Composure.
✔ Be Participative and Reciprocative.
✔ Say 'Thank You' before ending your presentation.
✔ Think before you speak.
✔ Say what you feel, without going in 'Favour'/'Against'."],
        ["Don'ts", 
         "✘ Do not be loud or aggressive.
✘ Do not go overboard with enthusiasm if you are familiar with the topic.
✘ Do not interrupt other speakers.
✘ Do not deprecate other speakers.
✘ Do not speak first if you are unfamiliar with the topic.
✘ Grab the opportunity to speak, you also grab the attention of the examiner and your fellow candidates.
✘ Do not change your opinions.
✘ Do not ask irrelevant questions.
✘ Do not stop abruptly.
✘ Do not get nervous if the previous speakers have presented their points in a better way.
✘ Do not exhibit your emotions.
         "]
    ],
    "faqs" => [
        ["FAQ 1", "Q: How do I prepare for a GD?\nA: Stay updated with current affairs and practice speaking in groups."],
        ["FAQ 2", "Q: What if I get nervous?\nA: Take a deep breath, start with simple points, and gradually build confidence."]
    ],
    "mistakes" => [
        ["Mistake 1", "Speaking too fast or too slow can confuse the panel."],
        ["Mistake 2", "Quoting wrong facts reduces your credibility."],
        ["Mistake 3", "Staying silent throughout the GD shows lack of initiative."]
    ],
    "phrases" => [
        ["Phrase 1", "‘I would like to add to that point…’"],
        ["Phrase 2", "‘From my perspective…’"],
        ["Phrase 3", "‘I respectfully disagree because…’"]
    ],
    "skills" => [
        ["Skill 1", "Active Listening: Pay attention and respond appropriately."],
        ["Skill 2", "Body Language: Maintain a confident posture."],
        ["Skill 3", "Time Management: Speak enough, but don’t over-talk."]
    ],
    "howtoface" => [
        ["Step 1", "Stay calm, greet politely, and maintain eye contact."],
        ["Step 2", "Start strong with relevant facts or examples."],
        ["Step 3", "Contribute meaningfully without dominating."],
        ["Step 4", "Summarize key points if given the opportunity."]
    ]
];

// Validate content type
if (!isset($content[$type])) {
    $type = "tips"; 
    $page = 1;
}

// Total pages in selected category
$totalPages = count($content[$type]);

// Keep page number within range
if ($page < 1) $page = 1;
if ($page > $totalPages) $page = $totalPages;

// Current page content
$current = $content[$type][$page - 1];
$title = $current[0];
$body = $current[1];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Confident Speaking Content</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .nav-btn {
      width: 120px;
    }
  </style>
</head>
<body class="bg-light">

<div class="container mt-4">
  <a href="confident_speaking.php" class="btn btn-secondary mb-3">&larr; Back</a>

  <div class="card shadow p-4">
    <h3 class="mb-3"><?= htmlspecialchars($title) ?></h3>
    <p style="white-space: pre-line;"><?= htmlspecialchars($body) ?></p>

    <div class="d-flex justify-content-between mt-4">
      <a href="?type=<?= $type ?>&page=<?= max(1, $page - 1) ?>" 
         class="btn btn-outline-primary nav-btn <?= ($page == 1) ? 'disabled' : '' ?>">Previous</a>

      <span class="align-self-center">Page <?= $page ?> / <?= $totalPages ?></span>

      <a href="?type=<?= $type ?>&page=<?= min($totalPages, $page + 1) ?>" 
         class="btn btn-outline-primary nav-btn <?= ($page == $totalPages) ? 'disabled' : '' ?>">Next</a>
    </div>
  </div>
</div>

</body>
</html>
