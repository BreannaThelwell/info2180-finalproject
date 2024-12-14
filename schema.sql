-- Active: 1708299122603@@127.0.0.1@3306@dolphin_crm
-- Create the dolphin_crm database
CREATE DATABASE IF NOT EXISTS dolphin_crm;
USE dolphin_crm;

-- Create Users table
CREATE TABLE IF NOT EXISTS Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL, -- Store hashed passwords
    email VARCHAR(255) NOT NULL UNIQUE,
    role ENUM('Admin', 'User') NOT NULL DEFAULT 'User', -- Use ENUM for role validation
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Create Contacts table
CREATE TABLE IF NOT EXISTS Contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title ENUM('Mr.', 'Mrs.', 'Ms.', 'Dr.') DEFAULT NULL, -- Use ENUM for standardized titles
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    email VARCHAR(255) DEFAULT NULL,
    telephone VARCHAR(50) DEFAULT NULL,
    company VARCHAR(255) DEFAULT NULL,
    type ENUM('Sales Lead', 'Support') DEFAULT NULL, -- Use ENUM for contact types
    assigned_to INT DEFAULT NULL,
    created_by INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (assigned_to) REFERENCES Users(id) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (created_by) REFERENCES Users(id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Create Notes table
CREATE TABLE IF NOT EXISTS Notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contact_id INT NOT NULL,
    comment TEXT NOT NULL,
    created_by INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (contact_id) REFERENCES Contacts(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (created_by) REFERENCES Users(id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Insert admin user
INSERT INTO Users (firstname, lastname, password, email, role)
VALUES ('Admin', 'User', SHA2('password123', 256), 'admin@project2.com', 'Admin') ON DUPLICATE KEY UPDATE password = VALUES(password), email = VALUES(email), role = VALUES(role);

