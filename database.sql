DROP DATABASE IF EXISTS vin_sur_vin;
CREATE DATABASE vin_sur_vin;
USE vin_sur_vin;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `item` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `item` (`id`, `title`) VALUES
(1, 'Stuff'),
(2, 'Doodads');

ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `item`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

 DROP TABLE IF EXISTS partner;
CREATE TABLE partner (
id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
firstname VARCHAR(100) NOT NULL,
lastname VARCHAR(100),
address VARCHAR(255),
email VARCHAR(100),
phone VARCHAR(10),
password VARCHAR(20),
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

INSERT INTO partner (firstname, phone, password)
VALUES ('Damien', 0677665522, 'Damdam32'), ('Allan', 0766554433, 'Allan99'), ('Lila', 0577889900, 'Lili32'), ('Mathieu', 0612324252, 'Matmat48'), ('Jesse', 0633831565, 'Jeje21');

INSERT INTO wine (name, color, region, year, price, partner_id)
VALUES ('Beaujolais de Damien', 'Rouge', 'Beaujolais', 1989, 10, 1), ('Saint Joseph de Damien', 'Rouge', 'Vallée du Rhône', 2018, 18, 1), ('Pommard de Damien', 'Rouge', 'Bourguogne', 2015, 38, 1),
('Nuit Saint George de Damien', 'Rouge', 'Bourguogne', 2018, 18, 1), ('Mercurey', 'Rouge', 'Bourgogne', 2018, 18, 1), ('Romanée-Conti de Damien', 'Rouge', 'Bourgogne', 1995, 10, 1),
('La villageoise de Allan', 'Blanc', 'Auvergne', 2023, 2, 2), ('Jurançon', 'Rouge', 'Jura', 2010, 6, 2), ('Côtes de Bordeaux', 'Rouge', 'Bordeaux', 2016, 9, 2),
('Pinot Blanc', 'Blanc', 'Jura', 2018, 7, 2), ('Pinot Noir', 'Rouge', 'Jura', 2019, 8, 2),
('Rosé de Lila ', 'Rosé', "Provence-Alpes-Côte-d'Azur", 1987, 7, 3), ('Viré-Clessé', 'Blanc', 'Vallée de la Loire', 2006, 12, 3), ('Pouilly-Fussé', 'Blanc', 'Bourgogne', 2001, 24, 3),
('Côtes de Provence', 'Rosé', "Provence-Alpes-Côte-d'Azur", 2012, 14, 3), ('Riesling', 'Blanc', 'Alsace', , 10, 3),
('Viognier de Mathieu', 'Blanc', 'Vallée du Rhône', 1994, 12, 4), ('Languedoc', 'Rosé', 'Languedoc', 1998, 7, 4), ('Crozes-Hermitage', 'Rouge', "Drôme", 2002, 14, 4),
('Saint-Emilion', 'Rouge', 'Bordeaux', 2000, 18, 4), ('Saint-Julien', 'Rouge', 'Bordeaux', 2007, 16, 4),
('Bordeaux de Jesse', 'Rouge', 'Bordeaux', 1995, 11, 5), ('Pommard', 'Blanc', 'Bourgogne', 2020, 12, 5), ('Mercurey', 'Rouge', 'Beaujolais', 2019, 15, 5),
('Côte du Rhône', 'Rouge', 'Vallée du Rhône', 2017, 10, 5), ('Vin de Savoie', 'Blanc', 'Savoie', 2015, 12, 5),
UPDATE wine SET favorite = 1 WHERE id BETWEEN 1 and 3;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `pseudo` varchar(45) DEFAULT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'marty@wilders.com','$2y$10$4Fr/E4Lcj8HRTQ5UtXBE4./ut/diPoZQLzICLRQqqFU5NamJpsKOK','Marty','Marty','McFly');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS admin;
CREATE TABLE admin (
  id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
  pseudo varchar(20),
  email varchar(100) NOT NULL,
  password varchar(255) NOT NULL,
  UNIQUE KEY email_UNIQUE (email)
);

INSERT INTO admin (pseudo, email, password)
VALUES ('Coquille2Lune', 'ljacobieski@gmail.com','$2y$10$DvtAnEoT7g000MXdYdpxOuJ5sE1rnksfEkU0MSsRW/Iv83EYMzahS'), ('Le boucher', 'broyerdamien@gmail.com','$2y$10$x0zb3ZtuSzkeWt0Mp1Ccle7zZ60Lq9utb7oRTDQpxfTsUpd89nBgW'),
('Busy_gnl','vallantjesse@live.com','$2y$10$xnc5OJC92B0cU/bQGHfLSOl5nugr5ykpZSAdG2rv5PRKD8b5IR3Ri'), ('Supzero','mat.lecanu@gmail.com','$2y$10$wtQaLMYckQQ35gRgSBFj2u1wjHY2DO0FtHHcanvIq01VXHeKxYEyu');

SELECT * FROM admin;
SELECT * FROM partner;
SELECT * FROM wine;
SELECT * FROM user;


