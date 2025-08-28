<?php
    require_once 'includes/HttpRequest.php';
    require_once 'includes/HttpResponse.php';
    require_once 'src/services/PdoService.php';

    class CarController {
        private $pdo;

        public function __construct()
        {
            $pdoService = new PdoService();
            $this->pdo = $pdoService->getPdo();
        }

        public function newCar(HttpRequest $request, HttpResponse $response) {
            session_start();

            if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
                $response->setData('pageTitle', 'Connexion requise')
                        ->setData('errorMessage', 'Veuillez vous connecter pour accéder à la liste des voitures.')
                        ->render('templates/login/sign_in_form.html.php')
                        ->render('templates/login/sign_in_form.html.php');

                return;
            }


            if ($_SESSION['role'] !== 'admin') {
                $response->setData('pageTitle', 'Accès refusé')
                        ->setData('message', "Vous n'avez pas les droits nécessaires pour accéder à cette page.")
                        ->render('templates/login/sign_in_form.html.php')
                        ->render('templates/login/sign_in_form.html.php');
                return;
            }
             
            $req = $this->pdo->prepare("SELECT name, price FROM car");
            $req->execute([]);
            $listCar = $req->fetchAll(PDO::FETCH_ASSOC);
            $req->closeCursor();

            $response->setData('pageTitle', 'Cars')
                     ->setData('listCar', $listCar)
                     ->render('templates/car/new.html.php');
            
            
        }
        public function createCar(HttpRequest $request, HttpResponse $response){
            session_start();

            if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
                $response->setData('pageTitle', 'Connexion requise')
                        ->setData('errorMessage', 'Veuillez vous connecter pour accéder à la liste des voitures.')
                        ->render('templates/car/sign_in_form.html.php');
                return;
            }

            if ($_SESSION['role'] !== 'admin') {
                $response->setData('pageTitle', 'Accès refusé')
                        ->setData('message', "Vous n'avez pas les droits nécessaires pour accéder à cette page.")
                        ->render('templates/login/sign_in_form.html.php')
                        ->render('templates/login/sign_in_form.html.php');
                return;
            }
           

            if ($request->isMethod('POST')) {
                $name = $request->getPost('name');
                $price = $request->getPost('price');
                // var_dump($name, $contact, $date_start, $date_end, $type_car);die;

                $req = $this->pdo->prepare("INSERT INTO car ( name, price) VALUES (:name, :price)");
                $req->execute([
                    ':name' => $name,
                    ':price' => $price,
                ]);

                
                // $response->redirect('/');
                $response->setData('pageTitle', 'Accueil')
                    ->setData('message', "Ajout du voiture:" .$name )
                    ->render('templates/index.html.php');

                     
            } else{
                $response->setData('pageTitle', 'Erreur')
                         ->setData('errorMessage', 'Methode non autorisée')
                         ->render('templates/error.html.php');
            }
                
        }
        public function listCar(HttpRequest $request, HttpResponse $response){
            session_start();

            if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
                $response->setData('pageTitle', 'Connexion requise')
                        ->setData('errorMessage', 'Veuillez vous connecter pour accéder à la liste des réservations.')
                        ->render('templates/login/sign_in_form.html.php');
                return;
            }

            if ($_SESSION['role'] !== 'admin') {
                $response->setData('pageTitle', 'Accès refusé')
                        ->setData('message', "Vous n'avez pas les droits nécessaires pour accéder à cette page.")
                        ->render('templates/login/sign_in_form.html.php')
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
            $req = $this->pdo->prepare("SELECT id,name, price FROM car");

            $req->execute();

            $car = $req->fetchAll(PDO::FETCH_ASSOC);
            $req->closeCursor();

            // Passer les données à la vue
            $response->setData('pageTitle', 'Liste des Réservations')
                      ->setData('car', $car)
                      ->render('templates/car/list.html.php');


        }
        public function showCar(HttpRequest $request, HttpResponse $response){
            session_start();
            if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
                $response->setStatusCode(401)
                         ->setData('pageTitle', 'Connexion requise')
                         ->setData('errorMessage', 'Veuillez vous connecter pour voir les détails de la réservation.')
                         ->render('templates/login.html.php');
                return;
            }
            if ($_SESSION['role'] !== 'admin') {
                $response->setData('pageTitle', 'Accès refusé')
                        ->setData('message', "Vous n'avez pas les droits nécessaires pour accéder à cette page.")
                        ->render('templates/login/sign_in_form.html.php')
                        ->render('templates/login/sign_in_form.html.php');
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
                $id = (int) $_GET['id'];

            
                $req = $this->pdo->prepare("SELECT id, name, price FROM car WHERE id = :id");
                $req->execute(['id' => $id]);
                $car = $req->fetch(PDO::FETCH_ASSOC);
                $req->closeCursor();
                if (!$car) {
                    $response->setStatusCode(404)
                             ->setData('pageTitle', 'Erreur')
                             ->setData('errorMessage', 'Voiture non trouvée.')
                             ->render('templates/error.html.php');
                    return;
                }
            
                $response->setData('pageTitle', 'Détails de la voiture')
                         ->setData('car', $car)
                         ->render('templates/car/show.html.php');
            
            } catch (Exception $e) {
                $response->setStatusCode(500)
                         ->setData('pageTitle', 'Erreur')
                         ->setData('errorMessage', 'Erreur lors de la récupération de la réservation : ' . $e->getMessage())
                         ->render('templates/error.html.php');
            }
        }
        public function editCar(HttpRequest $request, HttpResponse $response){
            session_start();
            if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
                $response->setData('pageTitle', 'Connexion requise')
                        ->setData('errorMessage', 'Veuillez vous connecter pour accéder à la liste des réservations.')
                        ->render('templates/login/form.html.php');
                return;
            }
            if ($_SESSION['role'] !== 'admin') {
                $response->setData('pageTitle', 'Accès refusé')
                        ->setData('message', "Vous n'avez pas les droits nécessaires pour accéder à cette page.")
                        ->render('templates/login/sign_in_form.html.php')
                        ->render('templates/login/sign_in_form.html.php');
                return;
            }
           

            if (!isset($_GET['id'])) {
                $response->setData('pageTitle', 'Accueil')
                    ->setData('message', "Aucun ID fourni")
                    ->render('templates/index.html.php');
            }
        
            $id = (int) $_GET['id'];
        
            $req = $this->pdo->prepare("SELECT id,name, price FROM car WHERE id = ?");
            $req->execute([$id]);
            $car = $req->fetch(PDO::FETCH_ASSOC);

            $req = $this->pdo->prepare("SELECT id,name,price FROM car");
            $req->execute([]);
            $listCar = $req->fetchAll(PDO::FETCH_ASSOC);
            //var_dump($listCar);die;

            $req->closeCursor();
        
            if (!$car) {
                $response->setData('pageTitle', 'Accueil')
                    ->setData('message', "Voiture introuvable !")
                    ->render('templates/index.html.php');
            }
        
            // Action du formulaire → POST sur la même route
            $roote = "/car/update?id=" . $car['id'];
        
            $response->setData('pageTitle', 'Modifier Réservation')
                        ->setData('listCar', $listCar)
                        ->setData('car', $car)
                        ->setData('roote', $roote)
                        ->render('templates/car/edit.html.php');
        }
        public function updateCar(HttpRequest $request, HttpResponse $response){
            // Démarrer la session pour vérifier l'état de connexion
            session_start();
            if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
                $response->setData('pageTitle', 'Connexion requise')
                        ->setData('errorMessage', 'Veuillez vous connecter pour accéder à la liste des réservations.')
                        ->render('templates/login/form.html.php');
                return;
            }

            if ($_SESSION['role'] !== 'admin') {
                $response->setData('pageTitle', 'Accès refusé')
                        ->setData('message', "Vous n'avez pas les droits nécessaires pour accéder à cette page.")
                        ->render('templates/login/sign_in_form.html.php')
                        ->render('templates/login/sign_in_form.html.php');
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
                $name = $_POST['name'] ?? null;
                $price  = $_POST['price'] ?? null;

        
                if (!$name || !$price) {
                    $response->setData('pageTitle', 'Accueil')
                            ->setData('message', "Tous les champs sont obligatoires")
                            ->render('templates/index.html.php');
                }
        
                // Vérifier que la réservation existe
                $req = $this->pdo->prepare("SELECT id FROM car WHERE id = ?");
                $req->execute([$id]);
                $reservation = $req->fetch(PDO::FETCH_ASSOC);
                $req->closeCursor();
        
                if (!$reservation) {
                    $response->setData('pageTitle', 'Accueil')
                            ->setData('message', "Voiture introuvable !")
                            ->render('templates/index.html.php');
                }
        
                // Mise à jour
                $requete = $this->pdo->prepare("UPDATE car 
                    SET name = :name, price = :price 
                    WHERE id = :id
                ");

                $requete->execute([
                    "name" => $name,
                    "price"   => $price,
                    "id" => $id
                ]);
        
                // Redirection vers la liste après update
                $response->setData('pageTitle', 'Accueil')
                        ->setData('message', "Modification de la voiture")
                        ->render('templates/index.html.php');

            }
        }

        public function deleteCar(HttpRequest $request, HttpResponse $response) {            
            // Démarrer la session pour vérifier l'état de connexion
            session_start();
            if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
                $response->setData('pageTitle', 'Connexion requise')
                        ->setData('errorMessage', 'Veuillez vous connecter pour accéder à la liste des réservations.')
                        ->render('templates/login/sign_in.form.html.php');
                return;
            }
            if ($_SESSION['role'] !== 'admin') {
                $response->setData('pageTitle', 'Accès refusé')
                        ->setData('message', "Vous n'avez pas les droits nécessaires pour accéder à cette page.")
                        ->render('templates/login/sign_in_form.html.php')
                        ->render('templates/login/sign_in_form.html.php');
                return;
            }
           
            
            if (isset($_GET['id'])) {
                $id = (int) $_GET['id'];
            
                // Vérifier que la voiture existe
                $req = $this->pdo->prepare("SELECT id, name,price
                FROM car WHERE id = ?
            ");

            $req = $this->pdo->prepare("SELECT id, name, price FROM car
                    WHERE id = ?");

                $req->execute([$id]);
                $car = $req->fetch(PDO::FETCH_ASSOC);
                $req->closeCursor();
            
                if (!$car) {
                    $response->setData('pageTitle', 'Accueil')
                    ->setData('message', "Voiture introuvable !")
                    ->render('templates/index.html.php');
                }
            
                // Suppression
                $requete = $this->pdo->prepare("DELETE FROM car WHERE id = :id");
                $requete->execute(["id" => $id]);
            
                // Redirection vers la liste
                $response->setData('pageTitle', 'Accueil')
                        ->setData('message', "Suppresion  de la voiture")
                        ->render('templates/index.html.php');

            } else {
                echo "<h3>Serveur indisponible, quelqu'un a essayé depuis l'URL</h3>";
            }
        }   
     }







?>