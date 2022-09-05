<?php
  define('PAGE_TITLE', 'Enter');
  define('PAGE_NAME', 'enter');
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
  require_once("includes/config.php");
  require_once("includes/navbar.php");
?>
<main role="main" class="container">
	<div class="jumbotron">
		<h2 class="display-4">Enter library materials</h2>
		<p class="lead">Music Library</p>
		<br />
		<div class="card-group">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Compositions</h5>
					<p class="card-text">Work with compositions in the music library.</p>
				</div>
				<div class="card-footer">
					<a href="compositions.php" class="card-link">Compositions</a>
				</div>
			</div>
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Parts</h5>
					<p class="card-text">Work with instrument parts.</p>
				</div>
				<div class="card-footer">
					<a href="parts.php" class="card-link">Parts</a>
				</div>
			</div>
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Instruments</h5>
					<p class="card-text">Work with instruments.</p>
				</div>
				<div class="card-footer">
					<a href="instruments.php" class="card-link">Instruments</a>
				</div>
			</div>
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Recordings</h5>
					<p class="card-text">Work with recordings.</p>
				</div>
				<div class="card-footer">
					<a href="recordings.php" class="card-link">Recordings</a>
				</div>
			</div>
		</div>
		<br />
		<div class="card-group">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Ensembles</h5>
					<p class="card-text">Work with ensembles.</p>
					<p class="card-text"><small class="text-muted">Bands and smaller ensembles</small></p>
				</div>
				<div class="card-footer">
					<a href="ensembles.php" class="card-link">Ensembles</a>
				</div>
			</div>
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Genres</h5>
					<p class="card-text">Work with genres.</p>
					<p class="card-text"><small class="text-muted">Types of music genre.</small></p>
				</div>
				<div class="card-footer">
					<a href="genres.php" class="card-link">Genres</a>
				</div>
			</div>
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Part types</h5>
					<p class="card-text">Work with types of parts.</p>
					<p class="card-text"><small class="text-muted">Flute 1 or Tuba</small></p>
				</div>
				<div class="card-footer">
					<a href="parttypes.php" class="card-link">Part types</a>
				</div>
			</div>
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Part type collections</h5>
					<p class="card-text">Work with instruments that are on parts.</p>
					<p class="card-text"><small class="text-muted">Percussion 1 or Horn 1 & 2</small></p>
				</div>
				<div class="card-footer">
					<a href="partcollections.php" class="card-link">Collections</a>
				</div>
			</div>
		    <div class="card">
				<div class="card-body">
					<h5 class="card-title">Paper sizes</h5>
					<p class="card-text">Work with sizes of parts.</p>
					<p class="card-text"><small class="text-muted">Folio, march or book</small></p>
				</div>
				<div class="card-footer">
					<a href="papersizes.php" class="card-link">Part paper sizes</a>
				</div>
			</div>
		</div>
	</div>
</main>
<?php require_once("includes/footer.php");?>
</body>
</html>