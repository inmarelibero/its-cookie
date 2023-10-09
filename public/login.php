<?php require_once('../init.php'); ?>

<?php

// build the value for the form "action" attribute
$formAction = buildPathWithQueryParameters('login.php', [
    '_referer' => getQueryParameter('_referer'),
]);

/*
 * handle Login form
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    /**
     * valido gli input
     */
    $result = handleLoginForm($email, $password);

    if ($result === true) {
        $logger = new Logger();
        $logger->writeLogLogin($email);


        $referer = array_key_exists('_referer', $_GET) ? $_GET['_referer'] : null;

        authenticateUser($email);

        redirect($referer);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
    <?php printHead(); ?>

    <body>
        <?php require_once('../_menu.php') ?>

        <div class="container">
            <div class="row">
                <div class="col-6 offset-3">
                    <h1>Login</h1>

                    <?php if (isset($result) && is_array($result)): ?>
                        <?php foreach ($result as $error): ?>
                            <p style="color: red;">
                                <?= $error; ?>
                            </p>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <form method="POST" action="<?= $formAction ?>">
                        <div class="mb-3">
                            <label class="form-label">
                                Email
                            </label>
                            <input type="text" name="email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Password
                            </label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">INVIA</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
