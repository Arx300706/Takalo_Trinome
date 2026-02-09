<?php
require_once __DIR__ . '/../config/config.php';

/**
 * Contrôleur de base abstrait
 * Fournit les méthodes communes à tous les contrôleurs
 */
abstract class BaseController {
    
    /**
     * Démarrer la session si pas déjà démarrée
     */
    protected function startSession(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Rendre une vue
     * @param string $view Chemin de la vue (ex: 'auth/login')
     * @param array $data Données à passer à la vue
     * @param string|null $layout Layout à utiliser (null = pas de layout)
     */
    protected function render(string $view, array $data = [], ?string $layout = 'main'): void {
        // Extraire les données pour les rendre disponibles dans la vue
        extract($data);
        
        // Définir le chemin de la vue
        $viewPath = __DIR__ . '/../views/' . $view . '.php';
        
        if ($layout) {
            // Capturer le contenu de la vue
            ob_start();
            require $viewPath;
            $content = ob_get_clean();
            
            // Charger le layout avec le contenu
            require __DIR__ . '/../views/layouts/' . $layout . '.php';
        } else {
            require $viewPath;
        }
    }

    /**
     * Redirection
     * @param string $url
     */
    protected function redirect(string $url): void {
        header("Location: " . BASE_URL . $url);
        exit;
    }

    /**
     * Retourner une réponse JSON
     * @param array $data
     * @param int $statusCode
     */
    protected function json(array $data, int $statusCode = 200): void {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Vérifier si la requête est AJAX
     * @return bool
     */
    protected function isAjax(): bool {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    /**
     * Récupérer une valeur POST
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    protected function post(string $key, mixed $default = null): mixed {
        return $_POST[$key] ?? $default;
    }

    /**
     * Récupérer une valeur GET
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    protected function get(string $key, mixed $default = null): mixed {
        return $_GET[$key] ?? $default;
    }

    /**
     * Définir un message flash
     * @param string $type
     * @param string $message
     */
    protected function setFlash(string $type, string $message): void {
        $this->startSession();
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }

    /**
     * Récupérer et supprimer le message flash
     * @return array|null
     */
    protected function getFlash(): ?array {
        $this->startSession();
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return $flash;
    }

    /**
     * Vérifier si l'utilisateur est connecté (client)
     * @return bool
     */
    protected function isLoggedIn(): bool {
        $this->startSession();
        return isset($_SESSION['user_id']);
    }

    /**
     * Vérifier si l'admin est connecté
     * @return bool
     */
    protected function isAdminLoggedIn(): bool {
        $this->startSession();
        return isset($_SESSION['admin_id']);
    }

    /**
     * Requérir une authentification utilisateur
     */
    protected function requireAuth(): void {
        if (!$this->isLoggedIn()) {
            $this->setFlash('error', 'Vous devez être connecté pour accéder à cette page.');
            $this->redirect('/login');
        }
    }

    /**
     * Requérir une authentification admin
     */
    protected function requireAdminAuth(): void {
        if (!$this->isAdminLoggedIn()) {
            $this->setFlash('error', 'Accès réservé aux administrateurs.');
            $this->redirect('/admin/login');
        }
    }

    /**
     * Récupérer l'ID de l'utilisateur connecté
     * @return int|null
     */
    protected function getUserId(): ?int {
        $this->startSession();
        return $_SESSION['user_id'] ?? null;
    }

    /**
     * Récupérer l'ID de l'admin connecté
     * @return int|null
     */
    protected function getAdminId(): ?int {
        $this->startSession();
        return $_SESSION['admin_id'] ?? null;
    }

    /**
     * Valider un token CSRF
     * @return bool
     */
    protected function validateCsrf(): bool {
        $this->startSession();
        $token = $this->post('csrf_token');
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    /**
     * Générer un token CSRF
     * @return string
     */
    protected function generateCsrf(): string {
        $this->startSession();
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}
