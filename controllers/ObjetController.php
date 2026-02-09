<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Objet.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Exchange.php';
require_once __DIR__ . '/../models/ObjectImage.php';

/**
 * Contrôleur Objet
 * Gère les objets des utilisateurs
 */
class ObjetController extends BaseController {
    private Objet $objetModel;
    private Category $categoryModel;
    private Exchange $exchangeModel;
    private ObjectImage $imageModel;

    public function __construct() {
        $this->objetModel = new Objet();
        $this->categoryModel = new Category();
        $this->exchangeModel = new Exchange();
        $this->imageModel = new ObjectImage();
    }

    /**
     * Liste des objets de l'utilisateur connecté
     */
    public function myObjects(): void {
        $this->requireAuth();

        $userId = $this->getUserId();
        $objects = $this->objetModel->getByUser($userId);
        $categories = $this->categoryModel->getActiveCategories();

        $this->render('user/my_objects', [
            'title' => 'Mes Objets',
            'objects' => $objects,
            'categories' => $categories,
            'flash' => $this->getFlash(),
            'csrf_token' => $this->generateCsrf()
        ], 'user');
    }

    /**
     * Créer un objet
     */
    public function create(): void {
        $this->requireAuth();

        $data = [
            'user_id' => $this->getUserId(),
            'category_id' => (int) $this->post('category_id', 0),
            'title' => trim($this->post('title', '')),
            'description' => trim($this->post('description', '')),
            'estimated_price' => (float) $this->post('estimated_price', 0)
        ];

        // Validations
        if (empty($data['title']) || $data['category_id'] <= 0) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Titre et catégorie requis.'], 400);
            }
            $this->setFlash('error', 'Titre et catégorie sont requis.');
            $this->redirect('/mes-objets');
            return;
        }

        try {
            $objectId = $this->objetModel->createObject($data);

            // Gestion des images
            if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
                $this->handleImageUpload($objectId, $_FILES['images']);
            }

            if ($this->isAjax()) {
                $this->json(['success' => true, 'message' => 'Objet ajouté avec succès!', 'id' => $objectId]);
            }
            $this->setFlash('success', 'Objet ajouté avec succès!');
            $this->redirect('/mes-objets');
        } catch (Exception $e) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()], 500);
            }
            $this->setFlash('error', 'Erreur lors de l\'ajout.');
            $this->redirect('/mes-objets');
        }
    }

    /**
     * Mettre à jour un objet
     */
    public function update(): void {
        $this->requireAuth();

        $id = (int) $this->post('id', 0);
        $object = $this->objetModel->findById($id);

        // Vérifier que l'objet appartient à l'utilisateur
        if (!$object || $object['user_id'] != $this->getUserId()) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Accès non autorisé.'], 403);
            }
            $this->setFlash('error', 'Accès non autorisé.');
            $this->redirect('/mes-objets');
            return;
        }

        $data = [
            'category_id' => (int) $this->post('category_id', $object['category_id']),
            'title' => trim($this->post('title', '')),
            'description' => trim($this->post('description', '')),
            'estimated_price' => (float) $this->post('estimated_price', 0),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            $this->objetModel->update($id, $data);

            if ($this->isAjax()) {
                $this->json(['success' => true, 'message' => 'Objet modifié avec succès!']);
            }
            $this->setFlash('success', 'Objet modifié avec succès!');
            $this->redirect('/mes-objets');
        } catch (Exception $e) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Erreur lors de la modification.'], 500);
            }
            $this->setFlash('error', 'Erreur lors de la modification.');
            $this->redirect('/mes-objets');
        }
    }

    /**
     * Supprimer un objet
     */
    public function delete(): void {
        $this->requireAuth();

        $id = (int) $this->post('id', 0);
        $object = $this->objetModel->findById($id);

        if (!$object || $object['user_id'] != $this->getUserId()) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Accès non autorisé.'], 403);
            }
            $this->setFlash('error', 'Accès non autorisé.');
            $this->redirect('/mes-objets');
            return;
        }

        try {
            // Supprimer les images associées
            $this->imageModel->deleteByObject($id);
            $this->objetModel->delete($id);

            if ($this->isAjax()) {
                $this->json(['success' => true, 'message' => 'Objet supprimé!']);
            }
            $this->setFlash('success', 'Objet supprimé avec succès!');
            $this->redirect('/mes-objets');
        } catch (Exception $e) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Erreur lors de la suppression.'], 500);
            }
            $this->setFlash('error', 'Erreur lors de la suppression.');
            $this->redirect('/mes-objets');
        }
    }

    /**
     * Voir les objets des autres utilisateurs
     */
    public function browse(): void {
        $this->requireAuth();

        $userId = $this->getUserId();
        $categoryId = (int) $this->get('category', 0);
        
        if ($categoryId > 0) {
            $objects = $this->objetModel->getByCategory($categoryId);
            // Filtrer les objets de l'utilisateur connecté
            $objects = array_filter($objects, fn($o) => $o['user_id'] != $userId);
        } else {
            $objects = $this->objetModel->getOthersObjects($userId);
        }

        $categories = $this->categoryModel->getActiveCategories();
        $myObjects = $this->objetModel->getByUser($userId);

        $this->render('user/browse_objects', [
            'title' => 'Explorer les objets',
            'objects' => $objects,
            'categories' => $categories,
            'myObjects' => $myObjects,
            'selectedCategory' => $categoryId,
            'flash' => $this->getFlash(),
            'csrf_token' => $this->generateCsrf()
        ], 'user');
    }

    /**
     * Voir le détail d'un objet
     */
    public function show(int $id): void {
        $this->requireAuth();

        $object = $this->objetModel->findById($id);
        if (!$object) {
            $this->setFlash('error', 'Objet non trouvé.');
            $this->redirect('/explorer');
            return;
        }

        $images = $this->imageModel->getByObject($id);
        $myObjects = $this->objetModel->getByUser($this->getUserId());

        $this->render('user/object_detail', [
            'title' => $object['title'],
            'object' => $object,
            'images' => $images,
            'myObjects' => $myObjects,
            'flash' => $this->getFlash(),
            'csrf_token' => $this->generateCsrf()
        ], 'user');
    }

    /**
     * Gérer l'upload d'images
     */
    private function handleImageUpload(int $objectId, array $files): void {
        $uploadDir = UPLOAD_DIR . 'objects/';
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $isFirst = true;
        foreach ($files['tmp_name'] as $index => $tmpName) {
            if (empty($tmpName)) continue;

            $ext = strtolower(pathinfo($files['name'][$index], PATHINFO_EXTENSION));
            
            if (!in_array($ext, ALLOWED_EXTENSIONS)) continue;
            if ($files['size'][$index] > MAX_FILE_SIZE) continue;

            $filename = uniqid('obj_') . '.' . $ext;
            $destination = $uploadDir . $filename;

            if (move_uploaded_file($tmpName, $destination)) {
                $this->imageModel->addImage($objectId, $filename, $isFirst);
                $isFirst = false;
            }
        }
    }
}
