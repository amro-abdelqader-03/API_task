CREATE DATABASE student_api
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE student_api;

CREATE TABLE students (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    course VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO students (name, email, course, password)
VALUES
('Ahmad Ali', 'ahmad@example.com', 'PHP', '$2y$10$3pKZCYOlAEM5QtjdjWU0XeqPPXwHyHNS7UuaLvfz8gYFRk4hvzjY.'),
('Sara Mohammad', 'sara@example.com', 'JavaScript', '$2y$10$3pKZCYOlAEM5QtjdjWU0XeqPPXwHyHNS7UuaLvfz8gYFRk4hvzjY.'),
('Omar Khaled', 'omar@example.com', 'Laravel', '$2y$10$3pKZCYOlAEM5QtjdjWU0XeqPPXwHyHNS7UuaLvfz8gYFRk4hvzjY.');