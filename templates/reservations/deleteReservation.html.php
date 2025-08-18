<?php
    if (!defined('APP_ACCESS')) {
        define('APP_ACCESS', true);
    }
?>

<!DOCTYPE html>
<html lang="fr">
    
    <?php 
        require_once "../../templates/blocks/header.html.php";
    ?>
    <body>
        <!-- Header -->
        <header class="bg-primary text-white text-center py-4">
            <h1>Bienvenue sur notre site</h1>
            <p>Location de voitures simplifiée</p>
        </header>

        <!-- Navigation -->
        <?php
            require_once "../../templates/blocks/navbar.html.php";
        ?>  

        <!-- Main Content with Sidebar -->
        <div class="container-fluid my-4">
            <div class="row">
                <!-- Sidebar -->
                <?php
                  require_once "../../templates/blocks/sidebar.html.php";
                ?>  
                <!-- Main Content -->
            
                <div class="col-md-9">
                    <h2>Reservation effacé!</h2>
                    </div>        
            </div>
        </div>

        <?php
         require_once "../../templates/blocks/footer.html.php";
        ?>
    </body>
</html>

