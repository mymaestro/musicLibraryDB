<?php
  define('PAGE_TITLE', 'Search the music library');
  define('PAGE_NAME', 'search');
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
  <h1>Search the Music Library</h1>
  <h3>Tables</h3>
  <strong>This part is still under construction</strong>
  <p>These are the tables that are used in the music library database.
    <dl>
      <dt>Compositions</dt>
        <dd>Search compositions in the music library. This table holds the data about the music in the library. You find here the title, composer, arranger, publish date, etc.</dd>
        <form method="POST">
          <input type="TEXT" name="search" />
          <input type="SUBMIT" name="submit" value="Search" />
        </form>
      <dt>Ensembles</dt>
        <dd>Search ensembles. Bands and smaller ensembles</dd>
      <dt>Genres</dt>
        <dd>Search genres. Types of music genre such as "March" or "Symphonic transcription" or "Showtune"</dd>
      <dt>Part types</dt>
        <dd>Search types of parts. Examples are Flute 1 or Tuba</dd>
      <dt>Part type collections</dt>
        <dd>Search types of parts that are collections. A "collection" part type contains two or more instruments on one part. For example, "percussion 1" contains "Cymbal" and "Bass drum"</dd>
      <dt>Paper sizes</dt>
        <dd>Search sizes of parts. This is a lookup table for which size of paper the parts are printed, for example Folio, march or book</dd>
      <dt>Recordings</dt>
        <dd>A catalog of performance recordings of each composition</dd>
      <dt>Users</dt>
        <dd>Users who can access the database, with username/password and role permissions. Roles are "administrator", "user" or both.</dd>
    </dl>
  </p>
  
</div>
</main>

<?php
  require_once("includes/footer.php");
?>
