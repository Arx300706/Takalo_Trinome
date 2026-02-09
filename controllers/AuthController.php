<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Admin.php';

/**
 * Contrôleur d'authentification
 * Gère la connexion/déconnexion des utilisateurs et admins
 */
class AuthController extends BaseController {
    private User $userModel;
    private Admin $adminModel;

    public function __construct() {
        $this->userModel = new User();
        $this->adminModel = new Admin();
    }

    /**
     * Afficher la page de connexion unifiée
     */
    public function showLogin(): void {
        $this->startSession();
        
        // Si déjà connecté, rediriger
        if ($this->isLoggedIn()) {
            $this->redirect('/dashboard');
            return;
        }

        $this->render('auth/login', [
            'title' => 'Connexion',
            'csrf_token' => $this->generateCsrf(),
            'flash' => $this->getFlash()
        ], null); // Pas de layout pour la page de login
    }

    /**
     * Traiter la connexion utilisateur
     */
    public function loginUser(): void {
        $this->startSession();

        $email = trim($this->post('email', ''));
        $password = $this->post('password', '');

        // Validation
        if (empty($email) || empty($password)) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Tous les champs sont requis.'], 400);
            }
            $this->setFlash('error', 'Tous les champs sont requis.');
            $this->redirect('/login');
            return;
        }

        // Authentification
        $user = $this->userModel->authenticate($email, $password);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['prenom'] . ' ' . $user['nom'];
            $_SESSION['user_email'] = $user['email'];

            if ($this->isAjax()) {
                $this->json(['success' => true, 'message' => 'Connexion réussie!', 'redirect' => BASE_URL . '/dashboard']);
            }
            $this->redirect('/dashboard');
        } else {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Email ou mot de passe incorrect.'], 401);
            }
            $this->setFlash('error', 'Email ou mot de passe incorrect.');
            $this->redirect('/login');
        }
    }

    /**
     * Afficher la page de connexion admin
     */
    public function showAdminLogin(): void {
        $this->startSession();

        if ($this->isAdminLoggedIn()) {
            $this->redirect('/admin/dashboard');
            return;
        }

        $this->render('auth/login_admin', [
            'title' => 'Connexion Admin',
            'csrf_token' => $this->generateCsrf(),
            'flash' => $this->getFlash(),
            'default_login' => DEFAULT_ADMIN_LOGIN
        ], null);
    }

    /**
     * Traiter la connexion admin
     */
    public function loginAdmin(): void {
        $this->startSession();

        $login = trim($this->post('login', ''));
        $password = $this->post('password', '');

        if (empty($login) || empty($password)) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Tous les champs sont requis.'], 400);
            }
            $this->setFlash('error', 'Tous les champs sont requis.');
            $this->redirect('/admin/login');
            return;
        }

        $admin = $this->adminModel->authenticate($login, $password);

        if ($admin) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_login'] = $admin['login'];

            if ($this->isAjax()) {
                $this->json(['success' => true, 'message' => 'Bienvenue Admin!', 'redirect' => BASE_URL . '/admin/dashboard']);
            }
            $this->redirect('/admin/dashboard');
        } else {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Identifiants incorrects.'], 401);
            }
            $this->setFlash('error', 'Identifiants incorrects.');
            $this->redirect('/admin/login');
        }
    }

    /**
     * Afficher le formulaire d'inscription
     */
    public function showRegister(): void {
        $this->startSession();

        if ($this->isLoggedIn()) {
            $this->redirect('/dashboard');
            return;
        }

        $this->render('auth/register', [
            'title' => 'Inscription',
            'csrf_token' => $this->generateCsrf(),
            'flash' => $this->getFlash()
        ], null);
    }

    /**
     * Traiter l'inscription
     */
    public function register(): void {
        $this->startSession();

        $data = [
            'nom' => trim($this->post('nom', '')),
            'prenom' => trim($this->post('prenom', '')),
            'email' => trim($this->post('email', '')),
            'password' => $this->post('password', ''),
            'password_confirm' => $this->post('password_confirm', ''),
            'telephone' => trim($this->post('telephone', '')),
            'adresse' => trim($this->post('adresse', ''))
        ];

        // Validations
        $errors = [];

        if (empty($data['nom'])) $errors[] = 'Le nom est requis.';
        if (empty($data['prenom'])) $errors[] = 'Le prénom est requis.';
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email invalide.';
        }
        if (strlen($data['password']) < 6) {
            $errors[] = 'Le mot de passe doit contenir au moins 6 caractères.';
        }
        if ($data['password'] !== $data['password_confirm']) {
            $errors[] = 'Les mots de passe ne correspondent pas.';
        }
        if ($this->userModel->emailExists($data['email'])) {
            $errors[] = 'Cet email est déjà utilisé.';
        }

        if (!empty($errors)) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => implode(' ', $errors)], 400);
            }
            $this->setFlash('error', implode('<br>', $errors));
            $this->redirect('/register');
            return;
        }

        // Inscription
        try {
            $userId = $this->userModel->register($data);
            
            // Connecter automatiquement
            $_SESSION['user_id'] = $userId;
            $_SESSION['user_name'] = $data['prenom'] . ' ' . $data['nom'];
            $_SESSION['user_email'] = $data['email'];

            if ($this->isAjax()) {
                $this->json(['success' => true, 'message' => 'Inscription réussie!', 'redirect' => BASE_URL . '/dashboard']);
            }
            $this->setFlash('success', 'Bienvenue sur Takalo-Takalo!');
            $this->redirect('/dashboard');
        } catch (Exception $e) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Erreur lors de l\'inscription.'], 500);
            }
            $this->setFlash('error', 'Erreur lors de l\'inscription.');
            $this->redirect('/register');
        }
    }

    /**
     * Déconnexion utilisateur
     */
    public function logoutUser(): void {
        $this->startSession();
        unset($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['user_email']);
        session_destroy();
        $this->redirect('/login');
    }

    /**
     * Déconnexion admin
     */
    public function logoutAdmin(): void {
        $this->startSession();
        unset($_SESSION['admin_id'], $_SESSION['admin_login']);
        session_destroy();
        $this->redirect('/admin/login');
    }
}
