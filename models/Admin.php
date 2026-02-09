<?php
require_once __DIR__ . '/BaseModel.php';

/**
 * Modèle Admin - Gestion des administrateurs
 */
class Admin extends BaseModel {
    protected string $table = 'admins';

    /**
     * Authentifier un administrateur
     * @param string $login
     * @param string $password
     * @return array|false
     */
    public function authenticate(string $login, string $password): array|false {
        $admin = $this->findOneBy('login', $login);
        
        if ($admin && password_verify($password, $admin['password'])) {
            return $admin;
        }
        
        return false;
    }

    /**
     * Créer un admin avec mot de passe hashé
     * @param string $login
     * @param string $password
     * @param string $email
     * @return int
     */
    public function createAdmin(string $login, string $password, string $email = ''): int {
        return $this->insert([
            'login' => $login,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'email' => $email,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Vérifier si un login existe
     * @param string $login
     * @return bool
     */
    public function loginExists(string $login): bool {
        return $this->findOneBy('login', $login) !== false;
    }
}
