<?php

require_once(__DIR__.'/../init.php');

// build the value for the form "action" attribute
$formAction = RequestHelper::buildPathWithQueryParameters('login.php', [
    '_referer' => RequestHelper::getQueryParameter('_referer'),
]);

/*
 * handle Login form
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $plainPassword = $_POST['password'];

    /**
     * valido gli input
     */
    $loginHandler = new LoginHandler($authenticationManager);

    try {
        $user = $loginHandler->handleLoginForm($email, $plainPassword);
    } catch (Exception $exception) {
        $error = $exception->getMessage();
    }

    if (isset($user)) {
        $logger = new Logger($app);
        $logger->writeLogLogin($email);

        $referer = array_key_exists('_referer', $_GET) ? $_GET['_referer'] : null;

        $authenticationManager->authenticateUser($user);

        $redirectManager = new RedirectManager($authenticationManager);
        $redirectManager->redirect($referer);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
    <?php $templateHelper->printHead(); ?>

    <body>
        <?php require_once(__DIR__ . '/../templates/_menu.php') ?>

        <div class="container">
            <div class="row">
                <div class="col-6 offset-3">
                    <h1>Login</h1>

                    <?php if (isset($error)): ?>
                        <p style="color: red;">
                            <?= $error; ?>
                        </p>
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
