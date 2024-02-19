<?php 
require_once('../init.php');

$redirecter->redirectIfNotAuthenticated();

// gestisce il form se la richiesta è in POST
if ($_SERVER['REQUEST_METHOD'] ==='POST') {
    try {
        tryChangePassword(getEmailOfAuthenticatedUser(), $_POST['password']);
        $redirecter->redirectToHome();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

?>

<!doctype html>
<html lang="en">
    <?php require_once('../templates/_head.php'); ?>

    <body>
        <?php require_once('../templates/_menu.php'); ?>

        <div class="container">
            <div class="row">
                <div class="col">

                    <h1>CHANGE PASSWORD</h1>

                    <?php if (isset($error)): ?>
                        <p style="color:red">
                            <?php echo $error ?>
                        </p>
                    <?php endif ?>

                    <form action="change-password.php" method="post" novalidate>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="text" class="form-control" name="password" />
                        </div>
                        <button type="submit" class="btn btn-primary">INVIA</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
