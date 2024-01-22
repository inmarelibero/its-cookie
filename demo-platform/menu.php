<ul>
    <li>
        <a href="homepage.php">
            HOME
        </a>
    </li>
    <li>
        <a href="chi-siamo.php">
            CHI SIAMO
        </a>
    </li>
    <li>
        <a href="contattaci.php">
            CONTATTACI
        </a>
    </li>
    
    <?php if (isUserAuthenticated()): ?>
        <li>
            Sei loggato come <?php echo getEmailOfAuthenticatedUser(); ?>
        </li>
        <li>
            <a href="logout.php">
                LOGOUT
            </a>
        </li>
    <?php else: ?>
        <li>
            <a href="login.php">
                LOGIN
            </a>
        </li>
    <?php endif; ?>
</ul>   