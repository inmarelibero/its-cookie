<?php 
require_once('../init.php');

$redirecter->redirectIfAuthenticated();

// gestisce il form se la richiesta è in POST
if ($_SERVER['REQUEST_METHOD'] ==='POST') {
    $loginResult = null;
    
    // prova ad effettuare il login
    try {
        $loginResult = tryLogin($_POST['email'], $_POST['password']);
    } catch(Exception $exception) {
        // inizializza la variabile $error contenente l'errore impostato sull'eccezione
        $error = $exception->getMessage();
    }

    // effettua il redirect se il login è andato a buon fine
    if ($loginResult === true) {
        $redirecter->redirectToHome();
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

                    <h1>LOGIN</h1>

                    <?php if (isset($error)): ?>
                        <p style="color:red">
                            <?php echo $error ?>
                        </p>
                    <?php endif ?>

                    <form action="login.php" method="post" novalidate>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" name="email" />
                        </div>
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
