<nav class="navbar navbar-expand-lg bg-body-tertiary mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="homepage.php">HOME</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="chi-siamo.php">CHI SIAMO</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="contattaci.php">CONTATTACI</a>
                </li>

                <?php if (isUserAuthenticated()): ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="logout.php">
                            Sei loggato come <?php echo getEmailOfAuthenticatedUser(); ?> (LOGOUT)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="change-password.php">CAMBIA PASSWORD</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="login.php">LOGIN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="register.php">REGISTRATI</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
