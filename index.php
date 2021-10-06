<?php
  session_start();
  require_once('includes/config.php'); 
  define('PAGE_TITLE',  ORGDESC . ' Music Library');
  define('PAGE_NAME', 'home');
  require_once("includes/header.php");
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
  require_once('includes/config.php');
  require_once('includes/functions.php');
  $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
?>
<br />
<main role="main" class="container">
	<div class="jumbotron">
		<h1 class="display-4"><?php echo ORGDESC ?></h1>
		<p class="lead">Music Library</p>
		<br />
		<div class="card-group">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Search</h5>
					<p class="card-text">Find a piece of music.</br>See what's in the library.</p>
					<p class="card-text"><small class="text-muted">No logon required</small></p>
					<a href="search.php" class="btn btn-sm btn-primary">Search page</a>
				</div>
			</div>
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Enter</h5>
					<p class="card-text">Provide information about the music in the library.</p>
					<p class="card-text"><small class="text-muted">Requires administrator logon.</small></p>
					<a href="enter_menu.php" class="btn btn-sm btn-primary">New</a>
				</div>
			</div>
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Reports</h5>
					<p class="card-text">Generate some reports about what's in the library.</p>
					<p class="card-text"><small class="text-muted">Answer common questions</small></p>
					<a href="reports.php" class="btn btn-sm btn-primary">Reports</a>
				</div>
			</div>

		</div>
		<br />
		<?php
		 $sql = "SELECT name, composer FROM compositions ORDER BY RAND() LIMIT 1;";
		 $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
		 while ($rowList = mysqli_fetch_array($res)) {
			 $name = $rowList['name'];
			 $composer = $rowList['composer'];
			 echo "<p>Today's pick: <strong><em>".$name.'</em></strong> by '.$composer.'</p>';
		 } ?>
	</div>
</main>
<?php
  require_once("includes/footer.php");
?>
