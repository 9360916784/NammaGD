-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2025 at 04:55 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `namma_gd`
--

-- --------------------------------------------------------

--
-- Table structure for table `active_gd_rooms`
--

CREATE TABLE `active_gd_rooms` (
  `id` int(11) NOT NULL,
  `topic` varchar(255) NOT NULL,
  `participants` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','completed') DEFAULT 'active',
  `host_id` int(11) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `active_gd_rooms`
--

INSERT INTO `active_gd_rooms` (`id`, `topic`, `participants`, `created_at`, `status`, `host_id`, `start_time`) VALUES
(1, 'Smart Cities: A dream or a distant reality?', 0, '2025-12-17 06:17:43', 'completed', 11, NULL),
(2, 'Online Education vs Traditional Classroom Learning', 0, '2025-12-17 06:23:46', 'completed', 10, NULL),
(3, 'Impact of Artificial Intelligence on Jobs', 0, '2025-12-17 06:25:39', 'completed', 10, NULL),
(4, 'Is Work from Home the future of corporate culture?', 0, '2025-12-17 06:26:29', 'completed', 11, NULL),
(5, 'Cryptocurrencies: The future of finance or a bubble?', 0, '2025-12-17 06:27:23', 'completed', 11, NULL),
(6, 'Sustainable Development vs Industrial Growth', 0, '2025-12-17 06:28:13', 'completed', 11, NULL),
(7, 'Cryptocurrencies: The future of finance or a bubble?', 3, '2025-12-18 02:44:38', 'active', 12, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `subject`, `message`) VALUES
(1, 'Ajay', 'ajay@gmail.com', 'qdeeas', 'dsgffhgjhmhjm'),
(4, 'Kishore M', 'k9346572kishore@gmail.com', 'bv', 'asdfghjkl');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'Rahul', 'rahul@gmail.com', 'creating account', 'I want to create an new account', '2025-12-18 03:04:44');

-- --------------------------------------------------------

--
-- Table structure for table `gd_feedback`
--

