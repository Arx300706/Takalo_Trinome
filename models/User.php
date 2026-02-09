<?php
require_once __DIR__ . '/BaseModel.php';

/**
 * Modèle User - Gestion des utilisateurs (clients)
 */
class User extends BaseModel {
    protected string $table = 'users';

    /**
     * Authentifier un utilisateur
     * @param string $email
     * @param string $password
     * @return array|false
     */
    public function authenticate(string $email, string $password): array|false {
        $user = $this->findOneBy('email', $email);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }

    /**
     * Inscription d'un nouvel utilisateur
     * @param array $data
     * @return int
     */
    public function register(array $data): int {
        return $this->insert([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'telephone' => $data['telephone'] ?? null,
            'adresse' => $data['adresse'] ?? null,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Vérifier si un email existe
     * @param string $email
     * @return bool
     */
    public function emailExists(string $email): bool {
        return $this->findOneBy('email', $email) !== false;
    }

    /**
     * Récupérer les utilisateurs actifs
     * @return array
     */
    public function getActiveUsers(): array {
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE status = 'active' ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    /**
     * Mettre à jour le profil
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateProfile(int $id, array $data): bool {
        $allowedFields = ['nom', 'prenom', 'telephone', 'adresse'];
        $filteredData = array_intersect_key($data, array_flip($allowedFields));
        $filteredData['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->update($id, $filteredData);
    }
}
