<?php
    
    //echo $_SERVER['REQUEST_METHOD'];
    //print_r($_POST);
    
    // Définir la constante pour l'accès aux templates
    define('APP_ACCESS', true);

    // Charger le noyau
    require_once 'includes/Kernel.php';

    // Instancier les objets nécessaires
    $request = new HttpRequest();
    $response = new HttpResponse();
    $kernel = new Kernel();

 
    // Dispatcher la requête
    $kernel->dispatch($request, $response);
?>