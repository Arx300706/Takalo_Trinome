<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Objet.php';
require_once __DIR__ . '/../models/Exchange.php';

/**
 * Contrôleur Admin
 * Gère le backoffice administrateur
 */
class AdminController extends BaseController {
    private Category $categoryModel;
    private User $userModel;
    private Objet $objetModel;
    private Exchange $exchangeModel;

    public function __construct() {
        $this->categoryModel = new Category();
        $this->userModel = new User();
        $this->objetModel = new Objet();
        $this->exchangeModel = new Exchange();
    }

    /**
     * Tableau de bord admin
     */
    public function dashboard(): void {
        $this->requireAdminAuth();

        $stats = [
            'categories' => $this->categoryModel->count(),
            'users' => $this->userModel->count(),
            'objects' => $this->objetModel->count(),
            'exchanges' => $this->exchangeModel->count()
        ];

        $this->render('admin/dashboard', [
            'title' => 'Tableau de bord',
            'stats' => $stats,
            'flash' => $this->getFlash()
        ], 'admin');
    }

    /**
     * Liste des catégories
     */
    public function categories(): void {
        $this->requireAdminAuth();

        $categories = $this->categoryModel->getAllWithObjectCount();

        $this->render('admin/categories', [
            'title' => 'Gestion des Catégories',
            'categories' => $categories,
            'flash' => $this->getFlash(),
            'csrf_token' => $this->generateCsrf()
        ], 'admin');
    }

    /**
     * Créer une catégorie
     */
    public function createCategory(): void {
        $this->requireAdminAuth();

        $name = trim($this->post('name', ''));
        $description = trim($this->post('description', ''));

        if (empty($name)) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Le nom est requis.'], 400);
            }
            $this->setFlash('error', 'Le nom de la catégorie est requis.');
            $this->redirect('/admin/categories');
            return;
        }

        if ($this->categoryModel->nameExists($name)) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Cette catégorie existe déjà.'], 400);
            }
            $this->setFlash('error', 'Cette catégorie existe déjà.');
            $this->redirect('/admin/categories');
            return;
        }

        try {
            $id = $this->categoryModel->createCategory($name, $description);
            
            if ($this->isAjax()) {
                $this->json([
                    'success' => true, 
                    'message' => 'Catégorie créée avec succès!',
                    'category' => [
                        'id' => $id,
                        'name' => $name,
                        'description' => $description,
                        'created_at' => date('Y-m-d')
                    ]
                ]);
            }
            $this->setFlash('success', 'Catégorie créée avec succès!');
            $this->redirect('/admin/categories');
        } catch (Exception $e) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Erreur lors de la création.'], 500);
            }
            $this->setFlash('error', 'Erreur lors de la création.');
            $this->redirect('/admin/categories');
        }
    }

    /**
     * Mettre à jour une catégorie
     */
    public function updateCategory(): void {
        $this->requireAdminAuth();

        $id = (int) $this->post('id', 0);
        $name = trim($this->post('name', ''));
        $description = trim($this->post('description', ''));

        if ($id <= 0 || empty($name)) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Données invalides.'], 400);
            }
            $this->setFlash('error', 'Données invalides.');
            $this->redirect('/admin/categories');
            return;
        }

        try {
            $this->categoryModel->update($id, [
                'name' => $name,
                'description' => $description,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            if ($this->isAjax()) {
                $this->json(['success' => true, 'message' => 'Catégorie modifiée avec succès!']);
            }
            $this->setFlash('success', 'Catégorie modifiée avec succès!');
            $this->redirect('/admin/categories');
        } catch (Exception $e) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Erreur lors de la modification.'], 500);
            }
            $this->setFlash('error', 'Erreur lors de la modification.');
            $this->redirect('/admin/categories');
        }
    }

    /**
     * Supprimer une catégorie
     */
    public function deleteCategory(): void {
        $this->requireAdminAuth();

        $id = (int) $this->post('id', 0);

        if ($id <= 0) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'ID invalide.'], 400);
            }
            $this->setFlash('error', 'ID invalide.');
            $this->redirect('/admin/categories');
            return;
        }

        try {
            $this->categoryModel->delete($id);

            if ($this->isAjax()) {
                $this->json(['success' => true, 'message' => 'Catégorie supprimée!']);
            }
            $this->setFlash('success', 'Catégorie supprimée avec succès!');
            $this->redirect('/admin/categories');
        } catch (Exception $e) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Erreur lors de la suppression.'], 500);
            }
            $this->setFlash('error', 'Erreur lors de la suppression.');
            $this->redirect('/admin/categories');
        }
    }

    /**
     * Liste des utilisateurs
     */
    public function users(): void {
        $this->requireAdminAuth();

        $users = $this->userModel->findAll();

        $this->render('admin/users', [
            'title' => 'Gestion des Utilisateurs',
            'users' => $users,
            'flash' => $this->getFlash()
        ], 'admin');
    }

    /**
     * Liste des objets
     */
    public function objects(): void {
        $this->requireAdminAuth();

        $objects = $this->objetModel->getAllWithDetails();

        $this->render('admin/objects', [
            'title' => 'Gestion des Objets',
            'objects' => $objects,
            'flash' => $this->getFlash()
        ], 'admin');
    }
}
