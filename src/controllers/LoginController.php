<?php
    require_once 'includes/HttpRequest.php';
    require_once 'includes/HttpResponse.php';
    require_once 'src/services/PdoService.php';

    class LoginController {

        public function showLogin(HttpRequest $request, HttpResponse $response) {
            $nombre = 3444;
            $response->setData('errorMessage', '')
                    ->setData('nombra', $nombre)
                    ->render('templates/login/form.html.php');
                    
        }

        public function handleLogin(HttpRequest $request, HttpResponse $response) {
            $pdoService = new PdoService();
            $pdo = $pdoService->getPdo();


            if ($request->isMethod('POST')) {
                $email = $request->getPost('email','');
                $password = $request->getPost('password','');

                // Validation simple
                if (empty($email) || empty($password)) {
                    $response->setStatusCode(400)
                            ->setData('pageTitle', 'Connexion')
                            ->setData('errorMessage', 'Tous les champs sont requis.')
                            ->render('templates/login/form.html.php');
                    return;
                }

                try {
                    $req = $pdo->prepare("SELECT * FROM user WHERE email= :email");
                    $req->execute([ 'email' => $email]);
                    $user = $req->fetch(PDO::FETCH_ASSOC);

                    // var_dump($user , password_verify($password, $user['password']));die;

                    // if ($user && password_verify($password, $user['password'])) {
                    if ($user && $password === $user['password']) {
                        // Démarrer la session
                        session_start();
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['name'] = $user['name'];
                        $_SESSION['logged_in'] = true;

                        // Rediriger vers la page d'accueil ou la liste des réservations
                        $response->redirect('/reservation/list');
                    } else {
                        $response->setStatusCode(401)
                                ->setData('pageTitle', 'Connexion')
                                ->setData('errorMessage', 'Nom d\'utilisateur ou mot de passe incorrect.')
                                ->render('templates/login/form.html.php');
                    }
                } catch (Exception $e) {
                    $response->setStatusCode(500)
                            ->setData('pageTitle', 'Erreur')
                            ->setData('errorMessage', 'Erreur lors de la connexion : ' . $e->getMessage())
                            ->render('templates/error.html.php');
                }
            } else{
                $response->setData('pageTitle', 'Erreur')
                         ->setData('errorMessage', 'Methode non autorisée')
                         ->render('templates/error.html.php');
            }
        }

        public function logout(HttpRequest $request, HttpResponse $response)
        {
            session_start();
            session_unset();
            session_destroy();
            $response->redirect('/login');
        }
    }
?>