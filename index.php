<?php
  define('PAGE_TITLE','Music Library');
  define('PAGE_NAME', 'home');
  require_once("includes/header.php");
  $u_admin = FALSE;
  $u_librarian = FALSE;
  $u_user = FALSE;
  if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $u_admin = (strpos(htmlspecialchars($_SESSION['roles']), 'administrator') !== FALSE ? TRUE : FALSE);
	$u_librarian = (strpos(htmlspecialchars($_SESSION['roles']), 'librarian') !== FALSE ? TRUE : FALSE);
    $u_user = (strpos(htmlspecialchars($_SESSION['roles']), 'user') !== FALSE ? TRUE : FALSE);
  }
  $configFile = 'includes/config.php';
  if (!file_exists($configFile)) {
	echo "<div class='alert alert-danger'>Error: failed to read required config.php. Did you create it yet?</div>
	</body>
</html>";
	exit; // we are done here
  } else {
	require_once($configFile);
  };

  require_once("includes/navbar.php");
  require_once('includes/functions.php');
  ferror_log("RUNNING index.php");
?>
<main role="main" class="container">
	<div class="px-4 py-5 my-5 text-center align-items-center rounded-3 border shadow-lg"> <img class="d-block mx-auto mb-4" src="<?php echo ORGLOGO ?>" alt="<?php echo ORGDESC ?>" height="256">
		<h1 class="display-5 fw-bold text-body-emphasis"><?php echo ORGDESC ?></h1>
		<div class="col-lg-6 mx-auto">
			<p class="lead mb-4">The <strong>music library</strong> is an application you can use to keep track of the sheet music in your library. While intended for full-size concert bands, brass bands, wind ensembles, and orchestras, the music database can be tailored to fit the complexity of any size library. </p>
			<div class="d-grid gap-2 d-sm-flex justify-content-sm-center"> <a href="home.php" class="btn btn-primary btn-lg px-4 gap-3">Home</a> <a
					href="about.php" class="btn btn-outline-secondary btn-lg px-4">About</a> </div>
		</div>
	</div>
	<div>
		<div class="card-group">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Search</h5>
					<p class="card-text">Find a piece of music.</br>See what's in the library.</p>
					<p class="card-text"><small class="text-muted">No logon required</small></p>
					<form action="compositions.php" method="POST">
						<div class="input-group">
								<button type="submit" name="submitButton" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
								<input type="search" id="search" name="search" placeholder="Search compositions">
						</div>
					</form>
					<!--<a href="search.php" class="btn btn-sm btn-primary">Search page</a>-->
				</div>
			</div>
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Enter</h5>
					<p class="card-text">Provide information about the music in the library.</p>
					<p class="card-text"><small class="text-muted">Requires user logon.</small></p>
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
		require_once('includes/functions.php');
		$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		$sql = "SELECT name, composer FROM compositions ORDER BY RAND() LIMIT 1;";
		$res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
		while ($rowList = mysqli_fetch_array($res)) {
			$name = $rowList['name'];
			$composer = $rowList['composer'];
			echo "<p>Today's pick: <strong><em>".$name.'</em></strong> by '.$composer.'</p>';
		}?>
	</div>
</main>
<?php require_once("includes/footer.php");?>
</body>
</html>