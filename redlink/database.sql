CREATE DATABASE redlink;
USE redlink;

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(100)
);

CREATE TABLE blood_banks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150),
    state VARCHAR(50),
    district VARCHAR(50),
    address TEXT,
    contact VARCHAR(20),
    category VARCHAR(50)
);

CREATE TABLE blood_stock (
    id INT AUTO_INCREMENT PRIMARY KEY,
    blood_bank_id INT,
    blood_group VARCHAR(5),
    units INT,
    FOREIGN KEY (blood_bank_id) REFERENCES blood_banks(id)
);

CREATE TABLE donors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    gender VARCHAR(10),
    blood_group VARCHAR(5),
    phone VARCHAR(20),
    email VARCHAR(100),
    password VARCHAR(100),
    state VARCHAR(50),
    district VARCHAR(50)
);

CREATE TABLE camps (
    id INT AUTO_INCREMENT PRIMARY KEY,
    blood_bank_id INT,
    camp_name VARCHAR(150),
    camp_date DATE,
    location TEXT,
    contact VARCHAR(20),
    FOREIGN KEY (blood_bank_id) REFERENCES blood_banks(id)
);

INSERT INTO admins (username, password)
VALUES ('admin', 'admin123');
