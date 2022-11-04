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

CREATE TABLE partner (
id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
firstname VARCHAR(100) NOT NULL,
lastname VARCHAR(100),
address VARCHAR(255),
email VARCHAR(100),
phone VARCHAR(10),
description TEXT(1000)
);
CREATE TABLE wine (
id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
name VARCHAR(100) NOT NULL,
year YEAR NOT NULL,
category VARCHAR(100),
price INT NOT NULL,
description TEXT(1000),
partner_id INT NOT NULL,
favorite BOOLEAN,
CONSTRAINT fk_wine_partner FOREIGN KEY (partner_id) REFERENCES partner(id)
);

INSERT INTO partner (firstname, phone)
VALUES ('Damien', 0677665522), ('Allan', 0766554433), ('Lila', 0577889900), ('Mathieu', 0612324252), ('Jesse', 0633831565);

INSERT INTO wine (name, year, price, partner_id)
VALUES ('Beaujolais de Damien', 1989, 10, 1), ('La villageoise de Allan', 2023, 2, 2), ('Rosé de Lila ', 1987, 7, 3),
('Viognier de Mathieu', 1994, 12, 4), ('Bordeaux de Jesse', 1995, 11, 5);
UPDATE wine SET favorite = 1 WHERE id BETWEEN 1 and 3;

SELECT * FROM partner;
SELECT * FROM wine;

