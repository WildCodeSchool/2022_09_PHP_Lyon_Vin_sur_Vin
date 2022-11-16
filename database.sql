DROP DATABASE IF EXISTS vin_sur_vin;
CREATE DATABASE vin_sur_vin;
USE vin_sur_vin;

DROP TABLE IF EXISTS partner;
CREATE TABLE partner (
id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
firstname VARCHAR(100) NOT NULL,
lastname VARCHAR(100),
address VARCHAR(255),
email VARCHAR(100),
phone VARCHAR(10),
password VARCHAR(255),
description TEXT(1000)
);

DROP TABLE IF EXISTS wine;
CREATE TABLE wine (
id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
name VARCHAR(100) NOT NULL,
year YEAR NOT NULL,
color VARCHAR(10),
region VARCHAR(50),
grape VARCHAR(20),
price FLOAT NOT NULL,
description TEXT(1000),
partner_id INT NOT NULL,
favorite BOOLEAN,
CONSTRAINT fk_wine_partner FOREIGN KEY (partner_id) REFERENCES partner(id)
);

INSERT INTO partner (firstname, phone, email ,password)
VALUES ('Damien', 0677665522, 'broyerdamien@gmail.com', '$2y$10$x0zb3ZtuSzkeWt0Mp1Ccle7zZ60Lq9utb7oRTDQpxfTsUpd89nBgW'),
('Lila', 0577889900, 'ljacobieski@gmail.com' ,'$2y$10$DvtAnEoT7g000MXdYdpxOuJ5sE1rnksfEkU0MSsRW/Iv83EYMzahS'),
('Mathieu', 0612324252, 'mat.lecanu@gmail.com', '$2y$10$wtQaLMYckQQ35gRgSBFj2u1wjHY2DO0FtHHcanvIq01VXHeKxYEyu'),
('Alan', 0873647384, 'alan@wilders.com', 'alan99'),
('Jesse', 0633831565, 'vallantjesse@live.com', '$2y$10$xnc5OJC92B0cU/bQGHfLSOl5nugr5ykpZSAdG2rv5PRKD8b5IR3Ri');

INSERT INTO wine (name, color, region, year, price, partner_id)
VALUES ('Beaujolais de Damien', 'Rouge', 'Beaujolais', 1989, 10, 1), ('La villageoise de Allan', 'Blanc', 'Auvergne', 2023, 2, 2), ('Rosé de Lila ', 'Rosé', "Provence-Alpes-Côte-d'Azur", 1987, 7, 3),
('Viognier de Mathieu', 'Blanc', 'Vallée du Rhône', 1994, 12, 4), ('Bordeaux de Jesse', 'Rouge', 'Bordeaux', 1995, 11, 5);

UPDATE wine SET favorite = 1 WHERE id BETWEEN 1 and 3;

DROP TABLE IF EXISTS admin;
CREATE TABLE admin (
  id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
  pseudo varchar(20),
  email varchar(100) NOT NULL,
  password varchar(255) NOT NULL,
  UNIQUE KEY email_UNIQUE (email)
);

INSERT INTO admin (pseudo, email, password)
VALUES ('Coquille2Lune', 'ljacobieski@gmail.com','$2y$10$DvtAnEoT7g000MXdYdpxOuJ5sE1rnksfEkU0MSsRW/Iv83EYMzahS'),
('Le boucher', 'broyerdamien@gmail.com', '$2y$10$x0zb3ZtuSzkeWt0Mp1Ccle7zZ60Lq9utb7oRTDQpxfTsUpd89nBgW'),
('Busy_gnl', 'vallantjesse@live.com', '$2y$10$xnc5OJC92B0cU/bQGHfLSOl5nugr5ykpZSAdG2rv5PRKD8b5IR3Ri'),
('Supzero', 'mat.lecanu@gmail.com','$2y$10$wtQaLMYckQQ35gRgSBFj2u1wjHY2DO0FtHHcanvIq01VXHeKxYEyu');

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(20) NOT NULL,
  `pseudo` varchar(45) NOT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `addresse` VARCHAR(255) DEFAULT NULL,
  `phone` VARCHAR(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
);


INSERT INTO `user` VALUES (1,'marty@wilders.com','$2y$10$4Fr/E4Lcj8HRTQ5UtXBE4./ut/diPoZQLzICLRQqqFU5NamJpsKOK','Marty','Marty','McFly', 'Delorean Street', 0897366534);


SELECT * FROM admin;
SELECT * FROM partner;
SELECT * FROM wine;
SELECT * FROM user;

-- pseudo : marty
-- email : marty@wilders.com
-- password : Wilder4Ever
