<?php
  define('PAGE_TITLE', 'Reports about the music library');
  define('PAGE_NAME', 'reports');
  require_once("includes/header.php");
  session_start();
  $u_admin = FALSE;
  $u_user = FALSE;
  if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $u_admin = (strpos(htmlspecialchars($_SESSION['roles']), 'administrator') !== FALSE ? TRUE : FALSE);
    $u_user = (strpos(htmlspecialchars($_SESSION['roles']), 'user') !== FALSE ? TRUE : FALSE);
  }
?>
<body>
<?php
  require_once("includes/navbar.php");
  require_once("includes/config.php");
?>
<br />
<div class="container">
  <h1>Music Library Reports</h1>
  <p>This part is still under construction</p> 
</div>
</main>

<?php
  require_once("includes/footer.php");
?>
