<?php 
require_once('init.php');

if ($_SERVER['REQUEST_METHOD'] ==='POST') {
    // leggo i valori inviati dal form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // itero sugli utenti
    $csvFile = file('users.csv');
    $data = [];
    foreach ($csvFile as $line) {
        $data[] = str_getcsv($line);
    }
    foreach($data as $credentials){
        $credentialEmail = $credentials[0];
        $credentialPassword = $credentials[1];
        if ($email === $credentialEmail && $password === $credentialPassword){
            $_SESSION['email'] = $email;//utente autenticato
            header("Location: homepage.php");
            exit();
        }
    }
}

?>

<html>



    <head>
        <?php require_once('head.php'); ?>
    </head>
    <body>
        <?php require_once('menu.php'); ?>

        <form action="login.php" method="post">
            <h1>LOGIN</h1>
            
            <p>
                <label>email</label>
                <input type="text" name="email">
            </p>
            
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
