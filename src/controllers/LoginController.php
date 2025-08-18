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
                
                $req = $pdo->prepare("SELECT * FROM user WHERE email= :email AND password= :password");
                $req->execute([ 'email' => $email, 'password' => $password ]);
                $user = $req->fetch();

                if($user){
                    $response->redirect('/');
                } else{
                    $response->setData('pageTitle', 'Connexion')
                             ->setData('errorMessage', 'Email ou mdp incorrect')
                             ->render('templates/login/form.html.php');
                }
            } else{
                $response->setData('pageTitle', 'Erreur')
                         ->setData('errorMessage', 'Methode non autorisée')
                         ->render('templates/error.html.php');
            }
        }
    }
?>