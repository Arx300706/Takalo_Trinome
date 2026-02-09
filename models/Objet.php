<?php
require_once __DIR__ . '/BaseModel.php';

/**
 * Modèle Objet - Gestion des objets à échanger
 */
class Objet extends BaseModel {
    protected string $table = 'objects';

    /**
     * Récupérer tous les objets avec leurs catégories et propriétaires
     * @return array
     */
    public function getAllWithDetails(): array {
        $sql = "SELECT o.*, c.name as category_name, u.nom, u.prenom 
                FROM {$this->table} o 
                LEFT JOIN categories c ON o.category_id = c.id 
                LEFT JOIN users u ON o.user_id = u.id 
                ORDER BY o.created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Récupérer les objets d'un utilisateur
     * @param int $userId
     * @return array
     */
    public function getByUser(int $userId): array {
        $sql = "SELECT o.*, c.name as category_name 
                FROM {$this->table} o 
                LEFT JOIN categories c ON o.category_id = c.id 
                WHERE o.user_id = :user_id 
                ORDER BY o.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    /**
     * Récupérer les objets des autres utilisateurs (pour échange)
     * @param int $excludeUserId
     * @return array
     */
    public function getOthersObjects(int $excludeUserId): array {
        $sql = "SELECT o.*, c.name as category_name, u.nom, u.prenom 
                FROM {$this->table} o 
                LEFT JOIN categories c ON o.category_id = c.id 
                LEFT JOIN users u ON o.user_id = u.id 
                WHERE o.user_id != :user_id AND o.status = 'available'
                ORDER BY o.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $excludeUserId]);
        return $stmt->fetchAll();
    }

    /**
     * Créer un objet
     * @param array $data
     * @return int
     */
    public function createObject(array $data): int {
        return $this->insert([
            'user_id' => $data['user_id'],
            'category_id' => $data['category_id'],
            'title' => $data['title'],
            'description' => $data['description'],
            'estimated_price' => $data['estimated_price'],
            'status' => 'available',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Récupérer les objets par catégorie
     * @param int $categoryId
     * @return array
     */
    public function getByCategory(int $categoryId): array {
        $sql = "SELECT o.*, u.nom, u.prenom 
                FROM {$this->table} o 
                LEFT JOIN users u ON o.user_id = u.id 
                WHERE o.category_id = :category_id AND o.status = 'available'
                ORDER BY o.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['category_id' => $categoryId]);
        return $stmt->fetchAll();
    }

    /**
     * Changer le statut d'un objet
     * @param int $id
     * @param string $status
     * @return bool
     */
    public function updateStatus(int $id, string $status): bool {
        return $this->update($id, ['status' => $status, 'updated_at' => date('Y-m-d H:i:s')]);
    }

    /**
     * Compter les objets disponibles
     * @return int
     */
    public function countAvailable(): int {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM {$this->table} WHERE status = 'available'");
        return (int) $stmt->fetch()['total'];
    }
}
