<?php
    require_once 'includes/HttpRequest.php';
    require_once 'includes/HttpResponse.php';
    require_once 'src/services/PdoService.php';
    require_once 'src/models/Constant.php';

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
                        ->render('templates/login/sign_up_form.html.php')
                        ->render('templates/login/sign_in_form.html.php');

                return;
            }
            
            $req = $this->pdo->prepare("SELECT * FROM car");
            $req->execute([]);
            $listCar = $req->fetchAll(PDO::FETCH_ASSOC);
            $req->closeCursor();

            $response->setData('pageTitle', 'Réservation')
                     ->setData('listCar', $listCar)
                     ->render('templates/reservation/new.html.php');
        }
        
        public function createAction(HttpRequest $request, HttpResponse $response) {
            // Démarrer la session pour vérifier l'état de connexion
            session_start();
            if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
                $response->setData('pageTitle', 'Connexion requise')
                        ->setData('errorMessage', 'Veuillez vous connecter pour accéder à la liste des réservations.')
                        ->render('templates/login/sign_in_form.html.php');
                return;
            }

            if ($request->isMethod('POST')) {
                $user = Constant::getSessionUser();
                $id_user = $user['id'];
                $date_start = $request->getPost('date_start','');
                $date_end = $request->getPost('date_end','');
                $id_car = $request->getPost('id_car','');
                $id_user = $user['id'];

                // var_dump($name, $contact, $date_start, $date_end, $type_car);die;

                $req = $this->pdo->prepare("INSERT INTO reservations ( date_start, date_end, id_car, status, id_user) VALUES (:date_start, :date_end, :id_car, :status, :id_user)");
                $req->execute([
                    ':date_start' => $date_start,
                    ':date_end' => $date_end,
                    ':id_car' => $id_car,
                    ':status' => 1,
                    ':id_user' => $id_user,
                ]);

                
                // $response->redirect('/');
                $response->setData('pageTitle', 'Accueil')
                    ->setData('message', "Ajout de réservation de " . $user['name'])
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

            $req = $this->pdo->prepare("SELECT * FROM car");
            $req->execute([]);
            $listCar = $req->fetchAll(PDO::FETCH_ASSOC);
            // var_dump($listCar);die;

            $req->closeCursor();
        
            if (!$reservation) {
                $response->setData('pageTitle', 'Accueil')
                    ->setData('message', "Réservation introuvable !")
                    ->render('templates/index.html.php');
            }
        
            // Action du formulaire → POST sur la même route
            $roote = "/reservation/update?id=" . $reservation['id'];
        
            $response->setData('pageTitle', 'Modifier Réservation')
                        ->setData('listCar', $listCar)
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
                $user = Constant::getSessionUser();
                $id_user = $user['id'];
                $date_start = $_POST['date_start'] ?? null;
                $date_end   = $_POST['date_end'] ?? null;
                $id_car   = $_POST['id_car'] ?? null;

        
                if (!$date_start || !$date_end || !$id_car) {
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
                    SET date_start = :date_start, date_end = :date_end, id_car = :id_car 
                    WHERE id = :id
                ");

                $requete->execute([
                    "date_start" => $date_start,
                    "date_end"   => $date_end,
                    "id_car"   => $id_car, 
                    "id"         => $id
                ]);
        
                // Redirection vers la liste après update
                $response->setData('pageTitle', 'Accueil')
                        ->setData('message', "Modification de la réservation de " . $user['name'])
                        ->render('templates/index.html.php');

            }
        }

        public function deleteAction(HttpRequest $request, HttpResponse $response) {            
            // Démarrer la session pour vérifier l'état de connexion
            session_start();
            if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
                $response->setData('pageTitle', 'Connexion requise')
                        ->setData('errorMessage', 'Veuillez vous connecter pour accéder à la liste des réservations.')
                        ->render('templates/login/sign_in.form.html.php');
                return;
            }
            
            if (isset($_GET['id'])) {
                $user = Constant::getSessionUser();
                $id_user = $user['id'];
                $id = (int) $_GET['id'];
            
                // Vérifier que la réservation existe
                $req = $this->pdo->prepare("SELECT reservations.id, user.name AS user_name
                FROM reservations
                LEFT JOIN user ON user.id = reservations.id_user
                WHERE reservations.id = ?
            ");

            $req = $this->pdo->prepare("SELECT reservations.id, user.name AS user_name FROM reservations
                    LEFT JOIN user ON user.id = reservations.id_user
                    WHERE reservations.id = ?");

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
                $response->setData('pageTitle', 'Accueil')
                        ->setData('message', "Suppresion  de la réservation de " . $user['name'])
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
                            ->render('templates/login/sign_in_form.html.php');
                    return;
                }

                // Récupération l'id ou du nom de l'utilisateur connecté
                $userId   = $_SESSION['user_id'] ?? null;
                $userName = $_SESSION['user_name'] ?? null;

                // Vérifier qu’on a bien l’info
                if (!$userId && !$userName) {
                    $response->setStatusCode(400)
                            ->setData('pageTitle', 'Erreur')
                            ->setData('errorMessage', 'Impossible d’identifier l’utilisateur connecté.')
                            ->render('templates/error.html.php');
                    return;
                }

                // Requête SQL : récupérer seulement les réservations de cet utilisateur
                $req = $this->pdo->prepare("SELECT reservations.id, reservations.date_start, reservations.date_end,user.name AS user_name, user.contact, 
                        car.name AS car_name
                    FROM reservations
                    LEFT JOIN user ON user.id = reservations.id_user
                    LEFT JOIN car ON reservations.id_car = car.id
                    WHERE reservations.id_user = :id_user
                    OR user.name = :user_name
                ");

                $req->execute([
                    'id_user'   => $userId,
                    'user_name' => $userName
                ]);

                $reservations = $req->fetchAll(PDO::FETCH_ASSOC);
                $req->closeCursor();

                // Passer les données à la vue
                $response->setData('pageTitle', 'Liste des Réservations')
                        ->setData('reservations', $reservations)
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
            
            if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
                $response->setStatusCode(400)
                         ->setData('pageTitle', 'Erreur')
                         ->setData('errorMessage', 'ID de réservation invalide.')
                         ->render('templates/error.html.php');
                return;
            }
            
            try {
                $id = $_GET['id'];
            
                $req = $this->pdo->prepare("SELECT reservations.id, reservations.date_start, reservations.date_end, user.name AS user_name, user.contact, car.name AS car_name
                    FROM reservations
                    LEFT JOIN user ON user.id = reservations.id_user
                    LEFT JOIN car ON car.id = reservations.id_car
                    WHERE reservations.id = :id
                ");
                $req->execute(['id' => $id]);
                $reservation = $req->fetch(PDO::FETCH_ASSOC);
                $req->closeCursor();
            
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
