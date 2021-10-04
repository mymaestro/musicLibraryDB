<?php
  session_start();
  require_once('includes/config.php'); 
  define('PAGE_TITLE',  ORGDESC . ' 
  Music Library');
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
?>
<br />
<main role="main" class="container">
	<div class="jumbotron">
		<h1 class="display-4"><?php echo ORGDESC ?></h1>
		<p class="lead">Music Library</p>
		<br />
		<br />
		<div class="card-group">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Search</h5>
					<p class="card-text">Find a piece of music.</br>See what's in the library.</p>
					<p class="card-text"><small class="text-muted">No logon required</small></p>
					<a href="search.php" class="btn btn-sm btn-primary">Search</a>
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
	</div>
</main>
<?php
  require_once("includes/footer.php");
?>
