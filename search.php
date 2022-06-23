<?php
  define('PAGE_TITLE', 'Search the music library');
  define('PAGE_NAME', 'search');
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
  require_once("includes/functions.php");
?>
<main role="main">
  <div class="container">
    <div class="row align-items-start">
      <div class="col">
        <h1>Browse the music library</h1>
        <p>These are the tables that are used in the music library database.</p>
        <dl>
          <dt><a href="compositions.php">Compositions</a></dt>
            <dd>Browse the compositions in the music library. This table holds the data about the music in the library. You find here the title, composer, arranger, publish date, etc.</dd>
          <dt><a href="parts.php">Parts</a></dt>
            <dd>Instrument parts in the library</dd>
          <dt><a href="ensembles.php">Ensembles</a></dt>
            <dd>List ensembles. Bands and smaller ensembles</dd>
          <dt><a href="genres.php">Genres</a></dt>
            <dd>Search genres. Types of music genre such as "March" or "Symphonic transcription" or "Showtune"</dd>
          <dt><a href="parttypes.php">Part types</a></dt>
            <dd>Search types of parts. Examples are Flute 1 or Tuba</dd>
          <dt><a href="partcollections.php">Part type collections</a></dt>
            <dd>Search types of parts that are collections. A "collection" part type contains two or more instruments on one part. For example, "percussion 1" contains "Cymbal" and "Bass drum"</dd>
          <dt><a href="papersizes.php">Paper sizes</a></dt>
            <dd>Search sizes of parts. This is a lookup table for which size of paper the parts are printed, for example Folio, march or book</dd>
          <dt><a href="recordings.php">Recordings</a></dt>
            <dd>A catalog of performance recordings of each composition</dd>
          <dt><?php
          if($u_admin) {
            echo '<a href="users.php">Users</a>';
          } else {
            echo 'Users';
          } ?></dt>
            <dd>Users who can access the database, with username/password and role permissions. Roles are "administrator", "librarian", and "user".</dd>
        </dl>
      </div><!-- col -->
      <div class="col">
        <h1>Search compositions</h1>
        <div id="search_form">
          <form action="compositions.php" method="POST">
            <div class="row g-3 align-items-center">
              <div class="col-auto">
                <button type="submit" name="submitButton" class="btn btn-primary">Search</button>
              </div>
              <div class="col-auto">
                <input type="text" id="search" name="search" class="form-control" aria-describedby="searchHelp">
              </div>
              <div class="col-auto">
                <span id="searchHelp" class="form-text">
                  Search the name, description, composer, arranger, and comments
                </span>
              </div>
            </div>
          </form>
        </div><!-- search_form -->
        <div class="row">
          <div class="col-auto">
            <h4>Ensembles</h4>
              <form action="compositions.php" method="POST">
<?php
        $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $sql = "SELECT id_ensemble, name FROM ensembles WHERE enabled = 1 ORDER BY name;";
        $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
        while ($rowList = mysqli_fetch_array($res)) {
           $id_ensemble = $rowList['id_ensemble'];
           $title = $rowList['name'];
           echo '              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="'.$id_ensemble.'">
                <label class="form-check-label" for="'.$id_ensemble.'">
                  '.$title.'
                </label>
              </div>
';
        }
        mysqli_close($f_link);
        ferror_log("returned: " . $sql);
        echo '              </form>
';
?>
          </div>
          <div class="col-auto">
<?php
          echo '            <h4>Genre</h4>
                <form action="compositions.php" method="POST">';
          $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
          $sql = "SELECT id_genre, name FROM genres WHERE enabled = 1 ORDER BY name;";
          $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
          while ($rowList = mysqli_fetch_array($res)) {
              $id_genre = $rowList['id_genre'];
              $name = $rowList['name'];
              echo '
                   <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="'.$id_genre.'">
                      <label class="form-check-label" for="'.$id_genre.'">
                        '.$name.'
                      </label>
                    </div>';
          }
          mysqli_close($f_link);
          ferror_log("returned: " . $sql);
          echo '
                </form>
';
?>
        </div><!-- col-auto -->
        </div><!-- row -->
      </div><!-- col -->
    </div><!-- row -->
  </div><!-- CONTAINER -->
</main>
<?php require_once("includes/footer.php");?>
</body>
</html>