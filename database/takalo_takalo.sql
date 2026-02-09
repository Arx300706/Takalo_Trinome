-- ============================================
-- Base de données Takalo-Takalo
-- Script de création et données de test
-- ============================================

-- Création de la base de données
CREATE DATABASE IF NOT EXISTS takalo_takalo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE takalo_takalo;

-- ============================================
-- Table des administrateurs
-- ============================================
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================
-- Table des utilisateurs
-- ============================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    telephone VARCHAR(20) DEFAULT NULL,
    adresse TEXT DEFAULT NULL,
    status ENUM('active', 'inactive', 'banned') DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================
-- Table des catégories
-- ============================================
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================
-- Table des objets
-- ============================================
CREATE TABLE IF NOT EXISTS objects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    category_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT DEFAULT NULL,
    estimated_price DECIMAL(15, 2) DEFAULT 0,
    status ENUM('available', 'exchanged', 'unavailable') DEFAULT 'available',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ============================================
-- Table des images d'objets
-- ============================================
CREATE TABLE IF NOT EXISTS object_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    object_id INT NOT NULL,
    filename VARCHAR(255) NOT NULL,
    is_primary TINYINT(1) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (object_id) REFERENCES objects(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============================================
-- Table des échanges
-- ============================================
CREATE TABLE IF NOT EXISTS exchanges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    proposer_object_id INT NOT NULL COMMENT 'Objet proposé par l''initiateur',
    requested_object_id INT NOT NULL COMMENT 'Objet demandé en échange',
    proposer_user_id INT NOT NULL COMMENT 'Utilisateur qui propose l''échange',
    status ENUM('pending', 'accepted', 'refused', 'cancelled') DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    accepted_at DATETIME DEFAULT NULL,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (proposer_object_id) REFERENCES objects(id) ON DELETE CASCADE,
    FOREIGN KEY (requested_object_id) REFERENCES objects(id) ON DELETE CASCADE,
    FOREIGN KEY (proposer_user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============================================
-- DONNÉES DE TEST
-- ============================================

-- Admin par défaut (mot de passe: admin123)
INSERT INTO admins (login, password, email) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@takalo.mg');

-- Catégories de test
INSERT INTO categories (name, description) VALUES 
('Vêtements', 'Hauts, bas, chaussures et accessoires vestimentaires'),
('Livres', 'Romans, mangas, manuels scolaires et magazines'),
('High-Tech', 'Téléphones, ordinateurs, tablettes et accessoires'),
('Meubles', 'Chaises, tables, armoires et décoration maison'),
('Sports & Loisirs', 'Équipements sportifs, vélos, jeux de société'),
('DVD & Jeux Vidéo', 'Films, séries, jeux PlayStation, Xbox, Nintendo'),
('Électroménager', 'Petit et gros électroménager'),
('Jouets & Enfants', 'Jouets, jeux éducatifs, vêtements enfants');

-- Utilisateurs de test (mot de passe: password123)
INSERT INTO users (nom, prenom, email, password, telephone, adresse) VALUES 
('RAKOTO', 'Jean', 'jean.rakoto@email.mg', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+261 34 00 000 01', 'Antananarivo, Madagascar'),
('RASOA', 'Marie', 'marie.rasoa@email.mg', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+261 34 00 000 02', 'Toamasina, Madagascar'),
('RABE', 'Paul', 'paul.rabe@email.mg', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+261 34 00 000 03', 'Antsirabe, Madagascar'),
('RAZAFY', 'Lova', 'lova.razafy@email.mg', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+261 34 00 000 04', 'Fianarantsoa, Madagascar');

-- Objets de test
INSERT INTO objects (user_id, category_id, title, description, estimated_price, status) VALUES 
-- Objets de Jean (user_id = 1)
(1, 1, 'Veste en cuir vintage', 'Veste en cuir noir authentique, taille M, très bon état', 150000, 'available'),
(1, 2, 'Collection Harry Potter', 'Les 7 tomes en français, édition Gallimard', 80000, 'available'),
(1, 3, 'Écouteurs Bluetooth Sony', 'Sony WH-1000XM4, réduction de bruit active', 200000, 'available'),

-- Objets de Marie (user_id = 2)
(2, 1, 'Robe de soirée bleue', 'Robe longue élégante, taille S, portée une fois', 75000, 'available'),
(2, 4, 'Table basse en bois', 'Table basse scandinave, 80x50cm, bois massif', 120000, 'available'),
(2, 6, 'Collection DVD Marvel', '15 films Marvel en blu-ray', 100000, 'available'),

-- Objets de Paul (user_id = 3)
(3, 5, 'Vélo VTT Rockrider', 'VTT 26 pouces, 21 vitesses, bon état', 250000, 'available'),
(3, 3, 'Tablette Samsung Galaxy Tab', 'Galaxy Tab A8, 64Go, avec housse', 180000, 'available'),
(3, 2, 'Manga One Piece 1-50', 'Tomes 1 à 50 de One Piece, édition française', 150000, 'available'),

-- Objets de Lova (user_id = 4)
(4, 8, 'Console Nintendo Switch', 'Switch avec 2 jeux (Zelda + Mario Kart)', 350000, 'available'),
(4, 1, 'Sneakers Nike Air Max', 'Nike Air Max 90, taille 42, neuves', 180000, 'available'),
(4, 7, 'Machine à café Nespresso', 'Nespresso Vertuo, avec 50 capsules', 120000, 'available');

-- Quelques propositions d'échange de test
INSERT INTO exchanges (proposer_object_id, requested_object_id, proposer_user_id, status) VALUES 
(1, 4, 1, 'pending'),  -- Jean propose sa veste pour la robe de Marie
(7, 3, 3, 'pending'),  -- Paul propose son vélo pour les écouteurs de Jean
(10, 6, 4, 'pending'); -- Lova propose sa Switch pour les DVD de Marie

-- ============================================
-- Index pour optimisation
-- ============================================
CREATE INDEX idx_objects_user ON objects(user_id);
CREATE INDEX idx_objects_category ON objects(category_id);
CREATE INDEX idx_objects_status ON objects(status);
CREATE INDEX idx_exchanges_status ON exchanges(status);
CREATE INDEX idx_users_email ON users(email);
