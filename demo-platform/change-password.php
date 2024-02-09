<?php 
require_once('init.php');

redirectIfNotAuthenticated();

// gestisce il form se la richiesta è in POST
if ($_SERVER['REQUEST_METHOD'] ==='POST') {
    try {
        tryChangePassword(getEmailOfAuthenticatedUser(), $_POST['password']);
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

?>

<html>
    <head>
        <?php require_once('head.php'); ?>
    </head>
    <body>
        <?php require_once('menu.php'); ?>

        <form action="change-password.php" method="post">
            <h1>CHANGE PASSWORD</h1>
            <?php if(isset($error)): ?>
                <p style="color:red">
                    <?php echo $error ?>
                </p>
            <?php endif ?>
            
            
            
            <p>
                <label>password</label>
                <input type="password" name="password">
            </p>

            <p>
                <button type="submit">INVIA</button>
            </p>
        </form>
    </body>
</html>
