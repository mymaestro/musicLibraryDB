<header>
    <nav class="navbar navbar-expand-lg fixed-top bg-body-tertiary" aria-label="Main navigation">
        <div class="container-xl">
            <a class="navbar-brand" href="/#"><img src="<?php echo ORGLOGO ?>" alt="<?php echo ORGNAME ?>" height="32"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTop" aria-controls="navbarTop" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTop">
                <ul class="navbar-nav nav-underline me-auto mb-2 mb-lg-0">
                    <li class="nav-item<?php echo ( PAGE_NAME === 'home' ? ' active">' : '">') ?><a class="nav-link text-uppercase" href="index.php"><i class="fa fa-home"></i> Home</a></li>
                    <li class="nav-item<?php echo ( PAGE_NAME === 'Dashboard' ? ' active">' : '">') ?><a class="nav-link text-uppercase" href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li class="nav-item<?php echo ( PAGE_NAME === 'enter' ? ' active">' : '">') ?><a class="nav-link text-uppercase" href="enter_menu.php"><i class="fas fa-id-card"></i> Enter</a></li>
                    <li class="nav-item<?php echo ( PAGE_NAME === 'search' ? ' active">' : '">') ?><a class="nav-link text-uppercase" href="search.php"><i class="fas fa-search"></i> Search</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="nav_menu_dropdown" data-bs-toggle="dropdown" aria-expanded="false">MATERIALS</a>
                        <ul class="dropdown-menu" aria-labelledby="nav_menu_dropdown">
                        <li><a class="dropdown-item" href="compositions.php">Compositions</a></li>
                        <li><a class="dropdown-item" href="concerts.php">Concerts</a></li>
                        <li><a class="dropdown-item" href="parts.php">Parts</a></li>
                        <li><a class="dropdown-item" href="recordings.php">Recordings</a></li>
                        <li><a class="dropdown-item" href="reports.php">Reports</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="ensembles.php">Ensembles</a></li>
                        <li><a class="dropdown-item" href="instruments.php">Instruments</a></li>
                        <li><a class="dropdown-item" href="genres.php">Genres</a></li>
                        <li><a class="dropdown-item" href="papersizes.php">Paper sizes</a></li>
                        <li><a class="dropdown-item" href="parttypes.php">Part types</a></li><?php if (isset($_SESSION['username'])) if (strpos(htmlspecialchars($_SESSION['roles']), 'librarian') !== FALSE ) echo '
                        <li><a class="dropdown-item" href="playgrams.php">Playgrams</a></li>
                        <li><a class="dropdown-item" href="sections.php">Sections</a></li>
'; ?>
<?php if (isset($_SESSION['username'])) if (strpos(htmlspecialchars($_SESSION['roles']), 'librarian') !== FALSE ) echo '
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="enable_disable_manager.php"><i class="fas fa-toggle-on"></i> Enable/Disable Manager</a></li>
'; ?><?php if (isset($_SESSION['username'])) if (strpos(htmlspecialchars($_SESSION['roles']), 'administrator') !== FALSE ) echo '
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="admin_verifications.php">Password reset & email verification</a></li>
                        <li><a class="dropdown-item" href="users.php">Users</a></li>
'; ?>
                        </ul>

                </li>
            </ul>
            <p class="nav navbar-right">
                <?php if (isset($_SESSION['username'])) {
            echo '<a href="logout.php"><i class="fas fa-unlock"></i>' . $_SESSION['username'];
        } else {
            echo '<a href="login.php"><i class="fas fa-lock"></i>';
        } ?></a></p>
            </div>
        </div>
    </nav>
</header>
