<?php
/**
 * Configuration globale de l'application Takalo-Takalo
 */

// Configuration de base
define('APP_NAME', 'Takalo-Takalo');
define('APP_VERSION', '1.0.0');
define('BASE_URL', ''); // Vide pour le serveur intégré PHP

// Mode debug (mettre false en production)
define('DEBUG_MODE', true);

// Configuration des sessions
define('SESSION_LIFETIME', 3600); // 1 heure

// Informations de l'équipe pour le footer
define('TEAM_INFO', [
    ['nom' => 'NOM Prénom', 'etu' => 'ETU00000'],
    ['nom' => 'NOM Prénom', 'etu' => 'ETU00001'],
    ['nom' => 'NOM Prénom', 'etu' => 'ETU00002'],
]);

// Liens du projet
define('GITHUB_LINK', '#');
define('TASKS_LINK', '#');

// Admin par défaut
define('DEFAULT_ADMIN_LOGIN', 'admin');
define('DEFAULT_ADMIN_PASSWORD', 'admin123');

// Configuration upload images
define('UPLOAD_DIR', __DIR__ . '/../uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
