<?php
  define('PAGE_TITLE', 'About the music library');
  define('PAGE_NAME', 'about');
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
  <h1>About the Music Library</h1>
  <h3>Tables</h3>
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
  <h1>Music Library access requirements</h1>
  <p>On this page, you can find the minimum requirements that are needed to effectively use the library.</p>
  <h3>Operating Systems</h3>
  <p>You can access the environment from any operating system that supports any of the following browsers. This includes most versions of Microsoft Windows, Apple OS X, macOS, and most major Linux distributions.</p>
  <h3>Browsers</h3>
  <p>You must run a modern web browser that supports WebSocket technology. This includes:</p>
  <ul>
    <li>Google Chrome</li>
    <li>Microsoft Edge (Windows 10 only)</li>
    <li>Mozilla Firefox</li>
    <li>Microsoft Internet Explorer 11</li>
    <li>Apple Safari</li>
  </ul>
  <div class="bd-callout bd-callout-info">
    <h5>Notes</h5>
    <blockquote>The most current, and the three previously released versions of Chrome, Edge, and Firefox, are supported.
    A secure connection using TLS v1.1 or v1.2, which the above browsers include by default, is required.
    Internet Explorer in compatibility view is not supported. For more information about disabling compatibility view, see the Microsoft article: Fix site display problems with Compatibility View.
    Because Chrome supports the WebP image format, Chrome users should see a significant reduction in bandwidth usage when accessing VMs with the browser client.
    </blockquote>
  </div>
</div>
</main>

<?php
  require_once("includes/footer.php");
?>
