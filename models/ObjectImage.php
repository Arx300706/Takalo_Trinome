<?php
require_once __DIR__ . '/BaseModel.php';

/**
 * Modèle ObjectImage - Gestion des images des objets
 */
class ObjectImage extends BaseModel {
    protected string $table = 'object_images';

    /**
     * Récupérer les images d'un objet
     * @param int $objectId
     * @return array
     */
    public function getByObject(int $objectId): array {
        return $this->findBy('object_id', $objectId);
    }

    /**
     * Ajouter une image à un objet
     * @param int $objectId
     * @param string $filename
     * @param bool $isPrimary
     * @return int
     */
    public function addImage(int $objectId, string $filename, bool $isPrimary = false): int {
        return $this->insert([
            'object_id' => $objectId,
            'filename' => $filename,
            'is_primary' => $isPrimary ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Récupérer l'image principale d'un objet
     * @param int $objectId
     * @return array|false
     */
    public function getPrimaryImage(int $objectId): array|false {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE object_id = :object_id AND is_primary = 1 LIMIT 1");
        $stmt->execute(['object_id' => $objectId]);
        return $stmt->fetch();
    }

    /**
     * Définir une image comme principale
     * @param int $imageId
     * @param int $objectId
     * @return bool
     */
    public function setPrimary(int $imageId, int $objectId): bool {
        // Retirer le statut principal des autres images
        $stmt = $this->db->prepare("UPDATE {$this->table} SET is_primary = 0 WHERE object_id = :object_id");
        $stmt->execute(['object_id' => $objectId]);
        
        // Mettre l'image sélectionnée comme principale
        return $this->update($imageId, ['is_primary' => 1]);
    }

    /**
     * Supprimer toutes les images d'un objet
     * @param int $objectId
     * @return bool
     */
    public function deleteByObject(int $objectId): bool {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE object_id = :object_id");
        return $stmt->execute(['object_id' => $objectId]);
    }
}
