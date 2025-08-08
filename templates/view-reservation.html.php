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
    <title><?php echo htmlspecialchars($pageTitle ?? 'Détails de la Réservation'); ?></title>
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
        .reservation-details {
            max-width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="bg-primary text-white text-center py-4">
        <h1>Détails de la Réservation</h1>
        <p>Consultez les détails de la réservation</p>
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
                    <a class="nav-link" href="/reservation">Réservation</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="/reservations">Liste des Réservations <span class="sr-only">(current)</span></a>
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
                    <h2>Détails de la Réservation</h2>
                    <div class="reservation-details">
                        <dl class="row">
                            <dt class="col-sm-3">Nom</dt>
                            <dd class="col-sm-9"><?php echo htmlspecialchars($reservation['nom']); ?></dd>
                            <dt class="col-sm-3">Contact</dt>
                            <dd class="col-sm-9"><?php echo htmlspecialchars($reservation['contact']); ?></dd>
                            <dt class="col-sm-3">Type de voiture</dt>
                            <dd class="col-sm-9"><?php echo htmlspecialchars($reservation['type_voiture']); ?></dd>
                            <dt class="col-sm-3">Date de début</dt>
                            <dd class="col-sm-9"><?php echo htmlspecialchars($reservation['date_debut']); ?></dd>
                            <dt class="col-sm-3">Date de fin</dt>
                            <dd class="col-sm-9"><?php echo htmlspecialchars($reservation['date_fin']); ?></dd>
                        </dl>
                        <a href="/reservations" class="btn btn-primary">Retour à la liste</a>
                    </div>
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>