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

INSERT INTO users (username, password) 
VALUES ('admin', '$2y$10$5yln4TZNhMY4FhEv74VGKOtoxSjwnEFQfwe0QygdJaVn7aA6ZI2qS')
ON DUPLICATE KEY UPDATE username=username;


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
('Aliban, Calvin Jay Lasque', 'calvin.j.lasque@gmail.com', 'Industrial Engineering', 20, 'Male', '2020-0000CJL'),
('Balading, Marielle Denise', 'marielle.d.balading@gmail.com', 'Industrial Engineering', 19, 'Female', '2020-0001MD'),
('Bandalan, Niko Adrian Rivera', 'niko.a.rivera@gmail.com', 'Industrial Engineering', 21, 'Male', '2020-0002NAR'),
('BaÑes, Wes Avery Cruz', 'wes.a.cruz@gmail.com', 'Industrial Engineering', 18, 'Male', '2020-0003WAC'),
('Barotilla, J-mark Celiz', 'jmark.celiz@gmail.com', 'Industrial Engineering', 22, 'Male', '2020-0004JC'),
('Basco, Valerie Amarille', 'valerie.a.basco@gmail.com', 'Industrial Engineering', 20, 'Female', '2020-0005VA'),
('Belda, Angelo Nario', 'angelo.n.belda@gmail.com', 'Industrial Engineering', 19, 'Male', '2020-0006AN'),
('Bolongaita, Princess Ann Bronola', 'princess.a.bolongaita@gmail.com', 'Industrial Engineering', 21, 'Female', '2020-0007PAB'),
('Bonganciso, Jilwen Kammu Timagos', 'jilwen.k.tim@gmail.com', 'Industrial Engineering', 20, 'Male', '2020-0008JKT'),
('Cabanada, Ghian Cuales', 'ghian.c.cabanada@gmail.com', 'Industrial Engineering', 23, 'Male', '2020-0009GC'),
('Castro, Angelica Cinco', 'angelica.c.castro@gmail.com', 'Industrial Engineering', 19, 'Female', '2020-0010AC'),
('Clemente, Jairah Celedonio', 'jairah.c.clemente@gmail.com', 'Industrial Engineering', 22, 'Female', '2020-0011JC'),
('Concepcion, Aarron Alexander', 'aarron.a.concepcion@gmail.com', 'Industrial Engineering', 20, 'Male', '2020-0012AA'),
('Condino, Marianne Cuebillas', 'marianne.c.condino@gmail.com', 'Industrial Engineering', 21, 'Female', '2020-0013MC'),
('CoriÑo, Cathleen Cano', 'cathleen.c.cano@gmail.com', 'Industrial Engineering', 18, 'Female', '2020-0014CC'),
('Dacayo, Leydrawe Branzuela', 'leydrawe.b.dacayo@gmail.com', 'Industrial Engineering', 24, 'Female', '2020-0015LB'),
('Dagante, Sherly Ann Cerneis', 'sherly.a.dagante@gmail.com', 'Industrial Engineering', 19, 'Female', '2020-0016SAC'),
('De Guzman, Brian Jiro Go', 'brian.j.guzman@gmail.com', 'Industrial Engineering', 22, 'Male', '2020-0017BJG'),
('Dorado, E-jay Domiquil', 'ejay.dorado@gmail.com', 'Industrial Engineering', 20, 'Male', '2020-0018ED'),
('Dumasig, Mark Ian Sildo', 'mark.i.dumasig@gmail.com', 'Industrial Engineering', 21, 'Male', '2020-0019MIS'),
('Escoto, John Patrick Naire', 'john.p.escoto@gmail.com', 'Industrial Engineering', 19, 'Male', '2020-0020JPN'),
('Fernandez, Ayesa Mae Lutero', 'ayesa.m.fernandez@gmail.com', 'Industrial Engineering', 23, 'Female', '2020-0021AML'),
('Flores, Cassandra Fiona DepeÑo', 'cassandra.f.flores@gmail.com', 'Industrial Engineering', 20, 'Female', '2020-0022CFD'),
('Frivaldo, Ansherine Alburo', 'ansherine.a.frivaldo@gmail.com', 'Industrial Engineering', 25, 'Female', '2020-0023AA'),
('Galagate, Micaiah Zaree Belardo', 'micaiah.z.galagate@gmail.com', 'Industrial Engineering', 18, 'Male', '2020-0024MZB'),
('Goto, John Russel Moreno', 'john.r.goto@gmail.com', 'Industrial Engineering', 21, 'Male', '2020-0025JRM'),
('Labaclado, Lawrenz Gato', 'lawrenz.g.labaclado@gmail.com', 'Industrial Engineering', 19, 'Male', '2020-0026LG'),
('Lagramada, John Mark Bien', 'john.m.lagramada@gmail.com', 'Industrial Engineering', 22, 'Male', '2020-0027JMB'),
('Lardizabal, Kate Marianne Macaya', 'kate.m.lardizabal@gmail.com', 'Industrial Engineering', 20, 'Female', '2020-0028KMM'),
('Lunar, Danielle Rose Majaba', 'danielle.r.lunar@gmail.com', 'Industrial Engineering', 23, 'Female', '2020-0029DRM'),
('Maboloc, Jhon Henry Caluya', 'jhon.h.maboloc@gmail.com', 'Industrial Engineering', 21, 'Male', '2020-0030JHC'),
('Macahig, Neil John Atenciana', 'neil.j.macahig@gmail.com', 'Industrial Engineering', 19, 'Male', '2020-0031NJA'),
('Mallari, Leslie Guison', 'leslie.g.mallari@gmail.com', 'Industrial Engineering', 24, 'Female', '2020-0032LG'),
('Mamano, Justin Jian Casco', 'justin.j.mamano@gmail.com', 'Industrial Engineering', 20, 'Male', '2020-0033JJC'),
('Marin, Avie Joy Azores', 'avie.j.marin@gmail.com', 'Industrial Engineering', 22, 'Female', '2020-0034AJA'),
('Nocedo, Angelica Nicole Lavadia', 'angelica.n.nocedo@gmail.com', 'Industrial Engineering', 18, 'Female', '2020-0035ANL'),
('Ocupio, Jhean Franchette Tirados', 'jhean.f.ocupio@gmail.com', 'Industrial Engineering', 21, 'Female', '2020-0036JFT'),
('Palattao, Cedric Santos', 'cedric.s.palattao@gmail.com', 'Industrial Engineering', 23, 'Male', '2020-0037CS'),
('Perea, Hanz Jared Magtipon', 'hanz.j.perea@gmail.com', 'Industrial Engineering', 19, 'Male', '2020-0038HJM'),
('Rebece, Althea Agonos', 'althea.a.rebece@gmail.com', 'Industrial Engineering', 25, 'Female', '2020-0039AA'),
('Ronquillo, Claire Zachariah Olasiman', 'claire.z.ronquillo@gmail.com', 'Industrial Engineering', 20, 'Female', '2020-0040CZO'),
('Simbajon, Van Adrian Mama', 'van.a.simbajon@gmail.com', 'Industrial Engineering', 22, 'Male', '2020-0041VAM'),
('Ticman, Troy Cruz', 'troy.c.ticman@gmail.com', 'Industrial Engineering', 21, 'Male', '2020-0042TC'),
('Torregoza, Kayla Joyce', 'kayla.j.torregoza@gmail.com', 'Industrial Engineering', 19, 'Female', '2020-0043KJ'),
('Zacaria, Al-nazer Salim', 'alnazer.s.zacaria@gmail.com', 'Industrial Engineering', 24, 'Male', '2020-0044AS')
ON DUPLICATE KEY UPDATE email=VALUES(email), course=VALUES(course), age=VALUES(age), gender=VALUES(gender), student_id=VALUES(student_id);

SELECT * FROM registration;