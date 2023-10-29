<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/homepage.php">
                        Homepage
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/contattaci.php">
                        Contattaci
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/chi-siamo.php">
                        Chi siamo
                    </a>
                </li>

                <?php if ($authenticationManager->isUserAuthenticated()): ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/admin/users/index.php">
                            UTENTI
                        </a>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <?php if (!$authenticationManager->isUserAuthenticated()): ?>
                        <a class="nav-link active" aria-current="page" href="/login.php">
                            Login
                        </a>
                    <?php endif; ?>
                    <?php if ($authenticationManager->isUserAuthenticated()): ?>
                        <a class="nav-link active" aria-current="page" href="/logout.php">
                            Loggato come <?php echo $authenticationManager->getAuthenticatedUser()->getEmail(); ?> (LOGOUT)
                        </a>
                    <?php endif; ?>
                </li>

                <?php if (!$authenticationManager->isUserAuthenticated()): ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/registration.php">
                            Registrati
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>