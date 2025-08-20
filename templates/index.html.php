<?php
    if (!defined('APP_ACCESS')) {
        define('APP_ACCESS', true);
    }
?>

<!DOCTYPE html>
<html lang="fr">
    
    <?php 
        include "blocks/header.html.php";
    ?>
    <body>
        <!-- Header -->
        <header class="bg-primary text-white text-center py-4">
            <h1>Bienvenue sur notre site</h1>
            <p>Location de voitures simplifiée</p>
        </header>

        <!-- Navigation -->
        <?php
            include "blocks/navbar.html.php";
        ?>  

        <!-- Main Content with Sidebar -->
        <div class="container-fluid my-4">
            <div class="row">
                <!-- Sidebar -->
                <?php
                  include "blocks/sidebar.html.php";
                ?>  
                <!-- Main Content -->
                <div class="col-md-9">
                    <div class="main-content">
                        <h2>Accueil</h2>
                        <p>Bienvenue sur notre plateforme de location de voitures. Réservez votre véhicule dès maintenant !</p>
                        <a href="/reservation/new" class="btn btn-primary">Faire une réservation</a>
                    </div>
                </div>
            </div>
        </div>

        <?php
         include "blocks/footer.html.php";
        ?>
    </body>
</html>