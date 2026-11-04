-- Create the CampusConnect database and its two tables in phpMyAdmin.
CREATE DATABASE IF NOT EXISTS campusconnect;
USE campusconnect;

CREATE TABLE IF NOT EXISTS events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(150) NOT NULL,
    category ENUM('technical','cultural','sports','workshop') NOT NULL DEFAULT 'technical',
    event_date DATE NOT NULL,
    venue VARCHAR(150) NOT NULL,
    description VARCHAR(500) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS registrations (
    registration_id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    department VARCHAR(100) NOT NULL,
    event_id INT NOT NULL,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_registration_event FOREIGN KEY (event_id)
        REFERENCES events(event_id) ON DELETE CASCADE
);

-- Sample events to make the homepage look populated.
INSERT INTO events (event_name, category, event_date, venue, description) VALUES
('CodeSprint Hackathon', 'technical', '2027-01-15', 'Computer Lab 2', 'Team up, build something useful, and present your idea.'),
('Rhythm & Colors', 'cultural', '2027-01-22', 'Main Auditorium', 'An evening of music, dance, art, and campus creativity.'),
('Campus Sports Day', 'sports', '2027-02-05', 'College Ground', 'Bring your team and compete in friendly campus games.'),
('Web Design Workshop', 'workshop', '2027-02-12', 'Seminar Hall', 'Learn the basics of designing engaging web experiences.');
