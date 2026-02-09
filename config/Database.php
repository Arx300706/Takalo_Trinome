<?php
/**
 * Classe de configuration de la base de données
 * Singleton Pattern pour une seule instance de connexion
 */
class Database {
    private static ?PDO $instance = null;
    
    private const HOST = 'localhost';
    private const DBNAME = 'takalo_takalo';
    private const USERNAME = 'root';
    private const PASSWORD = '';
    private const CHARSET = 'utf8mb4';

    /**
     * Empêcher l'instanciation directe
     */
    private function __construct() {}

    /**
     * Empêcher le clonage
     */
    private function __clone() {}

    /**
     * Obtenir l'instance de connexion PDO
     * @return PDO
     */
    public static function getInstance(): PDO {
        if (self::$instance === null) {
            try {
                $dsn = "mysql:host=" . self::HOST . ";dbname=" . self::DBNAME . ";charset=" . self::CHARSET;
                self::$instance = new PDO($dsn, self::USERNAME, self::PASSWORD, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]);
            } catch (PDOException $e) {
                die("Erreur de connexion à la base de données: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
