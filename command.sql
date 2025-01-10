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


CREATE TABLE article(id_article INT AUTO_INCREMENT PRIMARY KEY NOT NULL, title varchar(550) NOT NULL, content longtext, date_create DATE, id_client int, is_approved boolean, id_them int, FOREIGN KEY (id_client) REFERENCES client(id_client), FOREIGN KEY (id_them) REFERENCES them(id_them));

CREATE TABLE them(id_them int AUTO_INCREMENT PRIMARY KEY NOT NULL, name varchar(255), description text)

CREATE TABLE tag(id_tag int AUTO_INCREMENT PRIMARY KEY NOT NULL, name varchar(550));

CREATE TABLE comment(id_comment INT AUTO_INCREMENT PRIMARY KEY NOT NULL, content longtext, date_create DATE, id_client int, id_article int, FOREIGN KEY (id_client) REFERENCES client(id_client), FOREIGN KEY (id_article) REFERENCES article(id_article));

CREATE TABLE favorite(id_favorite int AUTO_INCREMENT PRIMARY KEY, id_client int, id_article int, FOREIGN KEY (id_article) REFERENCES article(id_article),FOREIGN KEY (id_client) REFERENCES client(id_client))

CREATE TABLE tag_article(id_assoc int AUTO_INCREMENT PRIMARY KEY NOT NULL, id_article int, id_tag int, FOREIGN KEY (id_article) REFERENCES article(id_article), FOREIGN KEY (id_tag) REFERENCES tag(id_tag))

ALTER TABLE article
ADD CONSTRAINT them FOREIGN KEY (id_them) REFERENCES them(id_them)
    ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE article
ADD CONSTRAINT client FOREIGN KEY (id_client) REFERENCES client(id_client)
    ON DELETE CASCADE ON UPDATE CASCADE;