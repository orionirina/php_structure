<?php
    if (!defined('APP_ACCESS')) {
        define('APP_ACCESS', true);
    }
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo htmlspecialchars($pageTitle ?? 'Erreur'); ?></title>
        <!-- Bootstrap 4 CSS -->
        <!--"https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"-->
        <link rel="stylesheet" href="/assets/css/bootstrap_4.min.css">
        <style>
            body {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }
            .main-content {
                flex: 1;
                padding: 20px;
            }
            .sidebar {
                background-color: #f8f9fa;
                padding: 20px;
                height: 100%;
            }
            .footer {
                background-color: #343a40;
                color: white;
                padding: 20px 0;
            }
            .error-message {
                max-width: 600px;
                margin: 0 auto;
            }
        </style>
    </head>

    <body>
        <!-- Header -->
        <header class="bg-primary text-white text-center py-4">
            <h1>Erreur</h1>
            <p>Une erreur s'est produite</p>
        </header>

        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/">Logo</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/reservation/new">Nouvelle réservation</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/reservation/list">Liste des Réservations</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content with Sidebar -->
        <div class="container-fluid my-4">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-3">
                    <div class="sidebar">
                        <h4>Menu Latéral</h4>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="#">Lien 1</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Lien 2</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Lien 3</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Lien 4</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Main Content -->
                <div class="col-md-9">
                    <div class="main-content">
                        <h2>Erreur</h2>
                        <div class="alert alert-danger error-message" role="alert">
                            <?php echo htmlspecialchars($errorMessage ?? 'Une erreur inconnue s\'est produite.'); ?>
                        </div>
                        <a href="/" class="btn btn-primary">Retour à l'accueil</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer text-center">
            <div class="container">
                <p>&copy; 2025 Votre Entreprise. Tous droits réservés.</p>
                <p><a href="#" class="text-white">Mentions légales</a> | <a href="#" class="text-white">Politique de confidentialité</a></p>
            </div>
        </footer>

        <!-- Bootstrap 4 JS and dependencies -->
        <script src="/assets/js/jquery-3.5.1.slim.min.js"></script>
        <script src="/assets/js/popper.min.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
    </body>
</html>