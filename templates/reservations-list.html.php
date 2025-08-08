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
    <title><?php echo htmlspecialchars($pageTitle ?? 'Liste des Réservations'); ?></title>
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
        .table-responsive {
            margin-top: 20px;
        }
        .action-buttons .btn {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="bg-primary text-white text-center py-4">
        <h1>Liste des Réservations</h1>
        <p>Consultez toutes les réservations enregistrées</p>
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
                    <h2>Liste des Réservations</h2>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Contact</th>
                                    <th scope="col">Type de Voiture</th>
                                    <th scope="col">Date de Début</th>
                                    <th scope="col">Date de Fin</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reservations ?? [] as $reservation): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($reservation['nom']); ?></td>
                                        <td><?php echo htmlspecialchars($reservation['contact']); ?></td>
                                        <td><?php echo htmlspecialchars($reservation['type_voiture']); ?></td>
                                        <td><?php echo htmlspecialchars($reservation['date_debut']); ?></td>
                                        <td><?php echo htmlspecialchars($reservation['date_fin']); ?></td>
                                        <td class="action-buttons">
                                            <a href="/reservations/edit/<?php echo $reservation['id']; ?>" class="btn btn-sm btn-primary" title="Éditer"><i class="fas fa-edit"></i></a>
                                            <a href="/reservations/view/<?php echo $reservation['id']; ?>" class="btn btn-sm btn-info" title="Voir"><i class="fas fa-eye"></i></a>
                                            <a href="/reservations/delete/<?php echo $reservation['id']; ?>" class="btn btn-sm btn-danger" title="Supprimer" onclick="return confirm('Voulez-vous vraiment supprimer cette réservation ?');"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
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