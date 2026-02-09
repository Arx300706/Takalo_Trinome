<?php
require_once __DIR__ . '/BaseModel.php';

/**
 * Modèle Exchange - Gestion des propositions d'échange
 */
class Exchange extends BaseModel {
    protected string $table = 'exchanges';

    /**
     * Créer une proposition d'échange
     * @param int $proposerObjectId - L'objet proposé par l'utilisateur
     * @param int $requestedObjectId - L'objet demandé en échange
     * @param int $proposerUserId - L'utilisateur qui propose
     * @return int
     */
    public function createExchange(int $proposerObjectId, int $requestedObjectId, int $proposerUserId): int {
        return $this->insert([
            'proposer_object_id' => $proposerObjectId,
            'requested_object_id' => $requestedObjectId,
            'proposer_user_id' => $proposerUserId,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Récupérer les propositions reçues par un utilisateur
     * @param int $userId
     * @return array
     */
    public function getReceivedProposals(int $userId): array {
        $sql = "SELECT e.*, 
                       op.title as proposer_object_title, op.estimated_price as proposer_object_price,
                       or2.title as requested_object_title, or2.estimated_price as requested_object_price,
                       u.nom as proposer_nom, u.prenom as proposer_prenom
                FROM {$this->table} e
                LEFT JOIN objects op ON e.proposer_object_id = op.id
                LEFT JOIN objects or2 ON e.requested_object_id = or2.id
                LEFT JOIN users u ON e.proposer_user_id = u.id
                WHERE or2.user_id = :user_id
                ORDER BY e.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    /**
     * Récupérer les propositions envoyées par un utilisateur
     * @param int $userId
     * @return array
     */
    public function getSentProposals(int $userId): array {
        $sql = "SELECT e.*, 
                       op.title as proposer_object_title,
                       or2.title as requested_object_title,
                       u.nom as owner_nom, u.prenom as owner_prenom
                FROM {$this->table} e
                LEFT JOIN objects op ON e.proposer_object_id = op.id
                LEFT JOIN objects or2 ON e.requested_object_id = or2.id
                LEFT JOIN users u ON or2.user_id = u.id
                WHERE e.proposer_user_id = :user_id
                ORDER BY e.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    /**
     * Accepter un échange
     * @param int $exchangeId
     * @return bool
     */
    public function acceptExchange(int $exchangeId): bool {
        $exchange = $this->findById($exchangeId);
        if (!$exchange) return false;

        // Mettre à jour le statut de l'échange
        $this->update($exchangeId, [
            'status' => 'accepted',
            'accepted_at' => date('Y-m-d H:i:s')
        ]);

        // Échanger les propriétaires des objets
        require_once __DIR__ . '/Objet.php';
        $objetModel = new Objet();
        
        $proposerObject = $objetModel->findById($exchange['proposer_object_id']);
        $requestedObject = $objetModel->findById($exchange['requested_object_id']);
        
        if ($proposerObject && $requestedObject) {
            $objetModel->update($exchange['proposer_object_id'], [
                'user_id' => $requestedObject['user_id'],
                'status' => 'exchanged'
            ]);
            $objetModel->update($exchange['requested_object_id'], [
                'user_id' => $proposerObject['user_id'],
                'status' => 'exchanged'
            ]);
        }

        return true;
    }

    /**
     * Refuser un échange
     * @param int $exchangeId
     * @return bool
     */
    public function refuseExchange(int $exchangeId): bool {
        return $this->update($exchangeId, [
            'status' => 'refused',
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Vérifier si un échange existe déjà
     * @param int $proposerObjectId
     * @param int $requestedObjectId
     * @return bool
     */
    public function exchangeExists(int $proposerObjectId, int $requestedObjectId): bool {
        $stmt = $this->db->prepare(
            "SELECT id FROM {$this->table} 
             WHERE proposer_object_id = :prop_id AND requested_object_id = :req_id AND status = 'pending'"
        );
        $stmt->execute(['prop_id' => $proposerObjectId, 'req_id' => $requestedObjectId]);
        return $stmt->fetch() !== false;
    }

    /**
     * Compter les propositions en attente pour un utilisateur
     * @param int $userId
     * @return int
     */
    public function countPendingForUser(int $userId): int {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} e
                LEFT JOIN objects o ON e.requested_object_id = o.id
                WHERE o.user_id = :user_id AND e.status = 'pending'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return (int) $stmt->fetch()['total'];
    }
}
