<?php
    require_once 'includes/HttpRequest.php';
    require_once 'includes/HttpResponse.php';
    require_once 'src/services/PdoService.php';

    class ReservationController {
        private $pdo;

        public function __construct()
        {
            $pdoService = new PdoService();
            $this->pdo = $pdoService->getPdo();
        }
        
        public function newAction(HttpRequest $request, HttpResponse $response) {
            $reservation = null;
            $response->setData('pageTitle', 'Réservation')
                     ->setData('reservation', $reservation)
                     ->render('templates/reservation/new.html.php');
        }
        
        public function createAction(HttpRequest $request, HttpResponse $response) {
            if ($request->isMethod('POST')) {
                $name = $request->getPost('name','');
                $contact = $request->getPost('contact','');
                $date_start = $request->getPost('date_start','');
                $date_end = $request->getPost('date_end','');
                $type_car = $request->getPost('type_car','');

                // var_dump($name, $contact, $date_start, $date_end, $type_car);die;

                $req = $this->pdo->prepare("INSERT INTO reservations (name, contact, date_start, date_end, type_car, status) VALUES (:name, :contact, :date_start, :date_end, :type_car, :status)");
                $req->execute([
                    ':name' => $name,
                    ':contact' => $contact,
                    ':date_start' => $date_start,
                    ':date_end' => $date_end,
                    ':type_car' => $type_car,
                    ':status' => 1,
                ]);
                
                $response->redirect('/');
                
            } else{
                $response->setData('pageTitle', 'Erreur')
                         ->setData('errorMessage', 'Methode non autorisée')
                         ->render('templates/error.html.php');
            }
        }

        public function editAction(HttpRequest $request, HttpResponse $response) {          
                if (!isset($_GET['id'])) {
                    die("Aucun ID fourni !");
                }
            
                $id = (int) $_GET['id'];
            
                $req = $this->pdo->prepare("SELECT * FROM reservations WHERE id = ?");
                $req->execute([$id]);
                $reservation = $req->fetch(PDO::FETCH_ASSOC);
                $req->closeCursor();
            
                if (!$reservation) {
                    die("Réservation introuvable !");
                }
            
                // Action du formulaire → POST sur la même route
                $roote = "/reservation/update?id=" . $reservation['id'];
            
                $response->setData('pageTitle', 'Modifier Réservation')
                         ->setData('reservation', $reservation)
                         ->setData('roote', $roote)
                         ->render('templates/reservation/edit.html.php');
        }

        public function updateAction($request, $response) {
            if (!isset($_GET['id'])) {
                die("Aucun ID fourni !");
            }

            $id = (int) $_GET['id'];
        
            // Vérifier que le formulaire est soumis en POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name       = $_POST['name'] ?? null;
                $contact    = $_POST['contact'] ?? null;
                $date_start = $_POST['date_start'] ?? null;
                $date_end   = $_POST['date_end'] ?? null;
        
                if (!$name || !$contact || !$date_start || !$date_end) {
                    die("Tous les champs sont obligatoires !");
                }
        
                if (strtotime($date_end) <= strtotime($date_start)) {
                    die("La date de fin doit être supérieure à la date de début !");
                }
        
                // Vérifier que la réservation existe
                $req = $this->pdo->prepare("SELECT id FROM reservations WHERE id = ?");
                $req->execute([$id]);
                $reservation = $req->fetch(PDO::FETCH_ASSOC);
                $req->closeCursor();
        
                if (!$reservation) {
                    die("Réservation introuvable !");
                }
        
                // Mise à jour
                $requete = $this->pdo->prepare("
                    UPDATE reservations 
                    SET name = :name, contact = :contact, date_start = :date_start, date_end = :date_end 
                    WHERE id = :id
                ");

                $requete->execute([
                    "name"       => $name,
                    "contact"    => $contact,
                    "date_start" => $date_start,
                    "date_end"   => $date_end,
                    "id"         => $id
                ]);
        
                // Redirection vers la liste après update
                $response->redirect('/');

            }
        }

        public function deleteAction(HttpRequest $request, HttpResponse $response) {            
            if (isset($_GET['id'])) {
                $id = (int) $_GET['id'];
            
                // Vérifier que la réservation existe
                $req = $this->pdo->prepare("SELECT id FROM reservations WHERE id = ?");
                $req->execute([$id]);
                $reservation = $req->fetch(PDO::FETCH_ASSOC);
                $req->closeCursor();
            
                if (!$reservation) {
                    die("Réservation introuvable !");
                }
            
                // Suppression
                $requete = $this->pdo->prepare("DELETE FROM reservations WHERE id = :id");
                $requete->execute(["id" => $id]);
            
                // Redirection vers la liste
                $response->redirect('/');

            } else {
                echo "<h3>Serveur indisponible, quelqu'un a essayé depuis l'URL</h3>";
            }
        }   
        
         public function listAction(HttpRequest $request, HttpResponse $response) {
            // Récupérer toutes les réservations (juste les colonnes utiles)
            $req = $this->pdo->prepare("SELECT name, contact, date_start, date_end, id FROM reservations");
            $req->execute([]);
            $reservations = $req->fetchAll(PDO::FETCH_ASSOC);
            $req->closeCursor();
        
            // Récupérer une réservation spécifique si id est passé en GET
            $data = null;
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $req = $this->pdo->prepare("SELECT name, contact, date_start, date_end, id FROM reservations WHERE id = :id");
                $req->execute(['id' => $id]);
                $data = $req->fetch(PDO::FETCH_ASSOC);
                $req->closeCursor();    
            }
        
            // Passer les données à la vue
            $response->setData('pageTitle', 'Liste des Réservations')
                     ->setData('reservations', $reservations)
                     ->setData('reservation', $data) // si une seule réservation est demandée
                     ->render('templates/reservation/list.html.php');
        }

        public function showAction(HttpRequest $request, HttpResponse $response) {
            $response->setData('pageTitle', 'Détails de la réservation')
                    ->render('templates/reservation/show.html.php');
        }
    }
    
?>
