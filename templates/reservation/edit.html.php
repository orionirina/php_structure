<?php
    if (!defined('APP_ACCESS')) {
        define('APP_ACCESS', true);
    }
    require_once "src/models/Constant.php";
    
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
                    <h5 class="mx-3">MODIFICATION DE LA  RÉSERVATION</h5>
                    <div class="container-fluid">
                        <form action="<?= $roote ?>" method="POST">
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="id_car">Type de voiture</label>
                                    <select class="form-control" id="id_car" name="id_car" placeholder="Sélectionnez un type de voiture" required>
                                        <?php foreach ($listCar as $car): ?>
                                            <option 
                                            <?php if ($car['id'] === $reservation['id_car']): ?> selected <?php endif ?> 
                                                value="<?= $car['id'] ?>">
                                                <?= $car['name'] ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                
                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="date_start">Date de début</label>
                                    <input type="date" class="form-control" id="date_start" name="date_start"  value="<?= date('Y-m-d', strtotime($reservation['date_start'])); ?>" required>
                                </div>
                                <div class="form-group col-6">
                                    <label for="date_end">Date de fin</label>
                                    <input type="date" class="form-control" id="date_end" name="date_end" value="<?= date('Y-m-d', strtotime($reservation['date_end'])); ?>" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Réserver</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <?php
         require_once "templates/blocks/footer.html.php";
        ?>
    </body>
</html>

