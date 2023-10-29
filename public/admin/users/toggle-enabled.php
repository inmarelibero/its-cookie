<?php require_once(__DIR__.'/../../../init.php'); ?>

<?php
    $redirectManager = new RedirectManager($authenticationManager);
    $redirectManager->redirectIfNotAuthenticated();

    $user = $authenticationManager->findUser($_GET['id']);

    if ($user === null) {
        $redirectManager->redirect('/admin/users/index.php');
    }

    // @TODO: is user is enabled, set it as disabled; viceversa otherwise
    $authenticationManager->toggleEnabled($user);

    //
    $redirectManager->redirect('/admin/users/index.php');
