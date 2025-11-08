-- Namma GD Database Dump
-- Create database
CREATE DATABASE IF NOT EXISTS namma_gd;
USE namma_gd;

-- Users Table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('student','admin') DEFAULT 'student',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- GD Topics Table
CREATE TABLE gd_topics (
    id INT PRIMARY KEY AUTO_INCREMENT,
    topic VARCHAR(255) NOT NULL
);

-- Learning Topics Table
CREATE TABLE learning_topics (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    type ENUM('video', 'article', 'quiz') NOT NULL,
    file_url VARCHAR(255) NOT NULL
);

-- GD Feedback Table
CREATE TABLE gd_feedback (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    topic VARCHAR(255),
    grammar_score INT,
    sentiment_score INT,
    speaking_time INT,
    improvement_tips TEXT,
    session_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Quiz Questions Table (optional for learning module)
CREATE TABLE quiz_questions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    learning_id INT NOT NULL,
    question TEXT NOT NULL,
    option_a VARCHAR(255),
    option_b VARCHAR(255),
    option_c VARCHAR(255),
    option_d VARCHAR(255),
    correct_option CHAR(1),
    FOREIGN KEY (learning_id) REFERENCES learning_topics(id) ON DELETE CASCADE
);

-- Sample Data for GD Topics
INSERT INTO gd_topics (topic) VALUES
('Impact of Artificial Intelligence on Jobs'),
('Online Education vs Classroom Education'),
('Climate Change and Its Global Impact'),
('Is Social Media Making Us Less Social?'),
('Electric Vehicles: Future or Hype?');

-- Sample Data for Learning Topics
INSERT INTO learning_topics (title, description, type, file_url) VALUES
('Basics of Group Discussion', 'Introduction to GD structure, do’s and don’ts.', 'video', 'videos/gd_basics.mp4'),
('Tips for Confident Speaking', 'Improve your public speaking skills.', 'article', 'articles/confident_speaking.pdf'),
('GD Practice Quiz 1', 'Test your GD knowledge.', 'quiz', 'quiz.php?id=1');

-- Sample User (Password: test123)
INSERT INTO users (username, email, password, role) VALUES
('Admin', 'admin@namma_gd.com', '$2y$10$kqjWQ9zLkMZsAFQItuCO7e94gTn9MfLbfq.DySx/yv9J/jTG/AlCC', 'admin'),
('Test User', 'user@namma_gd.com', '$2y$10$kqjWQ9zLkMZsAFQItuCO7e94gTn9MfLbfq.DySx/yv9J/jTG/AlCC', 'student');
