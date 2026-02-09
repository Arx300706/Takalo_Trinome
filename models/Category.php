<?php
require_once __DIR__ . '/BaseModel.php';

/**
 * Modèle Category - Gestion des catégories d'objets
 */
class Category extends BaseModel {
    protected string $table = 'categories';

    /**
     * Récupérer toutes les catégories avec le nombre d'objets
     * @return array
     */
    public function getAllWithObjectCount(): array {
        $sql = "SELECT c.*, COUNT(o.id) as object_count 
                FROM {$this->table} c 
                LEFT JOIN objects o ON c.id = o.category_id 
                GROUP BY c.id 
                ORDER BY c.name ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Créer une catégorie
     * @param string $name
     * @param string $description
     * @return int
     */
    public function createCategory(string $name, string $description = ''): int {
        return $this->insert([
            'name' => $name,
            'description' => $description,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Vérifier si une catégorie existe par son nom
     * @param string $name
     * @return bool
     */
    public function nameExists(string $name): bool {
        return $this->findOneBy('name', $name) !== false;
    }

    /**
     * Récupérer les catégories actives (pour formulaires)
     * @return array
     */
    public function getActiveCategories(): array {
        $stmt = $this->db->query("SELECT id, name FROM {$this->table} ORDER BY name ASC");
        return $stmt->fetchAll();
    }
}
