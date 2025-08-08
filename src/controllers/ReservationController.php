<?php
require_once 'includes/HttpRequest.php';
require_once 'includes/HttpResponse.php';
require_once 'services/PdoService.php';

class ReservationController {
    /**
     * @var PdoService The database service
     */
    private $pdoService;

    public function __construct() {
        $this->pdoService = new PdoService();
    }

    public function listReservations(HttpRequest $request, HttpResponse $response) {
        try {
            $pdo = $this->pdoService->getPdo();
            $stmt = $pdo->query("SELECT id, nom, contact, type_voiture, date_debut, date_fin FROM reservations");
            $reservations = $stmt->fetchAll();

            $response->setData('pageTitle', 'Liste des Réservations')
                     ->setData('reservations', $reservations)
                     ->render('templates/reservations-list.html.php');
        } catch (Exception $e) {
            $response->setStatusCode(500)
                     ->setData('pageTitle', 'Erreur')
                     ->setData('errorMessage', 'Erreur lors de la récupération des réservations : ' . $e->getMessage())
                     ->render('templates/error.html.php');
        }
    }

    public function showReservationForm(HttpRequest $request, HttpResponse $response) {
        $response->setData('pageTitle', 'Formulaire de Réservation')
                 ->setData('errorMessage', '')
                 ->render('templates/reservation.html.php');
    }

