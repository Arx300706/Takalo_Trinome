<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Exchange.php';
require_once __DIR__ . '/../models/Objet.php';

/**
 * Contrôleur Exchange
 * Gère les propositions d'échange entre utilisateurs
 */
class ExchangeController extends BaseController {
    private Exchange $exchangeModel;
    private Objet $objetModel;

    public function __construct() {
        $this->exchangeModel = new Exchange();
        $this->objetModel = new Objet();
    }

    /**
     * Liste des échanges de l'utilisateur
     */
    public function index(): void {
        $this->requireAuth();

        $userId = $this->getUserId();
        
        $receivedProposals = $this->exchangeModel->getReceivedProposals($userId);
        $sentProposals = $this->exchangeModel->getSentProposals($userId);

        $this->render('user/exchanges', [
            'title' => 'Mes Échanges',
            'receivedProposals' => $receivedProposals,
            'sentProposals' => $sentProposals,
            'flash' => $this->getFlash()
        ], 'user');
    }

    /**
     * Proposer un échange
     */
    public function propose(): void {
        $this->requireAuth();

        $myObjectId = (int) $this->post('my_object_id', 0);
        $requestedObjectId = (int) $this->post('requested_object_id', 0);
        $userId = $this->getUserId();

        // Validations
        if ($myObjectId <= 0 || $requestedObjectId <= 0) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Sélectionnez les deux objets.'], 400);
            }
            $this->setFlash('error', 'Sélectionnez les deux objets pour l\'échange.');
            $this->redirect('/explorer');
            return;
        }

        // Vérifier que l'objet proposé appartient à l'utilisateur
        $myObject = $this->objetModel->findById($myObjectId);
        if (!$myObject || $myObject['user_id'] != $userId) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Objet invalide.'], 400);
            }
            $this->setFlash('error', 'Vous ne pouvez proposer que vos propres objets.');
            $this->redirect('/explorer');
            return;
        }

        // Vérifier que l'objet demandé n'appartient pas à l'utilisateur
        $requestedObject = $this->objetModel->findById($requestedObjectId);
        if (!$requestedObject || $requestedObject['user_id'] == $userId) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Objet invalide.'], 400);
            }
            $this->setFlash('error', 'Objet demandé invalide.');
            $this->redirect('/explorer');
            return;
        }

        // Vérifier si l'échange n'existe pas déjà
        if ($this->exchangeModel->exchangeExists($myObjectId, $requestedObjectId)) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Proposition déjà envoyée.'], 400);
            }
            $this->setFlash('warning', 'Vous avez déjà proposé cet échange.');
            $this->redirect('/explorer');
            return;
        }

        try {
            $this->exchangeModel->createExchange($myObjectId, $requestedObjectId, $userId);

            if ($this->isAjax()) {
                $this->json(['success' => true, 'message' => 'Proposition envoyée!']);
            }
            $this->setFlash('success', 'Proposition d\'échange envoyée!');
            $this->redirect('/mes-echanges');
        } catch (Exception $e) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Erreur lors de la proposition.'], 500);
            }
            $this->setFlash('error', 'Erreur lors de l\'envoi de la proposition.');
            $this->redirect('/explorer');
        }
    }

    /**
     * Accepter un échange
     */
    public function accept(): void {
        $this->requireAuth();

        $exchangeId = (int) $this->post('exchange_id', 0);

        if ($exchangeId <= 0) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'ID invalide.'], 400);
            }
            $this->setFlash('error', 'Échange invalide.');
            $this->redirect('/mes-echanges');
            return;
        }

        try {
            $this->exchangeModel->acceptExchange($exchangeId);

            if ($this->isAjax()) {
                $this->json(['success' => true, 'message' => 'Échange accepté! Les objets ont changé de propriétaire.']);
            }
            $this->setFlash('success', 'Échange accepté! Les objets ont été échangés.');
            $this->redirect('/mes-echanges');
        } catch (Exception $e) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Erreur lors de l\'acceptation.'], 500);
            }
            $this->setFlash('error', 'Erreur lors de l\'acceptation.');
            $this->redirect('/mes-echanges');
        }
    }

    /**
     * Refuser un échange
     */
    public function refuse(): void {
        $this->requireAuth();

        $exchangeId = (int) $this->post('exchange_id', 0);

        if ($exchangeId <= 0) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'ID invalide.'], 400);
            }
            $this->setFlash('error', 'Échange invalide.');
            $this->redirect('/mes-echanges');
            return;
        }

        try {
            $this->exchangeModel->refuseExchange($exchangeId);

            if ($this->isAjax()) {
                $this->json(['success' => true, 'message' => 'Proposition refusée.']);
            }
            $this->setFlash('info', 'Proposition refusée.');
            $this->redirect('/mes-echanges');
        } catch (Exception $e) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Erreur lors du refus.'], 500);
            }
            $this->setFlash('error', 'Erreur lors du refus.');
            $this->redirect('/mes-echanges');
        }
    }
}
