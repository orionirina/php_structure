<?php
    if (!defined('APP_ACCESS')) {
        define('APP_ACCESS', true);
    }
    require_once "src/models/Constant.php";
    // var_dump($listCar[0]['name']);die;
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
                    <h1 class="m-4">NOUVELLE RÉSERVATION</h1>
                    <div class="container-fluid">
                        <form action="../reservation/create" method="POST">
                            <div class="form-group">
                                <label for="nom" >Nom</label>
                                <input type="text" class="form-control" id="name" name="name" value="" placeholder="Entrez votre nom" required>
                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="id_car">Type de voiture</label>
                                    <select class="form-control" id="id_car" name="id_car" placeholder="Sélectionnez un type de voiture" required>
                                        <option value="<?= $listCar[0]['id'] ?>"><?= $listCar[0]['name'] ?></option>
                                        <option value="<?= $listCar[1]['id'] ?>"><?= $listCar[1]['name'] ?></option>
                                        <option value="<?= $listCar[2]['id'] ?>"><?= $listCar[2]['name'] ?></option>
                                    </select>
                                </div>
                                
                                <div class="form-group col-6">
                                    <label for="contact">Contact</label>
                                    <input type="text" class="form-control" id="contact" name="contact" placeholder="Entrez votre contact (email ou téléphone)" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="date_start">Date de début</label>
                                    <input type="date" class="form-control" id="date_start" name="date_start" required>
                                </div>
                                <div class="form-group col-6">
                                    <label for="date_end">Date de fin</label>
                                    <input type="date" class="form-control" id="date_end" name="date_end" required>
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