    public function createReservation(HttpRequest $request, HttpResponse $response) {
        if ($request->isMethod('POST')) {
            $nom = $request->getPost('nom', '');
            $contact = $request->getPost('contact', '');
            $typeVoiture = $request->getPost('typeVoiture', '');
            $dateDebut = $request->getPost('dateDebut', '');
            $dateFin = $request->getPost('dateFin', '');

            // Validation simple
            if (empty($nom) || empty($contact) || empty($typeVoiture) || empty($dateDebut) || empty($dateFin)) {
                $response->setStatusCode(400)
                         ->setData('pageTitle', 'Formulaire de Réservation')
                         ->setData('errorMessage', 'Tous les champs sont requis.')
                         ->render('templates/reservation.html.php');
                return;
            }

            // Validation de la date
            if (strtotime($dateFin) <= strtotime($dateDebut)) {
                $response->setStatusCode(400)
                         ->setData('pageTitle', 'Formulaire de Réservation')
                         ->setData('errorMessage', 'La date de fin doit être postérieure à la date de début.')
                         ->render('templates/reservation.html.php');
                return;
            }

            try {
                $pdo = $this->pdoService->getPdo();
                $stmt = $pdo->prepare("INSERT INTO reservations (nom, contact, type_voiture, date_debut, date_fin) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$nom, $contact, $typeVoiture, $dateDebut, $dateFin]);

                $response->redirect('/reservations');
            } catch (Exception $e) {
                $response->setStatusCode(500)
                         ->setData('pageTitle', 'Erreur')
                         ->setData('errorMessage', 'Erreur lors de la création de la réservation : ' . $e->getMessage())
                         ->render('templates/error.html.php');
            }
        } else {
            $response->setStatusCode(405)
                     ->setData('pageTitle', 'Erreur')
                     ->setData('errorMessage', 'Méthode non autorisée.')
                     ->render('templates/error.html.php');
        }
    }

    public function editReservation(HttpRequest $request, HttpResponse $response) {
        $id = $request->getParam('id');
        if (!$id) {
            $response->setStatusCode(400)
                     ->setData('pageTitle', 'Erreur')
                     ->setData('errorMessage', 'ID de réservation manquant.')
                     ->render('templates/error.html.php');
            return;
        }

        try {
            $pdo = $this->pdoService->getPdo();
            $stmt = $pdo->prepare("SELECT id, nom, contact, type_voiture, date_debut, date_fin FROM reservations WHERE id = ?");
            $stmt->execute([$id]);
            $reservation = $stmt->fetch();

            if (!$reservation) {
                $response->setStatusCode(404)
                         ->setData('pageTitle', 'Erreur')
                         ->setData('errorMessage', 'Réservation non trouvée.')
                         ->render('templates/error.html.php');
                return;
            }

            $response->setData('pageTitle', 'Modifier la Réservation')
                     ->setData('reservation', $reservation)
                     ->setData('errorMessage', '')
                     ->render('templates/edit-reservation.html.php');
        } catch (Exception $e) {
            $response->setStatusCode(500)
                     ->setData('pageTitle', 'Erreur')
                     ->setData('errorMessage', 'Erreur lors de la récupération de la réservation : ' . $e->getMessage())
                     ->render('templates/error.html.php');
        }
    }

    public function updateReservation(HttpRequest $request, HttpResponse $response) {
        if ($request->isMethod('POST')) {
            $id = $request->getParam('id');
            $nom = $request->getPost('nom', '');
            $contact = $request->getPost('contact', '');
            $typeVoiture = $request->getPost('typeVoiture', '');
            $dateDebut = $request->getPost('dateDebut', '');
            $dateFin = $request->getPost('dateFin', '');

            // Validation simple
            if (empty($id) || empty($nom) || empty($contact) || empty($typeVoiture) || empty($dateDebut) || empty($dateFin)) {
                $response->setStatusCode(400)
                         ->setData('pageTitle', 'Modifier la Réservation')
                         ->setData('errorMessage', 'Tous les champs sont requis.')
                         ->render('templates/edit-reservation.html.php');
                return;
            }

            // Validation de la date
            if (strtotime($dateFin) <= strtotime($dateDebut)) {
                $response->setStatusCode(400)
                         ->setData('pageTitle', 'Modifier la Réservation')
                         ->setData('errorMessage', 'La date de fin doit être postérieure à la date de début.')
                         ->render('templates/edit-reservation.html.php');
                return;
            }

            try {
                $pdo = $this->pdoService->getPdo();
                $stmt = $pdo->prepare("UPDATE reservations SET nom = ?, contact = ?, type_voiture = ?, date_debut = ?, date_fin = ? WHERE id = ?");
                $stmt->execute([$nom, $contact, $typeVoiture, $dateDebut, $dateFin, $id]);

                $response->redirect('/reservations');
            } catch (Exception $e) {
                $response->setStatusCode(500)
                         ->setData('pageTitle', 'Erreur')
                         ->setData('errorMessage', 'Erreur lors de la mise à jour de la réservation : ' . $e->getMessage())
                         ->render('templates/error.html.php');
            }
        } else {
            $response->setStatusCode(405)
                     ->setData('pageTitle', 'Erreur')
                     ->setData('errorMessage', 'Méthode non autorisée.')
                     ->render('templates/error.html.php');
        }
    }

    public function viewReservation(HttpRequest $request, HttpResponse $response) {
        $id = $request->getParam('id');
        if (!$id) {
            $response->setStatusCode(400)
                     ->setData('pageTitle', 'Erreur')
                     ->setData('errorMessage', 'ID de réservation manquant.')
                     ->render('templates/error.html.php');
            return;
        }

        try {
            $pdo = $this->pdoService->getPdo();
            $stmt = $pdo->prepare("SELECT id, nom, contact, type_voiture, date_debut, date_fin FROM reservations WHERE id = ?");
            $stmt->execute([$id]);
            $reservation = $stmt->fetch();

            if (!$reservation) {
                $response->setStatusCode(404)
                         ->setData('pageTitle', 'Erreur')
                         ->setData('errorMessage', 'Réservation non trouvée.')
                         ->render('templates/error.html.php');
                return;
            }

            $response->setData('pageTitle', 'Détails de la Réservation')
                     ->setData('reservation', $reservation)
                     ->render('templates/view-reservation.html.php');
        } catch (Exception $e) {
            $response->setStatusCode(500)
                     ->setData('pageTitle', 'Erreur')
                     ->setData('errorMessage', 'Erreur lors de la récupération de la réservation : ' . $e->getMessage())
                     ->render('templates/error.html.php');
        }
    }

    public function deleteReservation(HttpRequest $request, HttpResponse $response) {
        $id = $request->getParam('id');
        if (!$id) {
            $response->setStatusCode(400)
                     ->setData('pageTitle', 'Erreur')
                     ->setData('errorMessage', 'ID de réservation manquant.')
                     ->render('templates/error.html.php');
            return;
        }

        try {
            $pdo = $this->pdoService->getPdo();
            $stmt = $pdo->prepare("DELETE FROM reservations WHERE id = ?");
            $stmt->execute([$id]);

            $response->redirect('/reservations');
        } catch (Exception $e) {
            $response->setStatusCode(500)
                     ->setData('pageTitle', 'Erreur')
                     ->setData('errorMessage', 'Erreur lors de la suppression de la réservation : ' . $e->getMessage())
                     ->render('templates/error.html.php');
        }
    }
}
?>