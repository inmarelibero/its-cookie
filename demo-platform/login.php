<?php 
require_once('init.php');

if ($_SERVER['REQUEST_METHOD'] ==='POST') {   // per controllare se la richiesta è stata inviata in post
    $loginResult = null;
    
    try{
        $loginResult = tryLogin($_POST['email'], $_POST['password']);
    } catch(Exception $exception){
        $error = $exception->getMessage();
    }

    if($loginResult == true){
        header("Location: homepage.php");
        exit();
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
            <?php if(isset($error)): ?>
                <p style="color:red">
                    <?php echo $error ?>
                </p>
            <?php endif ?>
            
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
