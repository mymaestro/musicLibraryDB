<?php
  define('PAGE_TITLE', 'About us');
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
  <h1>ACWE Music Library access requirements</h1>
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
  <h3>Port Ranges and IP Addresses</h3>
  <p>To access the web interface, you need direct access to the HTTPS/SSL port (TCP/IP port 443) at <strong><?php echo(PROXY_SERVER); ?></strong>. Test access <a href="https://<?php echo(PROXY_SERVER); ?>">here</a>.</p>
  <p>Contact your network administrator if you don't have access to these sites. Some services may require additional open ports.</p>
  <h3>Bandwidth</h3>
  <p>Minimum download speed of 1.2 Mbps for each concurrent browser session with a VM.</p>
  <p>For example, if there are 15 users, each using the browser client from the same physical location at the same time, the minimum recommended amount of bandwidth is 18Mbit/s (1.2 Mbps for each concurrent browser session with a VM x 15 sessions).</p>
  <div class="bd-callout bd-callout-warning">
    <h4>Notes</h4>
    <blockquote>To estimate the bandwidth of your connection, see Testing bandwidth and latency with Speedtest.
    Actual bandwidth consumption may depend on how you use your VMs. For example, working within a command line interface requires fewer network resources, but using Flash and video requires much more bandwidth than the minimums recommended above.
    More connections to the same VM cause slower performance for each user. We recommend no more than 10 simultaneous browser client sessions per VM.
    </blockquote>
  </div>
  <h3>Latency</h3>
  <p>Latency of 150ms or less is strongly recommended. Latencies above 250ms may not provide acceptable performance.</p>
  <h3>Test your connection</h3>
  <p>Connect to <a href="/speedtest">this page</a> to test the bandwidth and latency to our servers.</p>
  <a href="/speedtest"><img src="/images/speedtest.png" class="img-fluid" alt="Speed test result"></a>
</div>
</main>

<?php
  require_once("includes/footer.php");
?>
