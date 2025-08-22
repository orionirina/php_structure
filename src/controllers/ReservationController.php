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
            // Démarrer la session pour vérifier l'état de connexion
            session_start();
            if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
                $response->setData('pageTitle', 'Connexion requise')
                        ->setData('errorMessage', 'Veuillez vous connecter pour accéder à la liste des réservations.')
                        ->render('templates/login/form.html.php');
                return;
            }
            
            
            $reservation = null;
            $response->setData('pageTitle', 'Réservation')
                     ->setData('reservation', $reservation)
                     ->render('templates/reservation/new.html.php');
        }
        
        public function createAction(HttpRequest $request, HttpResponse $response) {
            // Démarrer la session pour vérifier l'état de connexion
            session_start();
            if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
                $response->setData('pageTitle', 'Connexion requise')
                        ->setData('errorMessage', 'Veuillez vous connecter pour accéder à la liste des réservations.')
                        ->render('templates/login/form.html.php');
                return;
            }

            if ($request->isMethod('POST')) {
                $name = $request->getPost('name','');
                $contact = $request->getPost('contact','');
                $date_start = $request->getPost('date_start','');
                $date_end = $request->getPost('date_end','');
                $id_car = $request->getPost('id_car','');

                // var_dump($name, $contact, $date_start, $date_end, $type_car);die;

                $req = $this->pdo->prepare("INSERT INTO reservations (name, contact, date_start, date_end, id_car, status) VALUES (:name, :contact, :date_start, :date_end, :id_car, :status)");
                $req->execute([
                    ':name' => $name,
                    ':contact' => $contact,
                    ':date_start' => $date_start,
                    ':date_end' => $date_end,
                    ':id_car' => $id_car,
                    ':status' => 1,
                ]);
                
                // $response->redirect('/');
                $response->setData('pageTitle', 'Accueil')
                    ->setData('message', "Ajout de reservation de $name")
                    ->render('templates/index.html.php');
                
            } else{
                $response->setData('pageTitle', 'Erreur')
                         ->setData('errorMessage', 'Methode non autorisée')
                         ->render('templates/error.html.php');
            }
        }

        public function editAction(HttpRequest $request, HttpResponse $response) {          
            // Démarrer la session pour vérifier l'état de connexion
            session_start();
            if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
                $response->setData('pageTitle', 'Connexion requise')
                        ->setData('errorMessage', 'Veuillez vous connecter pour accéder à la liste des réservations.')
                        ->render('templates/login/form.html.php');
                return;
            }

            if (!isset($_GET['id'])) {
                $response->setData('pageTitle', 'Accueil')
                    ->setData('message', "Aucun ID fourni")
                    ->render('templates/index.html.php');
            }
        
            $id = (int) $_GET['id'];
        
            $req = $this->pdo->prepare("SELECT * FROM reservations WHERE id = ?");
            $req->execute([$id]);
            $reservation = $req->fetch(PDO::FETCH_ASSOC);
            $req->closeCursor();
        
            if (!$reservation) {
                $response->setData('pageTitle', 'Accueil')
                    ->setData('message', "Réservation introuvable !")
                    ->render('templates/index.html.php');
            }
        
            // Action du formulaire → POST sur la même route
            $roote = "/reservation/update?id=" . $reservation['id'];
        
            $response->setData('pageTitle', 'Modifier Réservation')
                        ->setData('reservation', $reservation)
                        ->setData('roote', $roote)
                        ->render('templates/reservation/edit.html.php');
        }

        public function updateAction($request, $response) {
            // Démarrer la session pour vérifier l'état de connexion
            session_start();
            if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
                $response->setData('pageTitle', 'Connexion requise')
                        ->setData('errorMessage', 'Veuillez vous connecter pour accéder à la liste des réservations.')
                        ->render('templates/login/form.html.php');
                return;
            }

            if (!isset($_GET['id'])) {
                $response->setData('pageTitle', 'Accueil')
                        ->setData('message', "Aucun ID fourni !")
                        ->render('templates/index.html.php');
            }

            $id = (int) $_GET['id'];
        
            // Vérifier que le formulaire est soumis en POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name       = $_POST['name'] ?? null;
                $contact    = $_POST['contact'] ?? null;
                $date_start = $_POST['date_start'] ?? null;
                $date_end   = $_POST['date_end'] ?? null;
                $id_car   = $_POST['id_car'] ?? null;

        
                if (!$name || !$contact || !$date_start || !$date_end || !$id_car) {
                    $response->setData('pageTitle', 'Accueil')
                            ->setData('message', "Tous les champs sont obligatoires")
                            ->render('templates/index.html.php');
                }
        
                if (strtotime($date_end) <= strtotime($date_start)) {
                    $response->setData('pageTitle', 'Accueil')
                            ->setData('message', "La date de fin doit être supérieure à la date de début !")
                            ->render('templates/index.html.php');
                }
        
                // Vérifier que la réservation existe
                $req = $this->pdo->prepare("SELECT id FROM reservations WHERE id = ?");
                $req->execute([$id]);
                $reservation = $req->fetch(PDO::FETCH_ASSOC);
                $req->closeCursor();
        
                if (!$reservation) {
                    $response->setData('pageTitle', 'Accueil')
                            ->setData('message', "Réservation introuvable !")
                            ->render('templates/index.html.php');
                }
        
                // Mise à jour
                $requete = $this->pdo->prepare("UPDATE reservations 
                    SET name = :name, contact = :contact, date_start = :date_start, date_end = :date_end, id_car = :id_car 
                    WHERE id = :id
                ");

                $requete->execute([
                    "name"       => $name,
                    "contact"    => $contact,
                    "date_start" => $date_start,
                    "date_end"   => $date_end,
                    "id_car"   => $id_car, 
                    "id"         => $id
                ]);
        
                // Redirection vers la liste après update
                $response->setData('pageTitle', 'Accueil')
                        ->setData('message', "Modification de la réservation de $name")
                        ->render('templates/index.html.php');

            }
        }

        public function deleteAction(HttpRequest $request, HttpResponse $response) {            
            // Démarrer la session pour vérifier l'état de connexion
            session_start();
            if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
                $response->setData('pageTitle', 'Connexion requise')
                        ->setData('errorMessage', 'Veuillez vous connecter pour accéder à la liste des réservations.')
                        ->render('templates/login/form.html.php');
                return;
            }
            
            if (isset($_GET['id'])) {
                $id = (int) $_GET['id'];
            
                // Vérifier que la réservation existe
                $req = $this->pdo->prepare("SELECT name,id FROM reservations WHERE id = ?");
                $req->execute([$id]);
                $reservation = $req->fetch(PDO::FETCH_ASSOC);
                $req->closeCursor();
            
                if (!$reservation) {
                    $response->setData('pageTitle', 'Accueil')
                    ->setData('message', "Réservation introuvable !")
                    ->render('templates/index.html.php');
                }
            
                // Suppression
                $requete = $this->pdo->prepare("DELETE FROM reservations WHERE id = :id");
                $requete->execute(["id" => $id]);
            
                // Redirection vers la liste
                $name = $reservation['name'];
                $response->setData('pageTitle', 'Accueil')
                        ->setData('message', "Suppresion  de la réservation de $name ")
                        ->render('templates/index.html.php');


            } else {
                echo "<h3>Serveur indisponible, quelqu'un a essayé depuis l'URL</h3>";
            }
        }   
        
         public function listAction(HttpRequest $request, HttpResponse $response) {
            // Démarrer la session pour vérifier l'état de connexion
            session_start();
            if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
                $response->setData('pageTitle', 'Connexion requise')
                        ->setData('errorMessage', 'Veuillez vous connecter pour accéder à la liste des réservations.')
                        ->render('templates/login/form.html.php');
                return;
            }

            // Récupérer toutes les réservations (juste les colonnes utiles)
            $req = $this->pdo->prepare("SELECT name, contact, date_start, date_end,id_car, id FROM reservations");
            $req->execute([]);
            $reservations = $req->fetchAll(PDO::FETCH_ASSOC);
            $req->closeCursor();
        
            // Récupérer une réservation spécifique si id est passé en GET
            $data = null;
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $req = $this->pdo->prepare("SELECT name, contact, date_start, date_end,id_car, id FROM reservations WHERE id = :id");
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
            session_start();
            if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
                $response->setStatusCode(401)
                        ->setData('pageTitle', 'Connexion requise')
                        ->setData('errorMessage', 'Veuillez vous connecter pour voir les détails de la réservation.')
                        ->render('templates/login.html.php');
                return;
            }

            $id = isset($_GET['id']) ? $_GET['id'] :  null;

            if (!$id || !is_numeric($id)) {
                $response->setStatusCode(400)
                        ->setData('pageTitle', 'Erreur')
                        ->setData('errorMessage', 'ID de réservation invalide.')
                        ->render('templates/error.html.php');
                return;
            }

            try {
                $stmt = $this->pdo->prepare("SELECT * FROM reservations WHERE id = ?");
                $stmt->execute([$id]);
                $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$reservation) {
                    $response->setStatusCode(404)
                            ->setData('pageTitle', 'Erreur')
                            ->setData('errorMessage', 'Réservation non trouvée.')
                            ->render('templates/error.html.php');
                    return;
                }

                $response->setData('pageTitle', 'Détails de la Réservation')
                        ->setData('reservation', $reservation)
                        ->render('templates/reservation/show.html.php');
            } catch (Exception $e) {
                $response->setStatusCode(500)
                        ->setData('pageTitle', 'Erreur')
                        ->setData('errorMessage', 'Erreur lors de la récupération de la réservation : ' . $e->getMessage())
                        ->render('templates/error.html.php');
            }
        }
    }
    
?>
