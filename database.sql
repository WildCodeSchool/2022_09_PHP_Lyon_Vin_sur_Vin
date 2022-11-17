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
price INT NOT NULL,
description TEXT(1000),
partner_id INT NOT NULL,
image VARCHAR(255),
favorite BOOLEAN,
CONSTRAINT fk_wine_partner FOREIGN KEY (partner_id) REFERENCES partner(id) ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO partner (firstname, phone, password)
VALUES ('Damien', 0677665522, 'Damdam32'), ('Allan', 0766554433, 'Allan99'), ('Lila', 0577889900, 'Lili32'), ('Mathieu', 0612324252, 'Matmat48'), ('Jesse', 0633831565, 'Jeje21');

INSERT INTO wine (name, color, region, year, price, partner_id, image)
VALUES ('Beaujolais de Damien', 'Rouge', 'Beaujolais', 1989, 10, 1, 'https://media.carrefour.fr/medias/1c633b6717ea30ca8ebe4104e78ccecf/p_540x540/3455180049498-photosite-20191206-141127-0.jpg'), 
('Saint Joseph de Damien', 'Rouge', 'Vallée du Rhône', 2018, 18, 1, 'https://medias.nicolas.com/media/sys_master/images/hbf/h9d/9382516916254.png'), 
('Pommard de Damien', 'Rouge', 'Bourguogne', 2015, 38, 1, 'https://www.vinatis.com/65595-detail_default/pommard-2020-domaine-bourgogne-devaux.png'),
('Nuit Saint George de Damien', 'Rouge', 'Bourguogne', 2018, 18, 1, 'https://medias.nicolas.com/media/sys_master/images/h5c/h59/9205686108190.png'), 
('Mercurey', 'Rouge', 'Bourgogne', 2018, 18, 1, 'https://media.carrefour.fr/medias/16d4b542670c3696924650817ab3d33a/p_540x540/03296313134205-a1n1-s01.jpg'), 
('Romanée-Conti de Damien', 'Rouge', 'Bourgogne', 1995, 10, 1, 'https://pleasurewine.com/10679-superlarge_default/romanee-conti-1999-domaine-de-la-romanee-conti.jpg'),
('La villageoise de Allan', 'Rouge', 'Auvergne', 2023, 2, 2, 'https://media.carrefour.fr/medias/6b9cfa6f8c8834d88e45566f643da13f/p_540x540/03175529631732-a1c1-s02.jpg'), 
('Jurançon', 'Blanc', 'Jura', 2010, 6, 2, 'https://media.carrefour.fr/medias/13880c34d2d43c98ae45efabaa25d7c9/p_540x540/03300943502096-a1r1-s01.jpg'), 
('Côtes de Bordeaux', 'Rouge', 'Bordeaux', 2016, 9, 2, 'https://www.le-gout-de-nos-regions.com/5126-large_default/aoc-blaye-cotes-de-bordeaux-rouge.jpg'),
('Pinot Blanc', 'Blanc', 'Jura', 2018, 7, 2, 'https://www.geiler.fr/134-thickbox_default/pinot-blanc.jpg'), 
('Pinot Noir', 'Rouge', 'Jura', 2019, 8, 2, 'https://media.carrefour.fr/medias/b9d0fb3316463968a9e7fc0be2bf4248/p_540x540/3267980003132-photosite-20180327-043950-0.jpg'), 
('Saint-Chinian', 'Rouge', 'Languedoc', 2013, 14, 2, 'https://www.vinoclub.fr/895-thickbox_default/vin-saint-chinian-le-mysterieux-2019.jpg'),
('Rosé de Lila ', 'Rosé', "Provence-Alpes-Côte-d'Azur", 1987, 7, 3, 'https://medias.nicolas.com/media/sys_master/images/h29/h30/9373877305374.png'), 
('Viré-Clessé', 'Blanc', 'Vallée de la Loire', 2006, 12, 3, 'https://cave-lugny.com/boutique/84-large_default/vire-clesse.jpg'), 
('Pouilly-Fussé', 'Blanc', 'Bourgogne', 2001, 24, 3, 'https://www.cdiscount.com/pdt2/e/1/8/1/700x700/jbpfuisse18/rw/jean-bouchard-2018-pouilly-fuisse-vin-blanc-de-b.jpg'),
('Côtes de Provence', 'Rosé', "Provence-Alpes-Côte-d'Azur", 2012, 14, 3, 'https://medias.nicolas.com/media/sys_master/images/h1b/h7f/8810764599326.png'), 
('Riesling', 'Blanc', 'Alsace', 2017, 15, 3, 'https://www.geiler.fr/135-large_default/riesling-alsace.jpg'), 
('Muscat', 'Blanc', 'Alsace', 2018, 16, 3, 'https://saint-chinian.pro/734-large_default/cave-le-muscat-muscat-de-saint-jean-de-minervois.jpg'),
('Viognier de Mathieu', 'Blanc', 'Vallée du Rhône', 1994, 12, 4, 'https://www.placedesgrandsvins.com/wp-content/uploads/2014/07/delas-viognier-.png'), 
('Languedoc', 'Rosé', 'Languedoc', 1998, 7, 4, 'https://media.carrefour.fr/medias/6dc194f902163b198eb1125798cce95c/p_540x540/03211200021017-a1r1-s02.jpg'), 
('Crozes-Hermitage', 'Rouge', "Drôme", 2002, 14, 4, 'https://medias.nicolas.com/media/sys_master/images/h05/h69/8808839249950.png'),
('Saint-Emilion', 'Rouge', 'Bordeaux', 2000, 18, 4, 'https://www.lalandemoreau.com/1317-large_default/saint-emilion-aoc-2019-personnalise.jpg'), 
('Saint-Julien', 'Rouge', 'Bordeaux', 2007, 16, 4, 'https://medias.nicolas.com/media/sys_master/h9d/hfe/9199944368158.png'), 
('Saint-Amour', 'Rouge', 'Beaujolais', 2019, 11, 4, 'https://medias.nicolas.com/media/sys_master/images/h7d/h67/8814504542238.png'),
('Bordeaux de Jesse', 'Rouge', 'Bordeaux', 1995, 11, 5, 'https://www.punch-et-cocktail.com/media/catalog/product/cache/7/image/400x/9df78eab33525d08d6e5fb8d27136e95/i/m/image_4959.jpg'), 
('Pommard', 'Blanc', 'Bourgogne', 2020, 12, 5, 'https://www.vinatis.com/65595-detail_default/pommard-2020-domaine-bourgogne-devaux.png'), 
('Mercurey', 'Rouge', 'Bourgogne', 2019, 15, 5, 'https://media.carrefour.fr/medias/16d4b542670c3696924650817ab3d33a/p_540x540/03296313134205-a1n1-s01.jpg'),
('Côte du Rhône', 'Rouge', 'Vallée du Rhône', 2017, 10, 5, 'https://toulouvin.com/1540-large_default/tradition-cave-des-coteaux-du-rhone.webp'), 
('Vin de Savoie', 'Blanc', 'Savoie', 2015, 12, 5, 'https://media.carrefour.fr/medias/b297c691dc3f3ba083ded3261b52f669/p_540x540/03288577511335-a1r1-s02.jpg'), 
('Vin du Bugey', 'Blanc', 'Savoie', 2013, 15, 5, 'https://medias.nicolas.com/media/sys_master/h9e/h4d/9278169186334.png');

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


