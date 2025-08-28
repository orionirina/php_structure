<?php
    if (!defined('APP_ACCESS')) {
        define('APP_ACCESS', true);
    }
?>

<!DOCTYPE html>
<html lang="fr">
    
    <?php 
        require_once "templates/blocks/head.html.php";
    ?>
    <body>
        <!-- Header -->
        <?php 
            require_once "templates/blocks/header.html.php";
        ?>

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
                    <div class="main-content">
                        <h2><i class="fas fa-eye"></i> Détails de la voiture</h2>
                        <div class="voiture-details">
                            <?php if (!empty($errorMessage)): ?>
                                <div class="alert alert-danger" role="alert">
                                    <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($errorMessage); ?>
                                </div>
                            <?php else: ?>
                                <h3>Voiture #<?php echo htmlspecialchars($car['id']); ?></h3>
                                <p>
                                    <i class="fas fa-user"></i> 
                                    <strong>Nom :</strong><?php echo htmlspecialchars($car['name']); ?> 
                                </p>
                                <p>
                                    <i class="fas fa-car"></i> 
                                    <strong>Type du voiture :</strong> <?php echo htmlspecialchars($car['price']); ?>
                                </p>
                              
                                <div class="mt-3">
                                    <a href="/car/edit?id=<?php echo $car['id']; ?>" class="btn btn-primary">
                                        <i class="fas fa-edit"></i> Modifier
                                    </a>
                                    <a href="/car/delete?id=<?php echo $car['id']; ?>" class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer cette réservation ?');">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </a>
                                    <a href="/car/list" class="btn btn-secondary">
                                        <i class="fas fa-list"></i> Retour à la liste
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>        
            </div>
        </div>

        <?php
         require_once "templates/blocks/footer.html.php";
        ?>
    </body>
</html>

