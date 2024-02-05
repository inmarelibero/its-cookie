<?php 
require_once('init.php');

// gestisce il form se la richiesta è in POST
if ($_SERVER['REQUEST_METHOD'] ==='POST') {
    // LEGGERE GLI UTENTI 
    $data = readCredentials();

    // PRENDERE L'UTENTE A CUI VOGLIO AGGIORNARE LA PASSWORD
    foreach ($data as $index => $credentials){
        $emailCredentials = $credentials[0];
        if ($emailCredentials === getEmailOfAuthenticatedUser()){
            // AGGIORNO LA PASSWORD DI QUELL'UTENTE
            $data[$index][1] = md5($_POST['password']);
        }
    }

    // MEMORIZZO I CAMBIAMENTI DEL FILE USER.CSV
    $fp = fopen('users.csv', 'w');
    
    foreach($data as $line){
        fputcsv($fp, $line);
    }

    fclose($fp);
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
