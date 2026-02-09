<?php
/**
 * Point d'entrée principal de l'application Takalo-Takalo
 * Framework: FlightMVC (Pattern MVC orienté objet)
 */

// Configuration et autoload
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/Database.php';

// Chargement des contrôleurs
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/AdminController.php';
require_once __DIR__ . '/../controllers/ObjetController.php';
require_once __DIR__ . '/../controllers/ExchangeController.php';

// Démarrer la session
session_start();

// Récupérer l'URI de la requête
$requestUri = $_SERVER['REQUEST_URI'];
$basePath = BASE_URL;

// Retirer le base path de l'URI
$uri = str_replace($basePath, '', $requestUri);
$uri = strtok($uri, '?'); // Retirer les query strings
$uri = rtrim($uri, '/');

if (empty($uri)) {
    $uri = '/';
}

// Méthode HTTP
$method = $_SERVER['REQUEST_METHOD'];

// Système de routage simple
$routes = [
    // Routes publiques
    'GET' => [
        '/' => function() {
            header('Location: ' . BASE_URL . '/login');
            exit;
        },
        '/login' => function() {
            $controller = new AuthController();
            $controller->showLogin();
        },
        '/register' => function() {
            $controller = new AuthController();
            $controller->showRegister();
        },
        '/logout' => function() {
            $controller = new AuthController();
            $controller->logoutUser();
        },
        
        // Routes Admin
        '/admin/login' => function() {
            $controller = new AuthController();
            $controller->showAdminLogin();
        },
        '/admin/logout' => function() {
            $controller = new AuthController();
            $controller->logoutAdmin();
        },
        '/admin/dashboard' => function() {
            $controller = new AdminController();
            $controller->dashboard();
        },
        '/admin/categories' => function() {
            $controller = new AdminController();
            $controller->categories();
        },
        '/admin/users' => function() {
            $controller = new AdminController();
            $controller->users();
        },
        '/admin/objects' => function() {
            $controller = new AdminController();
            $controller->objects();
        },
        
        // Routes Utilisateur
        '/dashboard' => function() {
            require_once __DIR__ . '/../controllers/BaseController.php';
            $controller = new class extends BaseController {
                public function index() {
                    $this->requireAuth();
                    require_once __DIR__ . '/../models/Objet.php';
                    require_once __DIR__ . '/../models/Exchange.php';
                    $objetModel = new Objet();
                    $exchangeModel = new Exchange();
                    $userId = $this->getUserId();
                    
                    $this->render('user/dashboard', [
                        'title' => 'Tableau de bord',
                        'myObjectsCount' => count($objetModel->getByUser($userId)),
                        'pendingExchanges' => $exchangeModel->countPendingForUser($userId),
                        'flash' => $this->getFlash()
                    ], 'user');
                }
            };
            $controller->index();
        },
        '/mes-objets' => function() {
            $controller = new ObjetController();
            $controller->myObjects();
        },
        '/explorer' => function() {
            $controller = new ObjetController();
            $controller->browse();
        },
        '/mes-echanges' => function() {
            $controller = new ExchangeController();
            $controller->index();
        },
    ],
    
    'POST' => [
        '/login' => function() {
            $controller = new AuthController();
            $controller->loginUser();
        },
        '/register' => function() {
            $controller = new AuthController();
            $controller->register();
        },
        '/admin/login' => function() {
            $controller = new AuthController();
            $controller->loginAdmin();
        },
        
        // Admin CRUD Catégories
        '/admin/categories/create' => function() {
            $controller = new AdminController();
            $controller->createCategory();
        },
        '/admin/categories/update' => function() {
            $controller = new AdminController();
            $controller->updateCategory();
        },
        '/admin/categories/delete' => function() {
            $controller = new AdminController();
            $controller->deleteCategory();
        },
        
        // User CRUD Objets
        '/objets/create' => function() {
            $controller = new ObjetController();
            $controller->create();
        },
        '/objets/update' => function() {
            $controller = new ObjetController();
            $controller->update();
        },
        '/objets/delete' => function() {
            $controller = new ObjetController();
            $controller->delete();
        },
        
        // Échanges
        '/echanges/propose' => function() {
            $controller = new ExchangeController();
            $controller->propose();
        },
        '/echanges/accept' => function() {
            $controller = new ExchangeController();
            $controller->accept();
        },
        '/echanges/refuse' => function() {
            $controller = new ExchangeController();
            $controller->refuse();
        },
    ]
];

// Exécuter la route correspondante
if (isset($routes[$method][$uri])) {
    $routes[$method][$uri]();
} else {
    // Page 404
    http_response_code(404);
    echo '<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>404 - Page non trouvée</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body { 
                background: linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%);
                min-height: 100vh; 
                display: flex; 
                align-items: center; 
                justify-content: center; 
            }
            .error-box {
                background: white;
                padding: 3rem;
                border-radius: 20px;
                text-align: center;
                box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            }
        </style>
    </head>
    <body>
        <div class="error-box">
            <h1 class="display-1 fw-bold text-primary">404</h1>
            <p class="lead">Page non trouvée</p>
            <a href="' . BASE_URL . '/login" class="btn btn-primary mt-3">Retour à l\'accueil</a>
        </div>
    </body>
    </html>';
}
