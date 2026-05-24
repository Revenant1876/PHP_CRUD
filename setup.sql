CREATE DATABASE StudentSystem;
USE StudentSystem;
CREATE TABLE registration (
id INT PRIMARY KEY AUTO_INCREMENT,
full_name VARCHAR(100),
email VARCHAR(100),
course VARCHAR(50)
);