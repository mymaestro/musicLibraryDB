<?php
require_once("includes/config.php");
echo '
    <nav class="navbar navbar-expand-sm navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="'.ORGLOGO.'" alt="'.ORGNAME.'" width="23" height="32"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTop" aria-controls="navbarTop" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTop">
            <ul class="navbar-nav mr-auto mb-2 mb-sm-0">
                <li class="nav-item' . ( PAGE_NAME === 'home' ? ' active">' : '">') . '
                    <a class="nav-link text-uppercase" href="index.php"><i class="fa fa-home"></i> Home</a>
                </li>
                <li class="nav-item' . ( PAGE_NAME === 'about' ? ' active">' : '">') . '
                    <a class="nav-link text-uppercase" href="about.php"><i class="fas fa-info-circle"></i> About</a>
                </li>
                <li class="nav-item' . ( PAGE_NAME === 'enter' ? ' active">' : '">') . '
                    <a class="nav-link text-uppercase" href="enter_menu.php"><i class="fas fa-id-card"></i> Enter</a>
                </li>
                <li class="nav-item' . ( PAGE_NAME === 'search' ? ' active">' : '">') . '
                    <a class="nav-link text-uppercase" href="search.php"><i class="fas fa-search"></i> Search</a>
                </li>
                <li class="nav-item' . ( PAGE_NAME === 'report' ? ' active">' : '">') . '
                    <a class="nav-link text-uppercase" href="reports.php"><i class="fas fa-chart-area"></i> Reports</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown1" data-bs-toggle="dropdown" aria-expanded="false">MATERIALS</a>
                    <ul class="dropdown-menu" aria-labelledby="dropdown1">
                    <li><a class="dropdown-item" href="list_compositions.php">Compositions</a></li>
                    <li><a class="dropdown-item" href="list_parts.php">Parts</a></li>
                    <li><a class="dropdown-item" href="list_ensembles.php">Ensembles</a></li>
                    <li><a class="dropdown-item" href="list_genres.php">Genres</a></li>
                    <li><a class="dropdown-item" href="list_parttypes.php">Part types</a></li>
                    <li><a class="dropdown-item" href="list_partcollections.php">Part type collections</a></li>
                    <li><a class="dropdown-item" href="list_papersizes.php">Paper sizes</a></li>
                    </ul>
              </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">';
    if (isset($_SESSION['username'])) {
        echo '<li class="nav-item"><a href="logout.php"><i class="fas fa-unlock"></i></a>' . $_SESSION['username'] . '@';
    } else {
        echo '<li class="nav-item">
             <a href="login.php"><i class="fas fa-lock"></i></a>';
    }
    echo $_SERVER['REMOTE_ADDR'] .'</li>
          </ul>
        </div>
    </div>
    </nav>
    ';
?>
