<?php
// Include config file
define('PAGE_TITLE', 'Welcome');
define('PAGE_NAME', 'welcome');
require_once('includes/header.php');
require_once('includes/config.php');
require_once('includes/functions.php');
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: ./login.php");
  exit;
}
require_once("includes/navbar.php");
?>
<main>
  <div class="text-center page-header">
    <br />
    <h1>Hi, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>. Welcome to our site.</h1>
    <p>You have the role(s) <b><?php echo htmlspecialchars($_SESSION['roles']); ?></b>. Use wisely.</p>
  </div>
  <div class="text-center">
    <p><a href="logout.php" class="btn btn-danger">Sign out of your account</a></p>
    <p>To sign out later, click the lock icon <i class="fas fa-unlock"></i> in the upper left.</p>
  </div>
</main>
<?php require_once("includes/footer.php");?>
</body>
</html>
