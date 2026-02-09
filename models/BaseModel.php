<?php
require_once __DIR__ . '/../config/Database.php';

/**
 * Classe de base abstraite pour tous les modèles
 * Pattern Active Record simplifié
 */
abstract class BaseModel {
    protected PDO $db;
    protected string $table;
    protected string $primaryKey = 'id';

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Récupérer tous les enregistrements
     * @return array
     */
    public function findAll(): array {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY {$this->primaryKey} DESC");
        return $stmt->fetchAll();
    }

    /**
     * Trouver par ID
     * @param int $id
     * @return array|false
     */
    public function findById(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Insérer un enregistrement
     * @param array $data
     * @return int ID inséré
     */
    public function insert(array $data): int {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $stmt = $this->db->prepare("INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})");
        $stmt->execute($data);
        
        return (int) $this->db->lastInsertId();
    }

    /**
     * Mettre à jour un enregistrement
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool {
        $setParts = [];
        foreach (array_keys($data) as $key) {
            $setParts[] = "{$key} = :{$key}";
        }
        $setClause = implode(', ', $setParts);
        
        $data['id'] = $id;
        $stmt = $this->db->prepare("UPDATE {$this->table} SET {$setClause} WHERE {$this->primaryKey} = :id");
        
        return $stmt->execute($data);
    }

    /**
     * Supprimer un enregistrement
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Compter le nombre total d'enregistrements
     * @return int
     */
    public function count(): int {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM {$this->table}");
        return (int) $stmt->fetch()['total'];
    }

    /**
     * Recherche personnalisée
     * @param string $column
     * @param mixed $value
     * @return array
     */
    public function findBy(string $column, mixed $value): array {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$column} = :value");
        $stmt->execute(['value' => $value]);
        return $stmt->fetchAll();
    }

    /**
     * Trouver un seul enregistrement par colonne
     * @param string $column
     * @param mixed $value
     * @return array|false
     */
    public function findOneBy(string $column, mixed $value): array|false {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$column} = :value LIMIT 1");
        $stmt->execute(['value' => $value]);
        return $stmt->fetch();
    }
}
