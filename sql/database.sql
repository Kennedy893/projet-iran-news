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

CREATE TABLE image(
   id INT AUTO_INCREMENT,
   chemin VARCHAR(100),
   type_image INT, -- 1=primaire, 2=secondaire
   id_article INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(id_article) REFERENCES article(id)
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
INSERT INTO article (titre, contenu, date_pub, id_categorie) VALUES
('La situation humanitaire à Téhéran', 'Contenu de l\'article...La capitale iranienne fait face à une crise humanitaire sans précédent...', NOW(), 1),
('Escalade des tensions régionales', 'Contenu de l\'article...Les analyses diplomatiques signalent une période de forte instabilité...', NOW(), 4);

-- Insertion d'images liées aux articles
INSERT INTO image (chemin, type_image, id_article) VALUES
('uploads/articles/demo-primaire-1.jpg', 1, 1),
('uploads/articles/demo-secondaire-1.jpg', 2, 1),
('uploads/articles/demo-secondaire-2.jpg', 2, 1),
('uploads/articles/demo-primaire-2.jpg', 1, 2);