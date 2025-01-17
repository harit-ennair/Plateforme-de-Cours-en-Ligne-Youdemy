-- Active: 1734948296838@@127.0.0.1@3306@youdemy
CREATE DATABASE Youdemy;
USE Youdemy;


CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('student', 'teacher', 'admin') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('active', 'suspended', 'panding') DEFAULT 'active'
    DELIMITER //

CREATE TRIGGER set_default_status BEFORE INSERT ON Users
FOR EACH ROW
BEGIN
    IF NEW.role = 'teacher' THEN
        SET NEW.status = 'panding';
    ELSE
        SET NEW.status = 'active';
    END IF;
END;

//

DELIMITER ;
);

-- Table des catégories de cours
CREATE TABLE Categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des tags
CREATE TABLE Tags (
    tag_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des cours
CREATE TABLE Courses (
    course_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    content TEXT, -- Peut être une URL ou un chemin vers le fichier
    teacher_id INT,
    category_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (teacher_id) REFERENCES Users(user_id),
    FOREIGN KEY (category_id) REFERENCES Categories(category_id)
    content_type ENUM('PDF', 'Video')
    status ENUM('active','panding') DEFAULT 'panding'

);

-- Table de relation many-to-many entre les cours et les tags
CREATE TABLE CourseTags (
    course_id INT,
    tag_id INT,
    PRIMARY KEY (course_id, tag_id),
    FOREIGN KEY (course_id) REFERENCES Courses(course_id),
    FOREIGN KEY (tag_id) REFERENCES Tags(tag_id)
);

-- Table des inscriptions des étudiants aux cours
CREATE TABLE Enrollments (
    enrollment_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    course_id INT,
    enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES Users(user_id),
    FOREIGN KEY (course_id) REFERENCES Courses(course_id)
);