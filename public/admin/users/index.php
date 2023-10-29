<?php require_once(__DIR__.'/../../../init.php'); ?>

<?php
    $redirectManager = new RedirectManager($authenticationManager);
    $redirectManager->redirectIfNotAuthenticated();

    $users = $authenticationManager->getUsers();
?>


<!DOCTYPE html>
<html lang="en">
    <?php $templateHelper->printHead(); ?>

    <body>
        <?php require_once(__DIR__ . '/../../../templates/_menu.php') ?>

        <div class="container">
            <div class="row">
                <div class="col-8 offset-2">
                    <h1>Utenti</h1>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>EMAIL</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td>
                                    <?= $user->getId(); ?>
                                </td>
                                <td>
                                    <?= $user->getEmail(); ?>
                                </td>
                                <td style="text-align: right">
                                    <a href="/admin/users/toggle-enabled.php?id=<?= $user->getId(); ?>" class="btn btn-primary">
                                        <?= $user->isEnabled() ? 'DISABILITA' : 'ABILITA' ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="/admin/users/change-password.php?id=<?= $user->getId(); ?>" class="btn btn-primary">MODIFICA PASSWORD</a>
                                </td>
                                <td>
                                    <a href="/admin/users/delete.php?id=<?= $user->getId(); ?>" class="btn btn-danger" onclick="return confirm('Are you sure?');">ELIMINA</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
