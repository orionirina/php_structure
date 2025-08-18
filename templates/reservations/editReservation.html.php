<?php
    if (!defined('APP_ACCESS')) {
        define('APP_ACCESS', true);
    }
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
                   
                <div class="col-md-9">
                    <h1 style="margin-left:200px">EDIT RESERVATION</h1>
                        <div>
                        <form action="<?php echo $roote ?>" method="POST" style="max-width:600px; margin:auto; padding:20px; border:1px solid #ccc; border-radius:10px; background-color:#f8f9fa;">
                            <input type="text" name="name" value="<?php echo htmlspecialchars($reservation['name']); ?>" placeholder="Nom" style="width:500px; margin-top:30px; margin-bottom:30px; padding:5px;" required> 
                            <br>
                            <input type="text" name="contact" value="<?php echo htmlspecialchars($reservation['contact']); ?>" placeholder="Contact" style="width:500px; margin-bottom:30px; padding:5px;" required>
                            <br>

                            <div class="DHdebut">
                                <div style="margin-bottom:10px;">
                                    <p>Période de location :</p>
                                </div>
                                <div style="display:flex; gap:20px;">
                                    <div>
                                        <p>Date Début</p>
                                        <input type="datetime-local" name="date_start" value="<?php echo date('Y-m-d\TH:i', strtotime($reservation['date_start'])); ?>" style="width:171px; height:30px;" required>
                                    </div>
                                    <div>
                                        <p>Date Fin</p>
                                        <input type="datetime-local" name="date_end" value="<?php echo date('Y-m-d\TH:i', strtotime($reservation['date_end'])); ?>" style="width:171px; height:30px;" required>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block" style="margin-top:30px;">Modifier</button>

                        </form>

                <?php if (!empty($message)) echo "<p style='color:green;margin-top:15px;'>$message</p>"; ?>


            


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

