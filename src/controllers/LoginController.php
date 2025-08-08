<?php
require_once 'includes/HttpRequest.php';
require_once 'includes/HttpResponse.php';

class LoginController {
    public function showLogin(HttpRequest $request, HttpResponse $response) {
        $response->setData('pageTitle', 'Connexion')
                 ->setData('errorMessage', '')
                 ->render('templates/login.html.php');
    }

    public function handleLogin(HttpRequest $request, HttpResponse $response) {
        if ($request->isMethod('POST')) {
            $email = $request->getPost('email', '');
            $password = $request->getPost('password', '');

            // Exemple de validation simple
            if ($email === 'test@example.com' && $password === 'password') {
                $response->redirect('/');
            } else {
                $response->setStatusCode(401)
                         ->setData('pageTitle', 'Connexion')
                         ->setData('errorMessage', 'Email ou mot de passe incorrect.')
                         ->render('templates/login.html.php');
            }
        } else {
            $response->setStatusCode(405)
                     ->setData('pageTitle', 'Erreur')
                     ->setData('errorMessage', 'Méthode non autorisée.')
                     ->render('templates/error.html.php');
        }
    }
}