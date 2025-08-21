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
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Listes des Reservations</h5>
                        <a href="/reservation/new" class="btn btn-primary p-1 mr-2" title="Ajouter une reservation"><i class="fas fa-add"></i></a>
                    </div>
            
                    <div class="container mt-3">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Contact</th>
                                    <th>Début</th>
                                    <th>Fin</th>
                                    <th>Type</th>
                                    <th>Actions</th>
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
                                <td><?= htmlspecialchars(Constant::$array_select_type_car[$reservation['id_car']]); ?></td>

                                <td>
                                    <span class="col-4 px-0">
                                        <a class="text-secondary" href="<?= $roote_show; ?>" title="Voir"><i class="fas fa-eye"></i></a>
                                    </span>
                                    <span class="col-4 px-0">
                                        <a class="text-secondary" href="<?= $roote_edit; ?>"><i class="fas fa-edit" title="Modifier"></i></a>
                                    </span>
                                    <span class="col-4 px-0">
                                        <a class="text-danger" href="<?= $roote_delete; ?>" onclick="return confirm('Voulez-vous vraiment supprimer cette réservation ?');" title="Supprimer"><i class="fas fa-trash"></i></a>
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

