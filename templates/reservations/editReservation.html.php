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
                    <h1 style="ms-4">MODIFICATION DE LA  RÉSERVATION</h1>
                        <div class="container-fluid">
                            <form action="<?= $roote ?>" method="POST">
                                <div class="form-group">
                                    <label for="nom">Nom</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?= $reservation['name'];?>" placeholder="Entrez votre nom" required>
                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="type_car">Type de voiture</label>
                                        <select class="form-control" id="type_car" name="type_car" placeholder="Sélectionnez un type de voiture" required>
                                            <option 
                                                <?php if( $reservation['type_car'] == Constant::CATEGORY_MINIBUS): ?> selected <?php endif ?>
                                                value="<?= Constant::CATEGORY_MINIBUS ?>"> Minibus
                                            </option>
                                            <option 
                                                <?php if( $reservation['type_car'] == Constant::CATEGORY_CAMION): ?> selected <?php endif ?>
                                                value="<?= Constant::CATEGORY_CAMION ?>"> Camion
                                            </option>
                                            <option 
                                                <?php if( $reservation['type_car'] == Constant::CATEGORY_PLAISIR): ?> selected <?php endif ?>
                                                value="<?= Constant::CATEGORY_PLAISIR ?>"> Plaisir
                                            </option>
                                            <option 
                                                <?php if( $reservation['type_car'] == Constant::CATEGORY_MOTO): ?> selected <?php endif ?>
                                                value="<?= Constant::CATEGORY_MOTO ?>"> Moto
                                            </option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-6">
                                        <label for="contact">Contact</label>
                                        <input type="text" class="form-control" id="contact" name="contact" value="<?= $reservation['contact'];?>" placeholder="Entrez votre contact (email ou téléphone)" required>
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

