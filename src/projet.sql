DROP TABLE user; 
DROP TABLE posts; 
DROP TABLE messages; 
DROP TABLE forum; 
DROP TABLE commentaire; 
DROP TABLE amis; 

CREATE TABLE amis (
	Id int(11) NOT NULL AUTO_INCREMENT,
	Id_user int(11) NOT NULL,
	Ami int(11) NOT NULL,
	Notifications int(11) NOT NULL DEFAULT '0',
	Demande varchar(1) NOT NULL DEFAULT 'T',
	PRIMARY KEY (`Id`)
);


CREATE TABLE commentaire (
	Id int(11) NOT NULL AUTO_INCREMENT,
	Date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	Id_user int(11) NOT NULL,
	Id_post int(11) NOT NULL,
	Contenu text NOT NULL,
	PRIMARY KEY (`Id`)
);


CREATE TABLE forum(
	Id int(11) NOT NULL AUTO_INCREMENT,
	Message text NOT NULL,
	Date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	Discussion varchar(100) NOT NULL,
	User int(11) NOT NULL,
	PRIMARY KEY (`Id`)
);


CREATE TABLE messages(
	Id int(11) NOT NULL AUTO_INCREMENT,
	Expediteur int(10) NOT NULL,
	Message text NOT NULL,
	Recepteur int(10) NOT NULL,
	Date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`Id`)
);



CREATE TABLE posts(
	Id int(11) NOT NULL AUTO_INCREMENT,
	Date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	Titre varchar(100) NOT NULL,
	Contenu text NOT NULL,
	User int(11) NOT NULL,
	PRIMARY KEY (`Id`)
);


CREATE TABLE user(
	Id int(11) NOT NULL AUTO_INCREMENT,
	Utilisateur varchar(20) NOT NULL,
	Mdp varchar(100)  NOT NULL,
	Nom varchar(100)  NOT NULL,
	Prenom varchar(100)  NOT NULL,
	Date date NOT NULL,
	Sexe varchar(1) NOT NULL,
	Email varchar(200)  NOT NULL,
	Image varchar(255)  NOT NULL DEFAULT 'images/autre/Avatar.png',
	Humeur varchar(100)  NOT NULL DEFAULT 'Neutre',
	Visibility varchar(100) NOT NULL DEFAULT 'public',
	Ville varchar(100)  NOT NULL DEFAULT 'Quelquepart',
	Metier varchar(100)  NOT NULL DEFAULT 'Rien',
	Code varchar(100)  NOT NULL,
	Confirme varchar(1) NOT NULL DEFAULT 'F',
	PRIMARY KEY (`Id`)
);