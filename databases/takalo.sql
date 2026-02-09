CREATE DATABASE Takalo;
use takalo;

-- =========================
-- CREATION DES TABLES
-- =========================

CREATE TABLE user (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- -------------------------

CREATE TABLE categorie (
    id_categorie INT PRIMARY KEY AUTO_INCREMENT,
    nom_categorie VARCHAR(100) NOT NULL UNIQUE
);

-- -------------------------

CREATE TABLE objet (
    id_objet INT PRIMARY KEY AUTO_INCREMENT,
    nom_objet VARCHAR(150) NOT NULL,
    id_user INT NOT NULL,

    CONSTRAINT fk_objet_user
        FOREIGN KEY (id_user)
        REFERENCES user(id_user)
        ON DELETE CASCADE
);

-- -------------------------

CREATE TABLE objet_image (
    id_image INT PRIMARY KEY AUTO_INCREMENT,
    id_categorie INT NOT NULL,

    CONSTRAINT fk_image_categorie
        FOREIGN KEY (id_categorie)
        REFERENCES categorie(id_categorie)
        ON DELETE CASCADE
);

-- -------------------------

CREATE TABLE echange (
    id_echange INT PRIMARY KEY AUTO_INCREMENT,
    id_sender INT NOT NULL,
    id_receiver INT NOT NULL,
    id_objet INT NOT NULL,

    CONSTRAINT fk_echange_sender
        FOREIGN KEY (id_sender)
        REFERENCES user(id_user)
        ON DELETE CASCADE,

    CONSTRAINT fk_echange_receiver
        FOREIGN KEY (id_receiver)
        REFERENCES user(id_user)
        ON DELETE CASCADE,

    CONSTRAINT fk_echange_objet
        FOREIGN KEY (id_objet)
        REFERENCES objet(id_objet)
        ON DELETE CASCADE
);

-- -------------------------

CREATE TABLE etat (
    id_etat INT PRIMARY KEY AUTO_INCREMENT,
    valeur VARCHAR(50) NOT NULL UNIQUE
);

-- -------------------------

CREATE TABLE etat_echange (
    id_etat_echange INT PRIMARY KEY AUTO_INCREMENT,
    id_echange INT NOT NULL,
    id_etat INT NOT NULL,
    date_etat DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_etat_echange_echange
        FOREIGN KEY (id_echange)
        REFERENCES echange(id_echange)
        ON DELETE CASCADE,

    CONSTRAINT fk_etat_echange_etat
        FOREIGN KEY (id_etat)
        REFERENCES etat(id_etat)
        ON DELETE CASCADE
);

-- =========================
-- INDEX UTILES
-- =========================

CREATE INDEX idx_objet_user ON objet(id_user);
CREATE INDEX idx_echange_sender ON echange(id_sender);
CREATE INDEX idx_echange_receiver ON echange(id_receiver);
CREATE INDEX idx_etat_echange_echange ON etat_echange(id_echange);

-- =========================
-- VALEURS INITIALES ETAT
-- =========================

INSERT INTO etat (valeur) VALUES
('en attente'),
('accepté'),
('refusé');