CREATE TABLE `gd_feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `topic` varchar(255) DEFAULT NULL,
  `transcript` longtext DEFAULT NULL,
  `grammar_score` int(11) DEFAULT NULL,
  `sentiment_score` int(11) DEFAULT NULL,
  `speaking_time` int(11) DEFAULT NULL,
  `improvement_tips` text DEFAULT NULL,
  `session_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gd_feedback`
--

INSERT INTO `gd_feedback` (`id`, `user_id`, `topic`, `transcript`, `grammar_score`, `sentiment_score`, `speaking_time`, `improvement_tips`, `session_date`) VALUES
(1, 11, 'Smart Cities: A dream or a distant reality?', 'and hello friends this is Kishore and the today topic is smart cities at dream or distinct reality I think the Smart City or the reality where the new companies like eco friendly come please or already being a taking a initiative that it should be a smart which are using sensors that uses the day today like more efficient and more compactable to our living standard and need to increase the eco friendly and helps them to achieve the rule and I think I will send this reality and I does working and end up the station and you get the feedback thank you\n\nCorrected: Hello friends, this is Kishore. Today\'s topic is \'Smart Cities: A dream or a distant reality?\' I think smart cities are a reality where new companies, like eco-friendly ones, are already taking initiatives. They should be smart by using sensors that make our day-to-day lives more efficient and compatible with our living standards. We need to increase eco-friendliness and help achieve the goal. I believe this is a reality. I will send this feedback. Thank you.\n\nPolite: Good morning/afternoon, everyone. My name is Kishore. Today, we are discussing the topic of \'Smart Cities: A dream or a distant reality?\'. In my opinion, smart cities are indeed becoming a reality. We are already witnessing initiatives from companies focused on eco-friendly solutions. The integration of sensors is crucial for enhancing efficiency and making our daily lives more adaptable to our living standards. Furthermore, promoting eco-friendliness will play a significant role in achieving our collective goals. I firmly believe that this is a tangible reality we are working towards. I would like to conclude my thoughts and look forward to the feedback. Thank you.', 65, 80, 111, 'Practice clear enunciation to minimize transcription errors.\nUse transition words to connect ideas more smoothly (e.g., \'furthermore\', \'in addition\', \'however\').\nAvoid filler words like \'and\' and \'like\' between sentences or ideas.\nStructure your thoughts more logically with a clear introduction, body, and conclusion.\nEnsure consistent use of vocabulary and sentence structure.', '2025-12-17 11:53:06'),
(2, 11, 'Online Education vs Traditional Classroom Learning', 'yes Pradeep ok you are right\n\nCorrected: Yes Pradeep, okay, you are right.\n\nPolite: I agree with your point, Pradeep. You\'ve made a valid observation.', 85, 90, 6, 'Consider using slightly more formal transition words when agreeing, like \'I agree\' or \'That\'s a good point\'.\nWhile \'okay\' is informal, in a GD setting it can be used. However, consider alternatives like \'indeed\' or \'certainly\' for greater professionalism.\nEnsure clear pauses between distinct thoughts. Adding commas aids this.', '2025-12-17 11:55:17'),
(3, 10, 'Is Work from Home the future of corporate culture?', 'hello it is a testing where is working perfectly or not and it is the topic us is work from home of the future of Corporate culture or not I think it is the work from home as the corporate culture resources\n\nCorrected: Hello, is this working perfectly or not? And the topic is, \'Is work from home the future of corporate culture or not?\' I think work from home is the future of corporate culture.\n\nPolite: Good morning/afternoon. I\'d like to begin by addressing the topic: \'Is work from home the future of corporate culture?\' In my opinion, work from home presents a significant shift and indeed, I believe it is the future direction for corporate culture.', 75, 70, 41, 'Begin with a clear greeting and statement of purpose.\nUse complete sentences and avoid run-on constructions.\nClearly state your opinion on the topic.\nPractice enunciation to reduce potential transcription errors.', '2025-12-17 11:57:15'),
(4, 11, 'Sustainable Development vs Industrial Growth', 'yes brother I think development of the environment helps The Peoples to conserve the console the resources next generation where I\n\nCorrected: Yes, brother, I think development of the environment helps the people to conserve the resources for the next generation. Where I...\n\nPolite: Certainly, I believe that environmental development is crucial for enabling people to conserve resources for future generations.', 45, 70, 26, 'Avoid informal address like \'brother\'. Use more professional salutations or direct statements.\nClarify the phrase \'conserve the console the resources\'. It seems like a transcription error for \'conserve resources\'.\nComplete your sentences. The statement trails off at \'where I\', leaving the thought unfinished.\nEnsure clear enunciation to avoid transcription errors that affect meaning.', '2025-12-17 11:59:40'),
(5, 10, 'Sustainable Development vs Industrial Growth', 'good afternoon GD project a topic is sustainable development versus industrial go I think sustainable development sustaining our Assets and properties to the next generation I think can you speak about\n\nCorrected: Good afternoon. GD, project. The topic is sustainable development versus industrial growth. I think sustainable development means sustaining our assets and properties for the next generation. I think... can you speak about...\n\nPolite: Good afternoon, everyone. Our topic for this GD project is \'Sustainable Development versus Industrial Growth\'. My initial thought is that sustainable development involves ensuring the preservation of our assets and resources for future generations. Perhaps we can delve deeper into...', 45, 60, 40, 'Ensure clear topic introduction.\nSeparate sentences with appropriate punctuation (periods, commas).\nCapitalize the beginning of sentences and proper nouns.\nAvoid trailing phrases like \'can you speak about\' if you are not directly asking someone at that moment; it suggests an unfinished thought or a rhetorical question within your own statement.\nConsider using transition words to connect ideas more smoothly.', '2025-12-17 11:59:43');

-- --------------------------------------------------------

--
-- Table structure for table `gd_rooms`
--

CREATE TABLE `gd_rooms` (
  `id` int(11) NOT NULL,
  `topic` varchar(255) DEFAULT NULL,
  `room_code` varchar(10) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gd_rooms`
--

INSERT INTO `gd_rooms` (`id`, `topic`, `room_code`, `created_by`, `created_at`) VALUES
(1, 'Electric Vehicles: Future or Hype?', 'HGWT4J', 1, '2025-10-03 04:23:37'),
(2, 'Is Social Media Making Us Less Social?', '94a543', 1, '2025-10-07 16:51:55'),
(3, 'Climate Change and Its Global Impact', '78101c', 1, '2025-10-08 06:39:31'),
(4, 'Impact of Artificial Intelligence on Jobs', '469d87', 1, '2025-10-10 06:25:21'),
(5, 'Climate Change and Its Global Impact', '063960', 1, '2025-10-10 06:25:28'),
(7, 'Is Social Media Making Us Less Social?', '3d7a06', 1, '2025-10-10 06:25:29');

-- --------------------------------------------------------

--
-- Table structure for table `gd_room_members`
--

