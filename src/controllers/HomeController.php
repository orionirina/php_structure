<?php
    require_once 'includes/HttpRequest.php';
    require_once 'includes/HttpResponse.php';

    class HomeController {
        public function index(HttpRequest $request, HttpResponse $response) {
            $response->setData('pageTitle', 'Accueil')
                    ->render('templates/index.html.php');
        }
    }
?>

