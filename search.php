<?php
  define('PAGE_TITLE', 'Search the music library');
  define('PAGE_NAME', 'search');
  require_once("includes/header.php");
  $u_admin = FALSE;
  $u_user = FALSE;
  if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $u_admin = (strpos(htmlspecialchars($_SESSION['roles']), 'administrator') !== FALSE ? TRUE : FALSE);
    $u_user = (strpos(htmlspecialchars($_SESSION['roles']), 'user') !== FALSE ? TRUE : FALSE);
  }
  require_once("includes/config.php");
  require_once("includes/navbar.php");
?>
<main role="main" class="container">
  <div class="container">
    <h1>Search the Music Library</h1>
    <h3>Tables</h3>
    <strong>This part is still under construction</strong>
    <p>These are the tables that are used in the music library database.
      <dl>
        <dt>Compositions</dt>
          <dd>Search compositions in the music library. This table holds the data about the music in the library. You find here the title, composer, arranger, publish date, etc.</dd>
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
          </div>
        <dt><a href="ensembles.php">Ensembles</a></dt>
          <dd>List ensembles. Bands and smaller ensembles</dd>
        <dt><a href="genres.php">Genres</a></dt>
          <dd>Search genres. Types of music genre such as "March" or "Symphonic transcription" or "Showtune"</dd>
        <dt><a href="parttypes.php">Part types</a></dt>
          <dd>Search types of parts. Examples are Flute 1 or Tuba</dd>
        <dt><a href="partcollections.php">Part type collections</a></dt>
          <dd>Search types of parts that are collections. A "collection" part type contains two or more instruments on one part. For example, "percussion 1" contains "Cymbal" and "Bass drum"</dd>
        <dt><a href="list_papersizes.php">Paper sizes</a></dt>
          <dd>Search sizes of parts. This is a lookup table for which size of paper the parts are printed, for example Folio, march or book</dd>
        <dt>Recordings</dt>
          <dd>A catalog of performance recordings of each composition</dd>
        <dt>Users</dt>
          <dd>Users who can access the database, with username/password and role permissions. Roles are "administrator", "user" or both.</dd>
      </dl>
    </p>
  </div>
</main>
<?php require_once("includes/footer.php");?>
</body>
</html>
