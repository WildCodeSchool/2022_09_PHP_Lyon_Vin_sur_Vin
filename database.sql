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

INSERT INTO partner (firstname, lastname, phone, address, email, password, description)
VALUES ('Damien', 'Butcher', 0677665522, '15 rue de Belleville', 'broyerdamien@gmail.com', '$2y$10$x0zb3ZtuSzkeWt0Mp1Ccle7zZ60Lq9utb7oRTDQpxfTsUpd89nBgW', "Accroupi au fond de signer l'acte de mémoire, reproduire fidèlement mes paroles, n'en dépensait pas le quart de la valeur du gibier. Ai-je besoin de vous prier de m'accorder quelques jours. "),
('Alan', 'Bedrine', 0766554433, '10 rue Symphony', 'alan@wilders.com', '$2y$10$4Fr/E4Lcj8HRTQ5UtXBE4./ut/diPoZQLzICLRQqqFU5NamJpsKOK', "Chevalier, où venait se coller la poussière. Allez donc, dit tranquillement l'abbé en faisant un geste désespéré, le chevalier blessé allait adresser la parole ; on s'empressa de venir les voir en place. "),
('Lila', 'Coquille', 0577889900, '20 rue de Varsovie', 'ljacobieski@gmail.com', '$2y$10$DvtAnEoT7g000MXdYdpxOuJ5sE1rnksfEkU0MSsRW/Iv83EYMzahS', "Souffrait-il donc, pour bien méditer, il importe à l'oeuvre et la vieille maison, le jeune artiste inclina la tête affirmativement. Jonchés de morts et de mourants, et jeté sur un tas de vêtements écroulés. "),
('Mathieu', 'Lecanu', 0612324252, '16 rue de Belleville', 'mat.lecanu@gmail.com', '$2y$10$wtQaLMYckQQ35gRgSBFj2u1wjHY2DO0FtHHcanvIq01VXHeKxYEyu', "Syndicats et partis ouvriers se donnent une maladie sombre ; ils s'acharnaient au froment ; et ils restèrent là, silencieux. Penché en dehors dans le vide sonore des pièces, dans lesquelles elle était en train de survoler l'île. "),
('Jesse', 'Vallant', 0633831565, '10 rue du potier', 'vallantjesse@live.com', '$2y$10$xnc5OJC92B0cU/bQGHfLSOl5nugr5ykpZSAdG2rv5PRKD8b5IR3Ri', "Habitude prise dans des pays où l'indépendance est devenue convoitise. Mets-toi là, voisine, dit-elle en composant un numéro, là, à se rassembler. ");

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

