<?php
/**
 * Render a template file with optional data.
 *
 * @param string $templatePath Path to the template file (e.g., 'templates/login.html.php').
 * @param array $data Optional data to pass to the template.
 * @return void
 */
function render($templatePath, $data = []) {
    // Convertir les données en variables accessibles dans le template
    extract($data);

    // Vérifier si le fichier de template existe
    if (!file_exists($templatePath)) {
        http_response_code(404);
        die("Erreur : Le template '$templatePath' n'existe pas.");
    }

    // Inclure le template
    require_once $templatePath;
}
?>