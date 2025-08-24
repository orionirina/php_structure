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
                    <?php if(!empty($errorMessage)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars($errorMessage); ?>
                        </div>
                    <?php endif ?>
                    
                    <div class ="login-form">
                        <form method="POST" action="/login/sign_up">
                            <div class="form-group">
                                <label for="email">Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Contact</label>
                                <input type="text" class="form-control" name="contact" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>

                            <div class="form-group">    
                                <label for="password">Mot de passe:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                           <button type="submit" class="btn btn-primary btn-block"> Se connecter</button>
                        </form>
                        <a href="/login" class="text-danger">Déja un compte? Sign in</a>
                    </div>
                </div>
            </div>
        </div>

        <?php
         require_once "templates/blocks/footer.html.php";
        ?>
    </body>
</html>

