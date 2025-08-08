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
    <title><?php echo htmlspecialchars($pageTitle ?? 'Réservation'); ?></title>
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
        .reservation-form {
            max-width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="bg-primary text-white text-center py-4">
        <h1>Réservation de voiture</h1>
        <p>Réservez votre véhicule en quelques clics</p>
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
                <li class="nav-item active">
                    <a class="nav-link" href="/reservation">Réservation <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/reservations">Liste des Réservations</a>
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
                    <h2>Formulaire de Réservation</h2>
                    <?php if (!empty($errorMessage)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars($errorMessage); ?>
                        </div>
                    <?php endif; ?>
                    <div class="reservation-form">
                        <form method="POST" action="/reservation">
                            <div class="form-group">
                                <label for="nom">Nom</label>
                                <input type="text" class="form-control" id="nom" name="nom" required>
                            </div>
                            <div class="form-group">
                                <label for="contact">Contact</label>
                                <input type="text" class="form-control" id="contact" name="contact" required>
                            </div>
                            <div class="form-group">
                                <label for="typeVoiture">Type de voiture</label>
                                <select class="form-control" id="typeVoiture" name="typeVoiture" required>
                                    <option value="" disabled selected>Sélectionnez un type de voiture</option>
                                    <option value="Minibus">Minibus</option>
                                    <option value="Plaisir">Plaisir</option>
                                    <option value="Camion">Camion</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="dateDebut">Date de début</label>
                                <input type="datetime-local" class="form-control" id="dateDebut" name="dateDebut" required>
                            </div>
                            <div class="form-group">
                                <label for="dateFin">Date de fin</label>
                                <input type="datetime-local" class="form-control" id="dateFin" name="dateFin" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Réserver</button>
                        </form>
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