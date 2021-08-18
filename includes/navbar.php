<?php
require_once("includes/config.php");
echo '
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#"><img src="images/logo_23x32.png" alt="ACWE" width="23" height="32"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTop" aria-controls="navbarTop" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse collapse" id="navbarTop">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item' . ( PAGE_NAME === 'home' ? ' active">' : '">') . '
                    <a class="nav-link text-uppercase" href="#"><i class="fa fa-home"></i> Home</a>
                </li>
                <li class="nav-item' . ( PAGE_NAME === 'about' ? ' active">' : '">') . '
                    <a class="nav-link text-uppercase" href="about.php"><i class="fas fa-info-circle"></i> About</a>
                </li>
                <li class="nav-item' . ( PAGE_NAME === 'search' ? ' active">' : '">') . '
                    <a class="nav-link text-uppercase" href="search.php"><i class="fas fa-search"></i> Search</a>
                </li>
                <li class="nav-item' . ( PAGE_NAME === 'enter' ? ' active">' : '">') . '
                    <a class="nav-link text-uppercase" href="enter_menu.php"><i class="fas fa-id-card"></i> Enter</a>
                </li>
                <li class="nav-item' . ( PAGE_NAME === 'report' ? ' active">' : '">') . '
                    <a class="nav-link text-uppercase" href="reports.php"><i class="fas fa-chart-area"></i> Reports</a>
                </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">';
    if (isset($username)) {
        echo '<li class="nav-item"><a href="logout.php"><i class="fas fa-unlock"></i></a>' . $username . '@';
    } else {
        echo '<li class="nav-item">
             <a href="login.php"><i class="fas fa-lock"></i></a>';
    }
    echo $_SERVER['REMOTE_ADDR'] . ' ' . constant("REGION") .'</li>
          </ul>
        </div>
    </nav>
    ';
?>
