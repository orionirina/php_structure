<?php
    if (!defined('APP_ACCESS')) {
        define('APP_ACCESS', true);
    }
?>

<!DOCTYPE html>
<html lang="fr">
    
    <?php 
        include "blocks/head.html.php";
    ?>
    <body>
        <!-- Header -->
        <?php 
            require_once "blocks/header.html.php";
        ?>

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
                        <?php 
                            if (isset($message)) { 
                                echo '<p class="text-success">' . $message . '</p>';
                            } 
                        ?>  
                    </div>
                </div>
            </div>
        </div>

        <?php
         include "blocks/footer.html.php";
        ?>
    </body>
</html>