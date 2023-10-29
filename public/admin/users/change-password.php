<?php require_once(__DIR__.'/../../../init.php'); ?>

<?php

$redirectManager = new RedirectManager($authenticationManager);
$redirectManager->redirectIfNotAuthenticated();

$user = $authenticationManager->findUser($_GET['id']);

if ($user === null) {
    $redirectManager->redirect('/admin/users/index.php');
}

// build the value for the form "action" attribute
$formAction = RequestHelper::buildPathWithQueryParameters('/admin/users/change-password.php', [
    'id' => RequestHelper::getQueryParameter('id'),
]);

/*
 * handle Login form
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];

    /**
     * valido gli input
     */
    try {
        // @TODO: change password (use a method of AuthenticationProvider)

        //
        $redirectManager->redirect('/admin/users/index.php');
    } catch (Exception $exception) {
        $error = $exception->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
    <?php $templateHelper->printHead(); ?>

    <body>
        <?php require_once(__DIR__ . '/../../../templates/_menu.php') ?>

        <div class="container">
            <div class="row">
                <div class="col-6 offset-3">
                    <h1>Cambio password</h1>
                    <p>
                        per l'utente <?= $user->getEmail(); ?>
                    </p>

                    <?php if (isset($error) && $error !== null): ?>
                        <p style="color: red;">
                            <?= $error; ?>
                        </p>
                    <?php endif; ?>
                    <form method="POST" action="<?= $formAction ?>">
                        <div class="mb-3">
                            <label class="form-label">
                                Nuova Password
                            </label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">INVIA</button>
                        <a href="/admin/users/index.php" class="btn btn-secondary">ANNULLA</a>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
