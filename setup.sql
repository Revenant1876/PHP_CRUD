CREATE DATABASE IF NOT EXISTS StudentSystem;

USE StudentSystem;

CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DELETE FROM users WHERE username = 'admin';

INSERT INTO users (username, password, email) VALUES
('admin', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36P6ElWe', 'admin@studentsystem.com');

CREATE TABLE IF NOT EXISTS registration (
    id         INT PRIMARY KEY AUTO_INCREMENT,
    full_name  VARCHAR(100) UNIQUE,
    email      VARCHAR(100),
    course     VARCHAR(50),
    age        INT,
    gender     VARCHAR(20),
    student_id VARCHAR(50) UNIQUE
);

INSERT INTO registration (full_name, email, course, age, gender, student_id) VALUES
('Aliban, Calvin Jay Lasque', '', 'Industrial Engineering', 20, 'Male', '2020-0000CJL'),
('Balading, Marielle Denise', '', 'Industrial Engineering', 19, 'Female', '2020-0001MD'),
('Bandalan, Niko Adrian Rivera', '', 'Industrial Engineering', 21, 'Male', '2020-0002NAR'),
('BaÑes, Wes Avery Cruz', '', 'Industrial Engineering', 18, 'Male', '2020-0003WAC'),
('Barotilla, J-mark Celiz', '', 'Industrial Engineering', 22, 'Male', '2020-0004JC'),
('Basco, Valerie Amarille', '', 'Industrial Engineering', 20, 'Female', '2020-0005VA'),
('Belda, Angelo Nario', '', 'Industrial Engineering', 19, 'Male', '2020-0006AN'),
('Bolongaita, Princess Ann Bronola', '', 'Industrial Engineering', 21, 'Female', '2020-0007PAB'),
('Bonganciso, Jilwen Kammu Timagos', '', 'Industrial Engineering', 20, 'Male', '2020-0008JKT'),
('Cabanada, Ghian Cuales', '', 'Industrial Engineering', 23, 'Male', '2020-0009GC'),
('Castro, Angelica Cinco', '', 'Industrial Engineering', 19, 'Female', '2020-0010AC'),
('Clemente, Jairah Celedonio', '', 'Industrial Engineering', 22, 'Female', '2020-0011JC'),
('Concepcion, Aarron Alexander', '', 'Industrial Engineering', 20, 'Male', '2020-0012AA'),
('Condino, Marianne Cuebillas', '', 'Industrial Engineering', 21, 'Female', '2020-0013MC'),
('CoriÑo, Cathleen Cano', '', 'Industrial Engineering', 18, 'Female', '2020-0014CC'),
('Dacayo, Leydrawe Branzuela', '', 'Industrial Engineering', 24, 'Female', '2020-0015LB'),
('Dagante, Sherly Ann Cerneis', '', 'Industrial Engineering', 19, 'Female', '2020-0016SAC'),
('De Guzman, Brian Jiro Go', '', 'Industrial Engineering', 22, 'Male', '2020-0017BJG'),
('Dorado, E-jay Domiquil', '', 'Industrial Engineering', 20, 'Male', '2020-0018ED'),
('Dumasig, Mark Ian Sildo', '', 'Industrial Engineering', 21, 'Male', '2020-0019MIS'),
('Escoto, John Patrick Naire', '', 'Industrial Engineering', 19, 'Male', '2020-0020JPN'),
('Fernandez, Ayesa Mae Lutero', '', 'Industrial Engineering', 23, 'Female', '2020-0021AML'),
('Flores, Cassandra Fiona DepeÑo', '', 'Industrial Engineering', 20, 'Female', '2020-0022CFD'),
('Frivaldo, Ansherine Alburo', '', 'Industrial Engineering', 25, 'Female', '2020-0023AA'),
('Galagate, Micaiah Zaree Belardo', '', 'Industrial Engineering', 18, 'Male', '2020-0024MZB'),
('Goto, John Russel Moreno', '', 'Industrial Engineering', 21, 'Male', '2020-0025JRM'),
('Labaclado, Lawrenz Gato', '', 'Industrial Engineering', 19, 'Male', '2020-0026LG'),
('Lagramada, John Mark Bien', '', 'Industrial Engineering', 22, 'Male', '2020-0027JMB'),
('Lardizabal, Kate Marianne Macaya', '', 'Industrial Engineering', 20, 'Female', '2020-0028KMM'),
('Lunar, Danielle Rose Majaba', '', 'Industrial Engineering', 23, 'Female', '2020-0029DRM'),
('Maboloc, Jhon Henry Caluya', '', 'Industrial Engineering', 21, 'Male', '2020-0030JHC'),
('Macahig, Neil John Atenciana', '', 'Industrial Engineering', 19, 'Male', '2020-0031NJA'),
('Mallari, Leslie Guison', '', 'Industrial Engineering', 24, 'Female', '2020-0032LG'),
('Mamano, Justin Jian Casco', '', 'Industrial Engineering', 20, 'Male', '2020-0033JJC'),
('Marin, Avie Joy Azores', '', 'Industrial Engineering', 22, 'Female', '2020-0034AJA'),
('Nocedo, Angelica Nicole Lavadia', '', 'Industrial Engineering', 18, 'Female', '2020-0035ANL'),
('Ocupio, Jhean Franchette Tirados', '', 'Industrial Engineering', 21, 'Female', '2020-0036JFT'),
('Palattao, Cedric Santos', '', 'Industrial Engineering', 23, 'Male', '2020-0037CS'),
('Perea, Hanz Jared Magtipon', '', 'Industrial Engineering', 19, 'Male', '2020-0038HJM'),
('Rebece, Althea Agonos', '', 'Industrial Engineering', 25, 'Female', '2020-0039AA'),
('Ronquillo, Claire Zachariah Olasiman', '', 'Industrial Engineering', 20, 'Female', '2020-0040CZO'),
('Simbajon, Van Adrian Mama', '', 'Industrial Engineering', 22, 'Male', '2020-0041VAM'),
('Ticman, Troy Cruz', '', 'Industrial Engineering', 21, 'Male', '2020-0042TC'),
('Torregoza, Kayla Joyce', '', 'Industrial Engineering', 19, 'Female', '2020-0043KJ'),
('Zacaria, Al-nazer Salim', '', 'Industrial Engineering', 24, 'Male', '2020-0044AS')
ON DUPLICATE KEY UPDATE email=VALUES(email), course=VALUES(course), age=VALUES(age), gender=VALUES(gender), student_id=VALUES(student_id);

SELECT * FROM registration;