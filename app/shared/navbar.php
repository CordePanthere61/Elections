<nav class="navbar navbar-expand-lg navbar-light bg-secondary">
    <div class="container-fluid px-5 text-white w-75 mx-auto">
        <!--            *****LOGO*******-->
        <a class="navbar-brand text-dark fs-1 passion-one" href="#">Elections</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse ms-3" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-dark fw-bold" aria-current="page" href="home.php">Accueil</a>
                </li>
                <?php if ($_SESSION['is_admin']) { ?>
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-bold" href="createPoll.php">Créer un sondage</a>
                    </li>
                <?php } ?>
            </ul>
            <a class="position-absolute px-5 end-0 text-dark ml-100 fs-1 h-auto" href="logout.php"><i class="fa fa-sign-out-alt"></i></a>
        </div>
    </div>
</nav>