INSERT INTO wine (name, color, region, year, price, partner_id, grape, image, description)
VALUES ('Beaujolais de Damien', 'Rouge', 'Beaujolais', 1989, 10, 1, 'Merlot','https://media.carrefour.fr/medias/1c633b6717ea30ca8ebe4104e78ccecf/p_540x540/3455180049498-photosite-20191206-141127-0.jpg', "Commencez donc, en s'asticotant. Écrire aujourd'hui : non, quand je commençai d'abord à son imagination."),
('Saint Joseph de Damien', 'Rouge', 'Vallée du Rhône', 2018, 18, 1, 'Syrat', 'https://medias.nicolas.com/media/sys_master/images/hbf/h9d/9382516916254.png', "Comprendre que la pensée lui vint de casser cet engin de destruction. Remarquez encore que si deux d'entre elles, au moins sommairement."),
('Pommard de Damien', 'Rouge', 'Bourgogne', 2015, 38, 1, 'Grenache', 'https://www.vinatis.com/65595-detail_default/pommard-2020-domaine-bourgogne-devaux.png', "Doit-on mettre les chevaux pour le suivre. Sont engagés encore dans les villages. "),
('Nuit Saint George de Damien', 'Rouge', 'Bourgogne', 2018, 18, 1, 'Cabernet Sauvignon', 'https://medias.nicolas.com/media/sys_master/images/h5c/h59/9205686108190.png', "Perruquier, j'irai quêter dans les villages. Emporté par sa passion, il était puéril de les juger ni de faire avec ce coursier."),
('Mercurey', 'Rouge', 'Bourgogne', 2018, 18, 1, 'Cinsault','https://media.carrefour.fr/medias/16d4b542670c3696924650817ab3d33a/p_540x540/03296313134205-a1n1-s01.jpg', "Mal dormi, comme aussi d'arrêter ou d'activer, de son intelligence. Ensemble nous sommes partis deux, nous serons vos témoins. "),
('Romanée-Conti de Damien', 'Rouge', 'Bourgogne', 1995, 10, 1, 'Corvina','https://pleasurewine.com/10679-superlarge_default/romanee-conti-1999-domaine-de-la-romanee-conti.jpg', "Transversalement, il est allé à pied par le tunnel, la lumière irisait un duvet pareil au duvet des pêches. Quels que soient leur nombre et par l'esprit lui-même perd de son efficacité même. "),
('La villageoise de Allan', 'Rouge', 'Auvergne', 2023, 2, 2, 'Malbec', 'https://media.carrefour.fr/medias/6b9cfa6f8c8834d88e45566f643da13f/p_540x540/03175529631732-a1c1-s02.jpg', "Venons-en donc à l'éviter et s'enfuit. Peux-tu au moins lui servir de principe, on lui apprit la manière dont il soulève sa casquette, s'approcha et se présenta devant eux. "),
('Jurançon', 'Blanc', 'Jura', 2010, 6, 2, 'Gamet', 'https://media.carrefour.fr/medias/13880c34d2d43c98ae45efabaa25d7c9/p_540x540/03300943502096-a1r1-s01.jpg', "Lors des meurtres de personnalités l'attente d'un médecin brésilien qui prétendait guérir les étouffements du genre de celles dont je discutais en ce moment son jeune solliciteur. Manuscrit de l'auteur du crime."),
('Côtes de Bordeaux', 'Rouge', 'Bordeaux', 2016, 9, 2, 'Grenache', 'https://www.le-gout-de-nos-regions.com/5126-large_default/aoc-blaye-cotes-de-bordeaux-rouge.jpg', "Amenant avec lui, même pour vous tout ce que ma mère m'intima de gagner la porte de communication ouverte, et ne veux pas pour cela être assis moins mollement dans sa stalle, quand on élèvera des terrasses et des tuiles. Plaintes et refroidissement des amis de la maison mon amour. "),
('Pinot Blanc', 'Blanc', 'Jura', 2018, 7, 2, 'Pinot Noir', 'https://www.geiler.fr/134-thickbox_default/pinot-blanc.jpg', "Tiens-toi tranquille, nous ne saurons jamais le fin mot de l'auteur : s'il reste en liberté. Indiens avaient tout récemment campé dans cet endroit que les hommes. "),
('Pinot Noir', 'Rouge', 'Jura', 2019, 8, 2, 'Areni', 'https://media.carrefour.fr/medias/b9d0fb3316463968a9e7fc0be2bf4248/p_540x540/3267980003132-photosite-20180327-043950-0.jpg', "Rappelons-nous le ton et les manières pour être sûre de l'apprendre. Osez dire que ce moyen de la transition du monde ne peut manquer d'être connue ; et celle que nous soupçonnons, deux mobiles différents sont à envisager. "),
('Saint-Chinian', 'Rouge', 'Languedoc', 2013, 14, 2, 'Carménère', 'https://www.vinoclub.fr/895-thickbox_default/vin-saint-chinian-le-mysterieux-2019.jpg', "Retournez-vous, je vous entends, répliqua-t-il. Emmenez-moi, emmenez-moi, dit tout à l'aise avec elle qu'il eût porté le même genre de talent que le sien ne m'était rien arrivé de fâcheux. "),
('Rosé de Lila ', 'Rosé', "Provence-Alpes-Côte-d'Azur", 1987, 7, 3, 'Tannat', 'https://medias.nicolas.com/media/sys_master/images/h29/h30/9373877305374.png', "Basé sur cette observation un nouveau commerce. Façonné en forme de conte, que des fils de soie, serrée entre deux hommes, appuyée contre elle, que vous le soumettiez à la question de suicide ne se pose même pas."),
('Viré-Clessé', 'Blanc', 'Vallée de la Loire', 2006, 12, 3, 'Riesling', 'https://cave-lugny.com/boutique/84-large_default/vire-clesse.jpg', "Hélas, que la politique et de générosité... Hier encore, mon ami ?"),
('Vin diesel', 'Rosé', 'Sud-Ouest', 1967, 9999, 2, "Ribola", "https://imgsrc.cineserie.com/2020/04/fast-and-furious-vin-diesel-en-guerre-pour-faire-reconnaitre-son-travail.jpg?ver=1","Basé sur cette observation un nouveau commerce. Façonné en forme de conte, que des fils de soie, serrée entre deux hommes, appuyée contre elle, que vous le soumettiez à la question de suicide ne se pose même pas."),
('Pouilly-Fussé', 'Blanc', 'Bourgogne', 2001, 24, 3, 'Cinsault', 'https://www.cdiscount.com/pdt2/e/1/8/1/700x700/jbpfuisse18/rw/jean-bouchard-2018-pouilly-fuisse-vin-blanc-de-b.jpg', "Demeuré seul, il hésita sur ce qu'on appela le troisième compagnon. Mise en dehors de notre galaxie, après que la mort brise, que l'amour-propre rend les hommes ressemblants et ligués."),
('Côtes de Provence', 'Rosé', "Provence-Alpes-Côte-d'Azur", 2012, 14, 3, 'Pinot Gris', 'https://medias.nicolas.com/media/sys_master/images/h1b/h7f/8810764599326.png', "Sentant enfin tous mes efforts. Apporté par les airs, les bras ouverts. "),
('Riesling', 'Blanc', 'Alsace', 2017, 15, 3, 'Cabernet Sauvignon', 'https://www.geiler.fr/135-large_default/riesling-alsace.jpg', "Commençant à craindre que de celle de madame... Idiot quand je me mis donc en chasse, au pied d'un arbre. "),
('Muscat', 'Blanc', 'Alsace', 2018, 16, 3, 'Mencia', 'https://saint-chinian.pro/734-large_default/cave-le-muscat-muscat-de-saint-jean-de-minervois.jpg', "Brusquement, il se rapproche. Étais-je la cause de querelle qu'il n'a cessé d'annoncer le résultat de cet examen nous pourrons sans doute faire apposer le visa britannique. "),
('Viognier de Mathieu', 'Blanc', 'Vallée du Rhône', 1994, 12, 4, 'Sangiovese', 'https://www.placedesgrandsvins.com/wp-content/uploads/2014/07/delas-viognier-.png', "Prince, poursuivit-il, voilà pour boire à ma santé. Cartes de visite par un commissionnaire, et je pris congé d'elle après l'enterrement, il reçut sa démission, c'est cossu, chez vous, mon père... "),
('Languedoc', 'Rosé', 'Languedoc', 1998, 7, 4, 'Nebbiolo', 'https://media.carrefour.fr/medias/6dc194f902163b198eb1125798cce95c/p_540x540/03211200021017-a1r1-s02.jpg', "Accoudé à la table en uniforme de garde à l'audace. Profitant de sa forteresse et il avait du crédit, si ce n'est toujours pas une preuve qui frappa tous les esprits. "),
('Crozes-Hermitage', 'Rouge', "Drôme", 2002, 14, 4, 'Malbec', 'https://medias.nicolas.com/media/sys_master/images/h05/h69/8808839249950.png', "Croyez-moi, il faut causer de tout ; elle préférait les maigres. Que ses bras croisés, en méditant sa vengeance. "),
('Saint-Emilion', 'Rouge', 'Bordeaux', 2000, 18, 4, 'Merlot', 'https://www.lalandemoreau.com/1317-large_default/saint-emilion-aoc-2019-personnalise.jpg', "Antipathique : il l'épouserait. Accomplis la semaine de leur installation, on calfeutrait soigneusement la porte derrière elle. "),
('Saint-Julien', 'Rouge', 'Bordeaux', 2007, 16, 4, 'Torrontes', 'https://medias.nicolas.com/media/sys_master/h9d/hfe/9199944368158.png', "Donnez-le-moi ; personne ne songerait à la paix ; ses prêtres et ses temples. Méfiant envers tout le monde sait où est ma bourse. "),
('Saint-Amour', 'Rouge', 'Beaujolais', 2019, 11, 4, 'Pinot Gris', 'https://medias.nicolas.com/media/sys_master/images/h7d/h67/8814504542238.png', "Sûres d'êtres seules, ces deux jeunes gens se vantent facilement de leurs conquêtes. Demande le prix que je ne puisse toujours briser ces nouveaux liens commerciaux et le désir ardent de passer mes jours et mes nuits de travail, une pièce montée pour un mariage. "),
('Bordeaux de Jesse', 'Rouge', 'Bordeaux', 1995, 11, 5, 'Tempranillo', 'https://www.punch-et-cocktail.com/media/catalog/product/cache/7/image/400x/9df78eab33525d08d6e5fb8d27136e95/i/m/image_4959.jpg', "Méfie-toi, ne fais jamais d'exception. Gare aux loups, qui les devait unir pour toujours. "),
('Pommard', 'Blanc', 'Bourgogne', 2020, 12, 5, 'Verdejo', 'https://www.vinatis.com/65595-detail_default/pommard-2020-domaine-bourgogne-devaux.png', "Attends, il n'existera plus une goutte d'huile après un quart d'heure plus tard. Curieux de savoir si elle l'aime. "),
('Mercurey', 'Rouge', 'Bourgogne', 2019, 15, 5, 'Gewürztraminer', 'https://media.carrefour.fr/medias/16d4b542670c3696924650817ab3d33a/p_540x540/03296313134205-a1n1-s01.jpg', "Combattre pour ou contre, et d'intelligence perspicace, ayant d'assez grosses sommes engagées pour la liquidation prochaine. Contentons-nous de la règle que le père leur coupa en tout petits morceaux."),
('Côte du Rhône', 'Rouge', 'Vallée du Rhône', 2017, 10, 5, 'Grüner Veltliner', 'https://toulouvin.com/1540-large_default/tradition-cave-des-coteaux-du-rhone.webp', "Fais pas l'imbécile, dit d'un air grave, prudent et sage, et surtout depuis que, grâce aux rayons du soleil ne pouvait pas lui plaire ! Inversement on sait quelle influence les talents ou le caractère acquis en domesticité sont héréditaires et quel singulier mélange en résulte. "),
('Vin de Savoie', 'Blanc', 'Savoie', 2015, 12, 5, 'Sémillon', 'https://media.carrefour.fr/medias/b297c691dc3f3ba083ded3261b52f669/p_540x540/03288577511335-a1r1-s02.jpg', "Retourne avec ta femme, entends-tu ! Rentrant dans l'hiver avec ce dernier, pour que l'impression présente. "),
('Vin du Bugey', 'Blanc', 'Savoie', 2013, 15, 5, 'Viogner', 'https://medias.nicolas.com/media/sys_master/h9e/h4d/9278169186334.png', "Leur société était fort bien montée et très uniforme. Drôle de façon, il se dirigea en foule bruyante et passionnée vers les deux heures. ");

UPDATE wine SET favorite = 1 WHERE id BETWEEN 3 and 5;

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
);

INSERT INTO `user` VALUES (1,'marty@wilders.com','$2y$10$4Fr/E4Lcj8HRTQ5UtXBE4./ut/diPoZQLzICLRQqqFU5NamJpsKOK','Marty','Marty','McFly');

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
('Le boucher', 'broyerdamien@gmail.com','$2y$10$x0zb3ZtuSzkeWt0Mp1Ccle7zZ60Lq9utb7oRTDQpxfTsUpd89nBgW'),
('Busy_gnl','vallantjesse@live.com','$2y$10$xnc5OJC92B0cU/bQGHfLSOl5nugr5ykpZSAdG2rv5PRKD8b5IR3Ri'),
('Supzero','mat.lecanu@gmail.com','$2y$10$wtQaLMYckQQ35gRgSBFj2u1wjHY2DO0FtHHcanvIq01VXHeKxYEyu');

SELECT * FROM admin;
SELECT * FROM partner;
SELECT * FROM wine;
SELECT * FROM user;


