<?php
  define('PAGE_TITLE', 'About the music library');
  define('PAGE_NAME', 'about');
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
  <div class="container">
    <div class="row pb-3 pt-5 border-bottom"><h1>About the Music Library</h1></div>
      <div class="row pt-3">
      <p>The music library is an application you can use to keep track of the sheet music in your library. While intended for full-size concert bands, brass bands, wind ensembles, and orchestras, the music database can be tailored to fit the complexity of any size library.
      <h1>Music library access requirements</h1>
      <p>This application uses responsive front-end designs built on <a href="https://getbootstrap.com/">Bootstrap</a>.</p>
      <div class="bd-callout bd-callout-info">
        <blockquote>The most current, and the three previously released versions of Chrome, Edge, and Firefox, are supported.
        A secure connection using TLS v1.1 or v1.2, which the above browsers include by default, is required.
        </blockquote>
      </div>
      <h3>Pages</h3>
      <p>These are the pages you can find in this application:</p>
      <h4>Main pages</h4>
      <dl>
        <dt>Home</dt>
          <dd>The Music Library <a href="index.php">Home page</a> contains the organization title and links to the three main pages of the application: <a href="#search.php">Search</a>, <a href="#enter_menu.php">Enter</a>, and <a href="#reports.php">Reports</a>. At the bottom of the home page, you see a randomly selected title and composer of a piece from the library.</dd>
        <dt><a name="search.php">Search</a></dt>
          <dd>On the <a href="search.php">Search</a> page, you can enter text queries to find compositions in the library.</dd>
        <dt><a name="enter_menu.php">Enter</a></dt>
          <dd>The <a href="enter_menu.php">Enter</a> page provides a menu of links to other pages where you can list and input library data</dd>
      </dl>
      <h4>List/entry pages</h4>
      <dl>
        <dt>Compositions</dt>
        <dd>On the <a href="compositions.php">Compositions</a> page, you see a list of all the compositions in the library. From the list, you can search 
      </dl>
      <h3>Database tables</h3>
      <p>These are the tables that are used in the music library database.
        <dl>
          <dt>Compositions</dt>
            <dd>Work with compositions in the music library. This table holds the data about the music in the library. You find here the title, composer, arranger, publish date, etc.</dd>
          <dt>Ensembles</dt>
            <dd>Work with ensembles. Bands and smaller ensembles</dd>
          <dt>Genres</dt>
            <dd>Work with genres. Types of music genre such as "March" or "Symphonic transcription" or "Showtune"</dd>
          <dt>Part types</dt>
            <dd>Work with types of parts. Examples are Flute 1 or Tuba</dd>
          <dt>Part type collections</dt>
            <dd>Work with types of parts that are collections. A "collection" part type contains two or more instruments on one part. For example, "percussion 1" contains "Cymbal" and "Bass drum"</dd>
          <dt>Paper sizes</dt>
            <dd>Work with sizes of parts. This is a lookup table for which size of paper the parts are printed, for example Folio, march or book</dd>
          <dt>Recordings</dt>
            <dd>A catalog of performance recordings of each composition</dd>
          <dt>Users</dt>
            <dd>Users who can access the database, with username/password and role permissions. Roles are "administrator", "user" or both.</dd>
        </dl>
      </p>
      <p>Go check out the Wind Repertory Project at https://www.windrep.org/</p>
    </div>
  </div>
</main>
<?php require_once("includes/footer.php");?>
</body>
</html>
