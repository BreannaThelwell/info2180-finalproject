#sql script for creating database:schema.sql

/*!40101 SET NAMES utf8 */;

-- Create the dolphin_crm database
DROP DATABASE IF EXISTS dolphin_crm;
CREATE DATABASE IF NOT EXISTS dolphin_crm;
USE dolphin_crm;

-- USERS INFORMATION

-- Create Users table
CREATE TABLE Users (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL default '',
    lastname VARCHAR(50) NOT NULL default '',
    password VARCHAR(50) NOT NULL default '',
    email VARCHAR(150) NOT NULL UNIQUE default '',
    role VARCHAR(50) NOT NULL default '',
    created_at DATETIME DEFAULT NOW(),
    PRIMARY KEY (id)
);

-- Users Insert Data
LOCK TABLES users WRITE;
INSERT INTO users(firstname, lastname, password, email, role) VALUES
    ('Breanna', 'Thelwell', MD5('password123'), 'admin@project2.com', 'admin'),
    ('Sheri-lee', 'Mills', MD5('password124'), 'admin@project2.com', 'admin1'),
    ('Antawn', 'Edwards', MD5('password125'), 'admin@project2.com', 'admin3'),
    ('Ras dc','Solomon dc', MD5('password126'), 'admin@project2.com', 'admin4'),
    ('Group dc', 'Member5 dc', MD5('password127'), 'admin@project2.com', 'admin5');
UNLOCK TABLES;

--CONTACT INFORMATION

-- Create Contacts table
CREATE TABLE Contacts (
    id INT(3) NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (id),
    title VARCHAR(50) NOT NULL default'',
    firstname VARCHAR(50) NOT NULL default'',
    lastname VARCHAR(50) NOT NULL default'',
    email VARCHAR(150) NOT NULL default'',
    telephone VARCHAR(15) NOT NULL default'',
    company VARCHAR(50),
    type enum('Support', 'Sale Leads') NOT NULL default 'Support',
    assigned_to INT(10) default NULL,
    created_by INT(10) default NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (assigned_to) REFERENCES Users(id),
    FOREIGN KEY (created_by) REFERENCES Users(id)
);

-- Contacts Insert Data
LOCK TABLES contacts WRITE;
INSERT INTO contacts(title, firstname, lastname, email, telephone, company, type, assigned_to, created_by) VALUES
    ('Host', 'Sheri-lee', 'Mills', 'SM@project2.com', '123456789', 'UWI', 'Sales Lead', 2, 2);
UNLOCK TABLES;

-- NOTES INFORMATION

-- Create Notes table
CREATE TABLE Notes (
    id INT(5) AUTO_INCREMENT PRIMARY KEY,
    contact_id(3) INT NOT NULL,
    comment TEXT NOT NULL,
    created_by INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (contact_id) REFERENCES Contacts(id),
    FOREIGN KEY (created_by) REFERENCES Users(id)
);

--Notes Insert Data
LOCK TABLES notes WRITE;
INSERT INTO notes(contact_id, created_by, comment) VALUES
    ('1', 3, 'Customer Added Successfully'),
    ('2', 4, 'Customer Not Added');
UNLOCK TABLES;

/*password hashing using SHA2*/
-- Insert admin user
/*INSERT INTO Users (firstname, lastname, password, email, role)
VALUES ('Admin', 'User', SHA2('password123', 256), 'admin@project2.com', 'Admin');*/