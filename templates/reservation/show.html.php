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
                        <h2><i class="fas fa-eye"></i> Détails de la Réservation</h2>
                        <div class="reservation-details">
                            <?php if (!empty($errorMessage)): ?>
                                <div class="alert alert-danger" role="alert">
                                    <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($errorMessage); ?>
                                </div>
                            <?php else: ?>
                                <h3>Réservation #<?php echo htmlspecialchars($reservation['id']); ?></h3>
                                <p>
                                    <i class="fas fa-user"></i> 
                                    <strong>Nom :</strong><?php echo htmlspecialchars($reservation['user_name']); ?> 
                                </p>
                                <p>
                                    <i class="fas fa-phone"></i> 
                                    <strong>Contact :</strong> <?php echo htmlspecialchars($reservation['contact']); ?>
                                </p>
                                <p>
                                    <i class="fas fa-car"></i> 
                                    <strong>Type de voiture :</strong> <?php echo htmlspecialchars($reservation['car_name']); ?>
                                </p>
                                <p>
                                    <i class="fas fa-calendar-day"></i> 
                                    <strong>Date de début :</strong> <?php echo htmlspecialchars($reservation['date_start']); ?>
                                </p>
                                <p>
                                    <i class="fas fa-calendar-day"></i> 
                                    <strong>Date de fin :</strong> <?php echo htmlspecialchars($reservation['date_end']); ?>
                                </p>
                                <div class="mt-3">
                                    <a href="/reservation/edit?id=<?php echo $reservation['id']; ?>" class="btn btn-primary">
                                        <i class="fas fa-edit"></i> Modifier
                                    </a>
                                    <a href="/reservation/delete?id=<?php echo $reservation['id']; ?>" class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer cette réservation ?');">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </a>
                                    <a href="/reservation/list" class="btn btn-secondary">
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

