CREATE DATABASE drive

CREATE TABLE role(id_role int(11) AUTO_INCREMENT PRIMARY KEY,name varchar(255))

CREATE TABLE client(id_client int(11) AUTO_INCREMENT PRIMARY KEY,nom varchar(150),prenom varchar(150),email varchar(255) UNIQUE,password varchar(255),role int(11), statut boolean, FOREIGN KEY (role) REFERENCES role(id_role));

CREATE TABLE categorie(id_categorie int(11) AUTO_INCREMENT PRIMARY KEY, nom varchar(255), description text)

CREATE TABLE vehicule(id_vehicule int(11) AUTO_INCREMENT PRIMARY KEY, modele varchar(255), prix float(10,2),disponibilite boolean,id_categorie int(11),FOREIGN KEY (id_categorie) REFERENCES categorie(id_categorie));

CREATE TABLE Reservation (id_reservation INT(11) AUTO_INCREMENT PRIMARY KEY,date_start DATE,date_end DATE,lieu_charge VARCHAR(255),id_client INT(11),id_vehicule INT(11),FOREIGN KEY (id_client)     REFERENCES client(id_client)     ON DELETE CASCADE     ON UPDATE CASCADE,FOREIGN KEY (id_vehicule)     REFERENCES vehicule(id_vehicule)     ON DELETE CASCADE     ON UPDATE CASCADE
);


CREATE TABLE avis(id_avis int(11) AUTO_INCREMENT PRIMARY KEY,note int,commentaire text, date_avis date,time_avis time,id_client int,id_vehicule int, FOREIGN KEY (id_client) REFERENCES client(id_client), FOREIGN KEY (id_vehicule) REFERENCES vehicule(id_vehicule));

ALTER TABLE Reservation ADD CONSTRAINT vehicule FOREIGN KEY (id_vehicule) REFERENCES vehicule(id_vehicule) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE client ADD CONSTRAINT role FOREIGN KEY (role) REFERENCES role(id_role) ON DELETE CASCADE ON UPDATE CASCADE;


INSERT INTO avis(note,commentaire,date_avis,time_avis,id_client,id_vehicule) VALUES(5,"i very like the service",CURRENT_DATE,CURRENT_TIME,2,1)