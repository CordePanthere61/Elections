<nav class="navbar navbar-expand-lg navbar-light bg-secondary">
    <div class="container-fluid px-5 text-white">
        <!--            *****LOGO*******-->
        <a class="navbar-brand text-light fs-1 passion-one" id="main-title" href="#">Elections</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse fs-5 navbar-collapse ms-3" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-light fw-bold" aria-current="page" href="home.php">Accueil</a>
                </li>
                <?php if ($_SESSION['is_admin']) { ?>
                    <li class="nav-item">
                        <a class="nav-link text-light fw-bold" href="createPoll.php">Créer un sondage</a>
                    </li>
                <?php } ?>
            </ul>
            <a class="position-absolute px-5 end-0 text-light ml-100 fs-2 h-auto" id="logout-button" href="logout.php"><i class="fa fa-power-off"></i></a>
        </div>
    </div>
</nav>