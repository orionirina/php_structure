<?php
    if (!defined('APP_ACCESS')) {
        define('APP_ACCESS', true);
    }
    require_once "src/models/Constant.php";
?>

<!DOCTYPE html>
<html lang="fr">
    
    <?php 
        require_once "templates/blocks/header.html.php";
    ?>
    <body>
        <!-- Header -->
        <header class="bg-primary text-white text-center py-4">
            <h1>Bienvenue sur notre site</h1>
            <p>Location de voitures simplifiée</p>
        </header>

        <!-- Navigation -->
        <?php
            require_once "templates/blocks/navbar.html.php";
        ?>  

        <!-- Main Content with Sidebar -->
        <div class="container-fluid my-4">
            <div class="row">
                <!-- Sidebar -->
                <?php
                  require_once "templates/blocks/sidebar.html.php";
                ?>  
                <!-- Main Content -->
            
                <div class="col-md-9">
                <h2>Reservation list</h2>
            
            <div class="container mt-3">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Contact</th>
                            <th>Début</th>
                            <th>Fin</th>
                            <th>Type du voiture</th>
                            
                        </tr>
                    </thead>
                <tbody>
                <?php foreach ($reservations as $reservation): ?>
                    <?php  
                        $roote_show = "/reservation/view?id=" . $reservation['id'];
                        $roote_edit = "/reservation/edit?id=" . $reservation['id'];
                        $roote_delete = "/reservation/delete?id=" . $reservation['id'];
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($reservation['name']); ?></td>
                        <td><?= htmlspecialchars($reservation['contact']); ?></td>
                        <td><?= htmlspecialchars($reservation['date_start']); ?></td>
                        <td><?= htmlspecialchars($reservation['date_end']); ?></td>
                        <td><?= htmlspecialchars(Constant::$array_select_type_car[$reservation['type_car']]); ?></td>

                        <td>
                            <span class="col-4 px-0">
                                <a href="<?= $roote_show; ?>">Voir</a>
                            </span>
                            <span class="col-4 px-0">
                                <a href="<?= $roote_edit; ?>">Modifier</a>
                            </span>
                            <span class="col-4 px-0">
                                <a href="<?= $roote_delete; ?>" onclick="return confirm('Voulez-vous vraiment supprimer cette réservation ?');">Supprimer</a>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>

                </tbody>
                </table>
            </div>
                </div>
            </div>
        </div>

        <?php
         require_once "templates/blocks/footer.html.php";
        ?>
    </body>
</html>