CREATE TABLE `gd_room_members` (
  `id` int(11) NOT NULL,
  `room_code` varchar(10) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gd_room_members`
--

INSERT INTO `gd_room_members` (`id`, `room_code`, `user_id`, `joined_at`) VALUES
(1, 'HGWT4J', 1, '2025-10-03 04:23:37'),
(2, 'HGWT4J', 1, '2025-10-03 08:24:54'),
(3, 'HGWT4J', 1, '2025-10-03 08:25:27'),
(4, 'HGWT4J', 6, '2025-10-03 08:26:22'),
(5, '94a543', 1, '2025-10-07 16:51:55'),
(6, '78101c', 1, '2025-10-08 06:39:31'),
(7, '469d87', 1, '2025-10-10 06:25:21'),
(8, '063960', 1, '2025-10-10 06:25:28'),
(9, '063960', 1, '2025-10-10 06:25:28'),
(10, '3d7a06', 1, '2025-10-10 06:25:29'),
(11, '78101c', 1, '2025-10-10 06:25:29'),
(12, '78101c', 1, '2025-10-10 06:25:30'),
(13, '78101c', 1, '2025-10-10 06:25:30'),
(14, '78101c', 1, '2025-10-10 06:25:33'),
(15, '78101c', 1, '2025-10-10 06:25:33'),
(16, '78101c', 1, '2025-10-10 06:25:34'),
(17, '78101c', 1, '2025-10-10 06:27:36'),
(18, '78101c', 1, '2025-10-10 06:27:54'),
(19, '78101c', 1, '2025-10-10 06:27:55'),
(20, '78101c', 1, '2025-10-10 06:27:58'),
(21, '78101c', 1, '2025-10-10 06:27:59'),
(22, '78101c', 1, '2025-10-10 06:28:00'),
(23, '78101c', 1, '2025-10-10 06:28:01'),
(24, '78101c', 1, '2025-10-10 06:28:04');

-- --------------------------------------------------------

--
-- Table structure for table `gd_topics`
--

CREATE TABLE `gd_topics` (
  `id` int(11) NOT NULL,
  `topic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gd_topics`
--

INSERT INTO `gd_topics` (`id`, `topic`) VALUES
(1, 'Impact of Artificial Intelligence on Jobs'),
(2, 'Is Work from Home the future of corporate culture?'),
(3, 'Social Media: A boon or a bane for society?'),
(4, 'Cryptocurrencies: The future of finance or a bubble?'),
(5, 'The rise of the Gig Economy: Freedom or insecurity?'),
(6, 'Can we achieve a $5 Trillion economy by 2030?'),
(7, 'Electric Vehicles: Are we ready for the transition?'),
(8, 'Data Privacy: Is it a myth in the digital age?'),
(9, 'The impact of 5G technology on global connectivity'),
(10, 'Climate Change: Is it already too late to act?'),
(11, 'Mental Health awareness in the workplace'),
(12, 'Women Empowerment: Are we seeing real change?'),
(13, 'Online Education vs Traditional Classroom Learning'),
(14, 'Brain Drain: How can developing nations retain talent?'),
(15, 'Universal Basic Income: A necessity or a disincentive?'),
(16, 'The Ethics of Gene Editing and Designer Babies'),
(17, 'Censorship on OTT Platforms: Necessary or restricting freedom?'),
(18, 'Moonlighting in the IT sector: Ethical or not?'),
(19, 'Sustainable Development vs Industrial Growth'),
(20, 'Space Exploration: Is it a waste of money?'),
(21, 'The role of Youth in Politics'),
(22, 'Cashless Economy: Pros and Cons'),
(23, 'Automation in Healthcare: Doctor vs Machine'),
(24, 'Influencer Marketing: Authentic or Deceptive?'),
(25, 'Smart Cities: A dream or a distant reality?'),
(26, 'Nuclear Energy: The answer to the energy crisis?'),
(27, 'The Metaverse: The next big thing or just hype?'),
(28, 'Should voting be made mandatory in democracies?'),
(29, 'Globalization: Has it reduced or increased inequality?'),
(30, 'The importance of Emotional Intelligence (EQ) over IQ');

-- --------------------------------------------------------

--
-- Table structure for table `gd_videos`
--

CREATE TABLE `gd_videos` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gd_videos`
--

INSERT INTO `gd_videos` (`id`, `title`, `youtube_url`) VALUES
(1, 'How to practice Group Discussion??', 'https://youtu.be/frRsRZG9XvM?si=huOVXUvAQI9LJJas'),
(2, 'Group Discussion V/s Group Task | GD vs GT', 'https://youtu.be/tFhVkFQ9lJ0?si=z0QQefbEuUOX4E0V'),
(3, 'Don\'t Fear GD or GT | GD & GT very Simple', 'https://youtu.be/YIyy-4YqL8s?si=w800By2Uf-5ZgbAr'),
(4, 'Can Group Discussion be done in Mother language??', 'https://youtu.be/TwmlrcCIUH4?si=t6obCOLpcbgk7vpN'),
(5, 'How to counter someone in GD | Everyone shouting in GD what to do', 'https://youtu.be/uet99eZT61E?si=wfU40yNb5wGaRDj0'),
(6, 'Best way to cut someone in GD (Problem resolved) | How to CUT someone in GD', 'https://youtu.be/s3OgDLZ_TAw?si=UPsXKriC0EkQ1MKb'),
(7, 'Best way to conclude GD', 'https://youtu.be/KLljrdRT19A?si=LO5jl0lFRqrBUir8'),
(8, '10 GD\'s will make you Perfect | How many number of GD\'s required to practice', 'https://youtu.be/90Pz6b90fHE?si=PRFrhQSGWUJDUdPJ'),
(9, 'Follow the structure in GD', 'https://youtu.be/aA5iV8waHC8?si=OEMohnTVQhWsZJ28'),
(10, 'How to introduce in GD | How Important is to introduce in GD', 'https://youtu.be/zVnk8VEMz7g?si=D4OlMhB426lze738'),
(11, 'How much to speak in GD?? | Do we need to speak every time in GD??', 'https://youtu.be/SIBVoF4-2yg?si=uCWvHcGQVutIu4H5'),
(12, 'Daily GD for One week and u will be perfect', 'https://youtu.be/SbbuuHjBSyI?si=tQQS6RUvLOn5kPzf'),
(13, 'Perfect starting lines in GD Introduction | How to start GD', 'https://youtu.be/JOYveHHEcH4?si=k3EjKzEyJ82NHDLc'),
(14, 'Don\'t know about topic in GD | Don\'t worry', 'https://youtu.be/Sf6QsnAvYTA?si=9o2oyuplPna1_ZKu'),
(15, 'How GD is different from GT | PSU HPCL | GD vs GT', 'https://youtu.be/IxW3NoYepJA?si=MeRcITXKOtsgtKFP');

-- --------------------------------------------------------

--
-- Table structure for table `learning_topics`
--

CREATE TABLE `learning_topics` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('video','article','quiz') NOT NULL,
  `file_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `learning_topics`
--

INSERT INTO `learning_topics` (`id`, `title`, `description`, `type`, `file_url`) VALUES
(1, 'Basics of Group Discussion', 'Introduction to GD structure, do’s and don’ts.', 'video', 'videos/gd_basics.mp4'),
(2, 'Tips for Confident Speaking', 'Improve your public speaking skills.', 'article', 'articles/confident_speaking.pdf'),
(3, 'GD Practice Quiz 1', 'Test your GD knowledge.', 'quiz', 'quiz.php?id=1');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_levels`
--

CREATE TABLE `quiz_levels` (
  `id` int(11) NOT NULL,
  `level_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_levels`
--

INSERT INTO `quiz_levels` (`id`, `level_name`, `description`) VALUES
(1, 'Level 1: Basics', 'Introduction to GDs: Purpose, basic rules, and communication fundamentals.'),
(2, 'Level 2: Etiquette', 'Focus on professional behavior, body language, and polite interruptions.'),
(3, 'Level 3: Structure', 'Understanding the opening, body, and conclusion phases of a discussion.'),
(4, 'Level 4: Roles & Responsibilities', 'Learning roles like Initiator, Moderator, and Summarizer.'),
(5, 'Level 5: Intermediate', 'Building coherent arguments and handling common factual topics.'),
(6, 'Level 6: Active Listening', 'Techniques for listening effectively and building upon others\' points.'),
(7, 'Level 7: Conflict Resolution', 'Strategies for managing disagreements and steering the discussion back on track.'),
(8, 'Level 8: Advanced', 'Tackling abstract topics and complex critical thinking scenarios.'),
(9, 'Level 9: Leadership', 'Demonstrating leadership, encouraging participation, and driving consensus.'),
(10, 'Level 10: Mastery', 'High-pressure simulations and expert-level analysis of group dynamics.');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_progress`
--

CREATE TABLE `quiz_progress` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `score` int(11) DEFAULT 0,
  `status` enum('locked','unlocked','completed') DEFAULT 'locked',
  `attempts` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_progress`
--

INSERT INTO `quiz_progress` (`id`, `user_id`, `level_id`, `score`, `status`, `attempts`) VALUES
(11, 10, 1, 0, 'unlocked', 0),
(12, 11, 1, 0, 'unlocked', 0),
(13, 12, 1, 0, 'unlocked', 0);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `option_a` varchar(255) DEFAULT NULL,
  `option_b` varchar(255) DEFAULT NULL,
  `option_c` varchar(255) DEFAULT NULL,
  `option_d` varchar(255) DEFAULT NULL,
  `correct_option` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_questions`
--

INSERT INTO `quiz_questions` (`id`, `level_id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`) VALUES
(21, 1, 'What is the primary purpose of a Group Discussion (GD)?', 'To defeat others in an argument', 'To evaluate communication and teamwork skills', 'To show off your vocabulary', 'To speak the loudest', 'B'),
(22, 1, 'In a standard GD, how many participants are typically there?', '2-3', '8-15', '50-100', '1 only', 'B'),
(23, 1, 'Which of these is a key skill assessed in a GD?', 'Coding ability', 'Singing', 'Leadership & Teamwork', 'Memorization', 'C'),
(24, 1, 'What is the best way to start your speech in a GD?', 'By shouting to get attention', 'By greeting the group and introducing the topic', 'By attacking someone else\'s point', 'By staying silent', 'B'),
(25, 1, 'Is it mandatory to speak first in a GD to get selected?', 'Yes, always', 'No, quality matters more than timing', 'Yes, otherwise you fail', 'No, you should always speak last', 'B'),
(26, 1, 'What language is typically used in professional GDs in India?', 'Local dialect only', 'Formal English', 'Texting slang (LOL, BRB)', 'Whatever you like', 'B'),
(27, 1, 'What should you do if you don\'t know much about the topic?', 'Stay silent throughout', 'Listen to others first, then build on their points', 'Lie and make up facts', 'Walk out of the room', 'B'),
(28, 1, 'A GD is different from a debate because:', 'In a GD, you must agree with everyone', 'In a debate, you argue for/against; in a GD, you discuss to reach a consensus', 'Debates are informal', 'There is no difference', 'B'),
(29, 1, 'The typical duration of a GD is usually around:', '2 hours', '10-20 minutes', '30 seconds', '5 minutes', 'B'),
(30, 1, 'Who usually selects the topic in a recruitment GD?', ' The candidates vote', 'The moderator/panelist', 'The loudest person', 'No one, you talk about anything', 'B'),
(31, 2, 'What is the appropriate volume to speak in a GD?', 'Shouting to dominate', 'Whispering to show humbleness', 'Audible and clear to everyone', 'Mumbling', 'C'),
(32, 2, 'Which body language sign indicates confidence?', 'Slouching in the chair', 'Making eye contact with group members', 'Crossing arms tightly', 'Looking at the floor', 'B'),
(33, 2, 'How should you sit during a GD?', 'Leaning back comfortably', 'Leaning forward slightly to show interest', 'Turning your chair away', 'Putting legs on the table', 'B'),
(34, 2, 'If someone is speaking, you should:', 'Interrupt immediately', 'Listen actively and nod', 'Check your phone', 'Prepare your next point and ignore them', 'B'),
(35, 2, 'Is pointing fingers at others acceptable in a GD?', 'Yes, it shows dominance', 'No, it is aggressive', 'Yes, if they are wrong', 'Only if you are the leader', 'B'),
(36, 2, 'What is the polite way to interrupt someone?', 'Shut up!', 'I disagree completely', 'Excuse me, I would like to add a point...', 'You are wrong!', 'C'),
(37, 2, 'When speaking, who should you look at?', 'Only the moderator', 'Only your friends', 'The entire group', 'The ceiling', 'C'),
(38, 2, 'Chewing gum during a GD is:', 'Cool and relaxed', 'Strictly unprofessional', 'Allowed if you share', 'Okay if you are quiet', 'B'),
(39, 2, 'If you disagree with someone, you should attack:', 'The person', 'The argument/point', 'Their accent', 'Their clothes', 'B'),
(40, 2, 'Formal dress code typically implies:', 'Jeans and T-shirt', 'Party wear', 'Business formals (Shirt/Trousers/Blazer)', 'Sports gear', 'C'),
(41, 3, 'What is the best way to open a GD?', 'State a quote, definition, or surprising fact', 'Start arguing immediately', 'Wait for everyone else to finish', 'Ask the moderator for help', 'A'),
(42, 3, 'The \"Body\" of the GD is meant for:', 'Introduction only', 'Exchanging views, analysis, and building arguments', 'Summarizing', 'Silence', 'B'),
(43, 3, 'When concluding a GD, you should:', 'Add new points', 'Repeat exactly what you said earlier', 'Summarize the group\'s discussion and key points', 'Walk away', 'C'),
(44, 3, 'Can the person who started the GD also conclude it?', 'No, it\'s illegal', 'Yes, if they seize the opportunity', 'Only if the moderator asks', 'Never', 'B'),
(45, 3, 'A good conclusion should represent:', 'Only your personal opinion', 'The consensus or major viewpoints of the group', 'The minority opinion', 'The moderator\'s view', 'B'),
(46, 3, 'How much time is usually given for preparation before the GD starts?', '1 hour', '1-5 minutes', 'No time at all', '10 minutes', 'B'),
(47, 3, 'If the group has strayed from the topic, what should you do?', 'Let them continue', 'Bring the discussion back to the core topic', 'Join the new topic', 'Complain to the moderator', 'B'),
(48, 3, 'Which phase allows for maximum interaction?', 'Opening', 'Body', 'Conclusion', 'Preparation', 'B'),
(49, 3, 'Is it okay to end a GD without a clear consensus?', 'Yes, as long as the discussion was productive', 'No, you fail if there is no agreement', 'Only if the topic was abstract', 'Never', 'A'),
(50, 3, 'The \"Initiator\" has the advantage of:', 'Defining the direction of the discussion', 'Sleeping through the rest', 'Being declared the winner instantly', 'Speaking the least', 'A'),
(51, 4, 'Who is a \"Moderator\" in the context of a student-led GD?', 'The teacher', 'A participant who regulates the flow and encourages others', 'The person who stays silent', 'The person who takes notes', 'B'),
(52, 4, 'The role of a \"Gatekeeper\" is to:', 'Lock the door', 'Ensure everyone gets a chance to speak', 'Stop everyone from speaking', 'Only let their friends speak', 'B'),
(53, 4, 'What does the \"Summarizer\" do?', 'Starts the topic', 'Ends the discussion by consolidating points', 'Argues the most', 'Checks the time', 'B'),
(54, 4, 'If you are an \"Initiator\", you must be careful to:', 'Not make grammatical errors', 'Make sense and set the right tone', 'Speak for the whole duration', 'Ignore everyone else', 'B'),
(55, 4, 'A \"Supporter\" is someone who:', 'Agrees blindly', 'Validates others\' points with logic and extensions', 'Pays for lunch', 'Sits in the back', 'B'),
(56, 4, 'Which role involves managing conflicts?', 'The Aggressor', 'The Harmonizer/Mediator', 'The Passive listener', 'The Dominator', 'B'),
(57, 4, 'Is it necessary to stick to one role throughout?', 'Yes, strict rules apply', 'No, dynamic roles are better (start, analyze, mediate)', 'Yes, otherwise you confuse the panel', 'No, you should have no role', 'B'),
(58, 4, 'The \"Information Seeker\":', 'Asks for clarification or facts to deepen discussion', 'Googles answers on phone', 'Asks personal questions', 'Is confused', 'A'),
(59, 4, 'A \"Dominator\" is a negative role because:', 'They speak too much and bully others', 'They are leaders', 'They know everything', 'They are well dressed', 'A'),
(60, 4, 'To be a \"Timekeeper\", you should:', 'Look at your watch constantly', 'Subtly remind the group of the remaining time', 'Stop the discussion early', 'Hide the clock', 'B'),
(61, 5, 'What makes an argument strong?', 'Loud voice', 'Emotional appeal', 'Logic, facts, and examples', 'Repetition', 'C'),
(62, 5, 'Which type of topic relies heavily on facts?', 'Abstract topics', 'Case studies', 'Current affairs / Factual topics', 'Creative topics', 'C'),
(63, 5, 'If you state a statistic (e.g., \"GDP grew by 5%\"), you should:', 'Guess it', 'Be sure of the source/accuracy', 'Make it up to sound smart', 'Whisper it', 'B'),
(64, 5, 'The \"PEEL\" technique for arguments stands for:', 'Point, Explanation, Example, Link', 'Please Eat Every Lunch', 'Point, End, Exit, Leave', 'Plan, Execute, Eliminate, Lose', 'A'),
(65, 5, 'Is anecdotal evidence (personal stories) allowed?', 'Strictly forbidden', 'Yes, if relevant and short', 'Only if it is funny', 'No, never', 'B'),
(66, 5, 'How do you handle a \"Factual Topic\" like \"Indian Economy\"?', 'Use vague statements', 'Focus on data, government policies, and trends', 'Talk about your family budget', 'Discuss cricket', 'B'),
(67, 5, 'Coherence in speech means:', 'Speaking fast', 'Connecting ideas logically and smoothly', 'Using big words', 'Speaking without breathing', 'B'),
(68, 5, 'If you forget a specific fact, what is better?', 'Fake it', 'Generalize (e.g., \"A significant majority...\")', 'Stop speaking immediately', 'Ask the moderator', 'B'),
(69, 5, 'In a controversial topic, you should:', 'Take a balanced, objective view', 'Become extremely emotional', 'Insult the opposing side', 'Refuse to participate', 'A'),
(70, 5, 'Building an argument \"on top of\" another means:', 'Repeating it', 'Adding a new dimension or example to the previous point', 'Disagreeing with it', 'Ignoring it', 'B'),
(71, 6, 'Active listening involves:', 'Hearing words but thinking of lunch', 'Listening to understand, not just to reply', 'Staring blankly', 'Sleeping with eyes open', 'B'),
(72, 6, 'Why is listening important in a GD?', 'To find faults only', 'To build upon ideas and avoid repetition', 'To rest while others work', 'It is not important', 'B'),
(73, 6, 'A good listener will often:', 'Nod and maintain eye contact', 'Look at their phone', 'Interrupt constantly', 'Yawn', 'A'),
(74, 6, 'If you didn\'t hear a point, you should:', 'Guess what they said', 'Politely ask, \"Could you please repeat that?\"', 'Ignore it', 'Laugh', 'B'),
(75, 6, 'Paraphrasing is:', 'Copying someone', 'Restating someone\'s point in your own words to confirm understanding', 'Disagreeing', 'Plagiarism', 'B'),
(76, 6, 'Listening helps you avoid:', 'Being selected', 'Repeating points already made', 'Making friends', 'Speaking well', 'B'),
(77, 6, 'If a participant makes a great point, you should:', 'Steal it', 'Acknowledge it (e.g., \"I agree with X, and to add...\")', 'Ignore it', 'Tell them to stop', 'B'),
(78, 6, 'Non-verbal listening cues include:', 'Leaning back', 'Leaning forward', 'Fidgeting', 'Closing eyes', 'B'),
(79, 6, 'Selective listening (hearing only what you want) is:', 'Good strategy', 'Bad, leads to misunderstandings', 'Necessary', 'The best way', 'B'),
(80, 6, 'The best way to show you were listening is to:', 'Stay silent', 'Reference previous speakers by name/point in your speech', 'Clap loudly', 'Leave the room', 'B'),
(81, 7, 'If the GD becomes a \"fish market\" (chaos), you should:', 'Shout louder', 'Stay quiet', 'Raise your hand and request order firmly but politely', 'Leave the room', 'C'),
(82, 7, 'If someone aggressively disagrees with you, you should:', 'Fight back aggressively', 'Remain calm and stick to logic', 'Cry', 'Complain to the moderator', 'B'),
(83, 7, 'The phrase \"I beg to differ\" is:', 'Rude', 'Polite way to disagree', 'Old fashioned', 'Illegal', 'B'),
(84, 7, 'To steer a discussion back on track, say:', 'You guys are talking rubbish', 'Let\'s focus on the main topic', 'I am bored', 'Time is up', 'B'),
(85, 7, 'If two people are arguing constantly, you should:', 'Watch the fun', 'Take sides immediately', 'Intervene as a mediator to move the discussion forward', 'Cheer them on', 'C'),
(86, 7, 'Diplomacy in GD means:', 'Lying', 'Disagreeing without being disagreeable', 'Always agreeing', 'Staying silent', 'B'),
(87, 7, 'If someone interrupts you aggressively:', 'Stop and let them finish, then reclaim your turn', 'Shout \"Shut up\"', 'Push them', 'Walk away', 'A'),
(88, 7, 'Which strategy helps resolve a stalemate?', 'Voting', 'Finding a middle ground or synthesis', 'Tossing a coin', 'Fighting', 'B'),
(89, 7, 'Is it okay to change your opinion during the GD?', 'No, it shows weakness', 'Yes, if convinced by better logic (shows flexibility)', 'Only if the moderator says so', 'Never', 'B'),
(90, 7, 'Managing disagreements effectively shows:', 'Weakness', 'Leadership and maturity', 'Lack of knowledge', 'Fear', 'B'),
(91, 8, 'Abstract topics (e.g., \"Blue is better than Red\") test your:', 'General Knowledge', 'Lateral thinking and creativity', 'Math skills', 'History knowledge', 'B'),
(92, 8, 'How do you approach the topic \"Zero\"?', 'Stay silent as it means nothing', 'Interpret it mathematically, philosophically, and metaphorically', 'Say \"Zero is a number\"', 'Ask to change topic', 'B'),
(93, 8, 'In abstract topics, there are:', 'Right and wrong answers', 'No right or wrong answers, only perspectives', 'Only wrong answers', 'Only one correct answer', 'B'),
(94, 8, 'The \"SPELT\" approach for topics stands for:', 'Social, Political, Economic, Legal, Technical', 'Speak, Play, Eat, Laugh, Talk', 'Simple, Plain, Easy, Little, Tiny', 'None of these', 'A'),
(95, 8, 'For the topic \"The pen is mightier than the sword\", you should:', 'Bring a pen and sword', 'Discuss the power of ideas vs. violence', 'Talk about stationery', 'Discuss fencing', 'B'),
(96, 8, 'Critical thinking involves:', 'Accepting everything', 'Questioning assumptions and analyzing deeper', 'Criticizing people', 'Thinking fast', 'B'),
(97, 8, 'If the topic is \"Dot\", a creative angle is:', 'A full stop', 'The beginning of everything (Big Bang)', 'A bindi', 'All of the above', 'D'),
(98, 8, 'When discussing complex scenarios, it is best to:', 'Complicate them more', 'Break them down into simpler stakeholders/parts', 'Ignore the complexity', 'Give up', 'B'),
(99, 8, 'Metaphorical interpretation is key in:', 'Factual GDs', 'Case Studies', 'Abstract GDs', 'News debates', 'C'),
(100, 8, 'If the group is stuck on one interpretation of an abstract topic:', 'Join them', 'Pivot to a completely new and creative interpretation', 'End the GD', 'Repeat the point', 'B'),
(101, 9, 'A true leader in a GD:', 'Speaks the most', 'Facilitates others and drives the group goal', 'Orders people around', 'Is the loudest', 'B'),
(102, 9, 'Encouraging a quiet participant to speak is a sign of:', 'Weakness', 'Inclusive Leadership', 'Boredom', 'Time wasting', 'B'),
(103, 9, 'Driving consensus means:', 'Forcing everyone to agree with you', 'Finding a common ground everyone accepts', 'Ignoring disagreements', 'Voting immediately', 'B'),
(104, 9, 'If the group runs out of points, a leader should:', 'End the GD', 'Introduce a new perspective or angle', 'Wait for the moderator', 'Check their phone', 'B'),
(105, 9, 'Leadership is assessed by:', 'Quality of influence', 'Quantity of words', 'Height of voice', 'Chair position', 'A'),
(106, 9, 'Authoritarian leadership (dictating terms) in GD is:', 'Recommended', 'Negative', 'Necessary', 'The only way', 'B'),
(107, 9, 'A democratic leader:', 'Lets everyone do whatever they want', 'Values everyone\'s input and guides the process', 'Conducts an election', 'Does nothing', 'B'),
(108, 9, 'Structuring the discussion (e.g., \"Let\'s first discuss pros, then cons\") is:', 'Bossy', 'Good directional leadership', 'Waste of time', 'Not allowed', 'B'),
(109, 9, 'If the discussion is going in circles, a leader:', 'Joins the circle', 'Summarizes progress and moves to the next point', 'Leaves', 'Yells', 'B'),
(110, 9, 'The best way to influence the group is through:', 'Aggression', 'Logic and Empathy', 'Manipulation', 'Silence', 'B'),
(111, 10, 'In a high-pressure stress interview GD, you must:', 'Panic', 'Maintain composure and calm logic', 'Get angry', 'Cry', 'B'),
(112, 10, 'If the panel abruptly cuts the time short:', 'Complain', 'Quickly provide a concise summary', 'Keep talking', 'Stop and stare', 'B'),
(113, 10, 'Handling a \"Negative\" topic (e.g., \"Corruption is good\"):', 'Refuse to speak', 'Analyze the \"Why\" and provide a nuanced perspective', 'Support corruption blindly', 'Insult the system', 'B'),
(114, 10, 'Expert level analysis involves:', 'Stating facts', 'Synthesizing facts to predict future trends/implications', 'Repeating news', 'Ignoring facts', 'B'),
(115, 10, 'If everyone attacks your point simultaneously:', 'Give up', 'Listen, acknowledge valid criticism, and refine your stance', 'Attack them back', 'Walk out', 'B'),
(116, 10, 'In a case study, the most important step is:', 'The solution', 'Identifying the root problem', 'Reading fast', 'Writing notes', 'B'),
(117, 10, 'Mastery of tone means:', 'Sounding like a robot', 'Modulating voice to emphasize key points without aggression', 'Singing', 'Whispering', 'B'),
(118, 10, 'When facing a highly knowledgeable opponent:', 'Intimidate them', 'Collaborate and build a higher-level synthesis', 'Ignore them', 'Interrupt them', 'B'),
(119, 10, 'If the topic is highly technical and you are clueless:', 'Use the \"6 Ws\" (Who, What, Where...) to ask broad questions', 'Stay 100% silent', 'Fake technical jargon', 'Leave', 'A'),
(120, 10, 'The ultimate goal of a Master in GD is:', 'To win', 'To add value', 'To be famous', 'To be rich', 'B');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','admin') DEFAULT 'student',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(2, 'Kishore', 'k9346572kishore@gmail.com', '$2y$10$96PVBj7tWErN.5oQXWMfu.jeQ4/DLxS.JgYvkIGMLBsTMX/7j3EDa', 'admin', '2025-08-16 03:25:12'),
(10, 'Pradeep', 'pradeep@gmail.com', '$2y$10$6sbLr8a1Edp3tKQsxgGph.ggczv.Li/ddPuqkT/h..QE.WTITFcNa', 'student', '2025-12-17 06:16:22'),
(11, 'kavin', 'kavin@gmail.com', '$2y$10$puRni9R168C73Lat93PjrOLbjZQedqgn1DyW4XZXNYFTb2HmaeYby', 'student', '2025-12-17 06:16:40'),
(12, 'Arun', 'arun@gmail.com', '$2y$10$d7qt2MR5TyCRE3Krv/MxKuOAMbaI3f7Xviw6rqBRYFB0XejVh9QEe', 'student', '2025-12-18 02:26:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `active_gd_rooms`
--
ALTER TABLE `active_gd_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gd_feedback`
--
ALTER TABLE `gd_feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gd_rooms`
--
ALTER TABLE `gd_rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `room_code` (`room_code`);

--
-- Indexes for table `gd_room_members`
--
ALTER TABLE `gd_room_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gd_topics`
--
ALTER TABLE `gd_topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gd_videos`
--
ALTER TABLE `gd_videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learning_topics`
--
ALTER TABLE `learning_topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_levels`
--
ALTER TABLE `quiz_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_progress`
--
ALTER TABLE `quiz_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `level_id` (`level_id`);

--
-- Indexes for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `level_id` (`level_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `active_gd_rooms`
--
ALTER TABLE `active_gd_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gd_feedback`
--
ALTER TABLE `gd_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `gd_rooms`
--
ALTER TABLE `gd_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `gd_room_members`
--
ALTER TABLE `gd_room_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `gd_topics`
--
ALTER TABLE `gd_topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `gd_videos`
--
ALTER TABLE `gd_videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `learning_topics`
--
ALTER TABLE `learning_topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quiz_levels`
--
ALTER TABLE `quiz_levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `quiz_progress`
--
ALTER TABLE `quiz_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `quiz_progress`
--
ALTER TABLE `quiz_progress`
  ADD CONSTRAINT `quiz_progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_progress_ibfk_2` FOREIGN KEY (`level_id`) REFERENCES `quiz_levels` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD CONSTRAINT `quiz_questions_ibfk_1` FOREIGN KEY (`level_id`) REFERENCES `quiz_levels` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
