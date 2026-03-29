CREATE DATABASE iran_news;

use iran_news;

CREATE TABLE categorie(
   id INT AUTO_INCREMENT,
   libelle VARCHAR(50),
   PRIMARY KEY(id)
);

CREATE TABLE article(
   id INT AUTO_INCREMENT,
   titre VARCHAR(50),
   contenu TEXT,
   date_pub DATE,
   image_url VARCHAR(100),
   id_categorie INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(id_categorie) REFERENCES categorie(id)
);

CREATE TABLE utilisateur(
   id INT AUTO_INCREMENT,
   nom VARCHAR(50),
   mdp VARCHAR(50),
   email VARCHAR(50),
   role INT,
   PRIMARY KEY(id)
);

-- Insertion d'un utilisateur admin par défaut
-- Mot de passe: admin123 (à changer après installation)
INSERT INTO utilisateur (nom, mdp, email, role) VALUES
('admin', '123', 'admin@iran.com', 1);

-- Insertion de catégories par défaut
INSERT INTO categorie (libelle) VALUES
('Actualités'),
('Analyses'),
('Témoignages'),
('Géopolitique');

-- Insertion d'articles de démonstration
INSERT INTO article (titre, contenu, date_pub, image_url, id_categorie) VALUES
('La situation humanitaire à Téhéran', 'Contenu de l\'article...La capitale iranienne fait face à une crise humanitaire sans précédent...', NOW(), null, 1);
INSERT INTO article (titre, contenu, date_pub, image_url, id_categorie) VALUES
('La situation humanitaire à Téhéran', 'Contenu de l\'article...La capitale iranienne fait face à une crise humanitaire sans précédent...', NOW(), null, 1);