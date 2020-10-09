DROP DATABASE IF EXISTS TP02;
CREATE DATABASE TP02;
USE TP02;

CREATE TABLE STATION (
num_station INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
nom_station VARCHAR(50)
);

CREATE TABLE CLIENTELE (
num_client INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
prenom_client VARCHAR(50) NOT NULL,
nom_client VARCHAR(50) NOT NULL,
adresse_client VARCHAR(150));


CREATE TABLE HOTEL (
num_hotel  INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
num_station INT NOT NULL, CONSTRAINT HOTEL_STATION_FK FOREIGN KEY (num_station) REFERENCES STATION(num_station)tp02,
nom_hotel VARCHAR(50) NOT NULL,
adresse_hotel VARCHAR(150),
categorie_hotel VARCHAR(30),
capacite_hotel INT);

CREATE TABLE CHAMBRE (
num_chambre INT NOT NULL PRIMARY KEY,
num_hotel INT NOT NULL, CONSTRAINT CHAMBRE_HOTEL_FK FOREIGN KEY (num_hotel) REFERENCES HOTEL(num_hotel),
type_chambre VARCHAR(30),
expoistion VARCHAR(30),
degre_confort INT,
capacite_chambre INT);

CREATE TABLE RESERVATION (
num_chambre INT NOT NULL,
num_client INT NOT NULL,
CONSTRAINT RESERVATION_PK PRIMARY KEY (num_chambre, num_client),
CONSTRAINT RESERVATION_CHAMBRE_FK FOREIGN KEY (num_chambre) REFERENCES CHAMBRE(num_chambre),
CONSTRAINT RESERVATION_CLIENTELE_FK FOREIGN KEY (num_client) REFERENCES CLIENTELE(num_client));


-- création des utilisateurs
CREATE USER 'geoffrey'@'%' IDENTIFIED BY 'mdp1';
CREATE USER 'dimitri_klenkovic'@'%' IDENTIFIED BY 'mdp2';
CREATE USER 'celine_bettens'@'%' IDENTIFIED BY 'mdp3';

-- affectation des privilèges utilisateurs
GRANT ALL PRIVILEGES ON TP02.* TO 'geoffrey'@'%' IDENTIFIED BY 'mdp1';
GRANT SELECT ON TP02.* TO 'dimitri'@'%' IDENTIFIED BY 'mdp2';
GRANT SELECT ON TP02.station TO 'celine'@'%' IDENTIFIED BY 'mdp3';

-- Affiche la liste des utilisateurs:
-- select * from mysql.user;

