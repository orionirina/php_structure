<?php
require_once 'includes/HttpRequest.php';
require_once 'includes/HttpResponse.php';

/**
 * Class Kernel
 * Manages the application routing and dispatching.
 */
class Kernel {
    /**
     * @var array List of routes loaded from XML
     */
    private $routes;

    /**
     * Kernel constructor.
     * Loads routes from the XML configuration file.
     */
    public function __construct() {
        $this->loadRoutes();
    }

    /**
     * Load routes from the XML configuration file.
     * @return void
     */
    private function loadRoutes() {
        $xmlFile = 'config/routes.xml';
        if (!file_exists($xmlFile)) {
            die("Erreur : Le fichier de routes '$xmlFile' n'existe pas.");
        }

        $xml = simplexml_load_file($xmlFile);
        $this->routes = [];

        foreach ($xml->route as $route) {
            $this->routes[] = [
                'path' => (string)$route['path'],
                'controller' => (string)$route['controller'],
                'action' => (string)$route['action'],
                'method' => strtoupper((string)$route['method'])
            ];
        }
    }

    /**
     * Dispatch the request to the appropriate controller and action.
     * @param HttpRequest $request
     * @param HttpResponse $response
     * @return void
     */
    public function dispatch(HttpRequest $request, HttpResponse $response) {
        $uri = $request->getUri();
        $method = $request->getMethod();

        // Nettoyer l'URI (supprimer les paramètres de requête)
        $uri = parse_url($uri, PHP_URL_PATH);

        // Rechercher une correspondance dans les routes
        foreach ($this->routes as $route) {
            // Convertir le chemin de la route en expression régulière pour gérer les paramètres
            $pattern = preg_replace('#\{[a-zA-Z0-9_]+\}#', '([0-9]+)', $route['path']);
            $pattern = '#^' . str_replace('/', '\\/', $pattern) . '$#';

            if (preg_match($pattern, $uri, $matches) && $route['method'] === $method) {
                $controllerName = $route['controller'];
                $action = $route['action'];

                // Vérifier si le contrôleur existe
                $controllerFile = "src/controllers/$controllerName.php";
                if (!file_exists($controllerFile)) {
                    $response->setStatusCode(500)
                             ->setData('pageTitle', 'Erreur')
                             ->setData('errorMessage', "Le contrôleur '$controllerName' n'existe pas.")
                             ->render('templates/error.html.php');
                    return;
                }

                require_once $controllerFile;
                if (!class_exists($controllerName)) {
                    $response->setStatusCode(500)
                             ->setData('pageTitle', 'Erreur')
                             ->setData('errorMessage', "La classe '$controllerName' n'est pas définie.")
                             ->render('templates/error.html.php');
                    return;
                }

                $controller = new $controllerName();
                if (!method_exists($controller, $action)) {
                    $response->setStatusCode(500)
                             ->setData('pageTitle', 'Erreur')
                             ->setData('errorMessage', "L'action '$action' n'existe pas dans '$controllerName'.")
                             ->render('templates/error.html.php');
                    return;
                }

                // Ajouter les paramètres d'URL à la requête
                if (count($matches) > 1) {
                    $request->setParam('id', $matches[1]);
                }

                // Appeler l'action du contrôleur
                $controller->$action($request, $response);
                return;
            }
        }

        // Route non trouvée
        $response->setStatusCode(404)
                 ->setData('pageTitle', 'Page non trouvée')
                 ->setData('errorMessage', 'La page demandée n\'existe pas.')
                 ->render('templates/error.html.php');
    }
}
?>