<?php
  define('PAGE_TITLE', 'Add classroom images');
  define('PAGE_NAME', 'Add_classroom_images');
  require_once('includes/config.php');
  require_once('includes/functions.php');
  require_once("includes/header.php");
  session_start();
  $u_admin = FALSE;
  $u_user = FALSE;
  if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $u_admin = (strpos(htmlspecialchars($_SESSION['roles']), 'administrator') !== FALSE ? TRUE : FALSE);
    $u_user = (strpos(htmlspecialchars($_SESSION['roles']), 'user') !== FALSE ? TRUE : FALSE);
  }
  $output = '';
  $message = '';
  $timestamp = '';
  $ip = '';
  $host = '';
  $port = '';
  $token = '';
  $classid = '';
  $platform = '';
  $expires = '';
  if(!empty($_POST)) {
  	// connect to the database
  	$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    // timestamp:          Row created, auto-generated
    $timestamp = time();
    // ip:                 Address of the client browser that entered the form
    $ip = f_getIP();
    $host = mysqli_real_escape_string($f_link, $_POST['host']);
    $port = mysqli_real_escape_string($f_link, $_POST['port']);
    $token = mysqli_real_escape_string($f_link, $_POST['token']);
    $classid = mysqli_real_escape_string($f_link, $_POST['classid']);
    $platform = mysqli_real_escape_string($f_link, $_POST['platform']);
    $expires = mysqli_real_escape_string($f_link, $_POST['expires']);
    $created = date('Y-m-d H:i:s.u');
    $sql = "
    INSERT INTO vnc_targets(ip, timestamp, host, port, token, classid, platform, created, expires)
    VALUES('$ip', '$timestamp', '$host', '$port', '$token', '$classid', '$platform', '$created', '$expires');
    ";
    error_log("Insert SQL: " . $sql);
    $message = 'Data inserted';
    if($res = mysqli_query($f_link, $sql)) {
      $output .= '<label class="text-success">' . $message . '</label>';
      error_log("Row inserted.");
      /*
       * Write out the VNC targets file configuration for websockify
       */
      $sql= "SELECT token, host, port FROM vnc_targets WHERE  DATE(vnc_targets.expires) > CURDATE()";
      $res = mysqli_query($f_link, $sql);
      error_log("result: ". mysqli_num_rows($res) . " rows.");

      /* Preserve the existing configuration file */
      $vnc_targets_file = "/var/www/vncproxy/vnc_targets";
      if (is_file($vnc_targets_file)) {
        rename($vnc_targets_file, $vnc_targets_file . "_" . date('Ymd_His'));
        $vnc_targets_ini = fopen($vnc_targets_file, "w") or die("Unable to open vnc_targets"); 
        while($row = mysqli_fetch_array($res)) {
        	$foutput = $row["token"] . ': '. $row["host"] . ':' . $row["port"] . "\n";
        	fwrite($vnc_targets_ini, $foutput);
        }
        fclose($vnc_targets_ini);
      }
      if (isset($_POST["insert1"])) {
      	header("location: list_vnc_targets.php");
      }
    } else {
      $message = "Failed";
      $error_message = mysqli_error($f_link);
      $output .= '<p class="text-danger">' . $message . '. Error: ' . $error_message . '</p>
         ';
      $referred = $_SERVER['HTTP_REFERER'];
      $query = parse_url($referred, PHP_URL_QUERY);
      $referred = str_replace(array('?', $query), '', $referred);
      $output .= '<p><a href="'.$referred.'">Return</a></p>
         ';
      error_log("Error: " . $error_message);
    }

  }
?>
<body>
<?php
  require_once("includes/navbar.php");
?>
  <br />
  <div class="container">
    <img class="d-block mx-auto mb-4" src="images/main-logo.png" alt="" width="132" height="20">
    <h2 align="center">HCL classroom images</h2>
<?php if($u_admin) : ?>
    <br />
    <p class="lead" align="center">Token and host fields must be unique.</p>

    <div class="container-fluid">
    	<?php echo $output; ?>
      <form method="post" id="insert_form">
        <div class="row bg-light">
          <div class="col-md-2">
            <label for="token" class="col-form-label">Token*</label>
          </div>
          <div class="col-md-3">
            <input type="text" class="form-control" id="token" name="token" <?php echo (($token == '') ? 'placeholder="HCL123-001"' : 'value="' . $token . '"'); ?> required/>
          </div>
          <div class="col-md-2">
            <label for="host" class="col-form-label">Host : port*</label>
          </div>
          <div class="col-md-3">
            <input type="text" class="form-control" id="host" name="host" <?php echo (($host == '') ? 'placeholder="10.9.8.7"' : 'value="' . $host . '"'); ?> required/>
          </div>
          <div class="col-md-2">
            <input type="text" class="form-control" id="port" name="port" <?php echo (($port == '') ? 'placeholder="5900"' : 'value="' . $port . '"'); ?> required/>
          </div>
        </div><hr />
        <div class="row bg-light">
          <div class="col-md-2">
            <label for="classid" class="col-form-label">Course ID*</label>
          </div>
          <div class="col-md-10">
            <select class="form-control mb-3" id="classid" name="classid" required>
              <?php
              $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
              $sql = "SELECT id, course_code, title, product_categories FROM classes ORDER BY title;";
              $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error());
              while ($rowList = mysqli_fetch_array($res)) {
                $rowID = $rowList['id'];
                $courseCode = $rowList['course_code'];
                $courseTitle =  $rowList['title'];
                $products = $rowList['product_categories'];
                echo '<option value="'. $rowID . '"' . (($classid == $rowID) ? ' selected>' : '>') . $courseCode . ': '. $courseTitle . '</option>';
              }
              mysqli_close($f_link);
              error_log("Class list");
              ?>
            </select>
            <p class="text-info"><small>Select the course</small></p>
          </div>
        </div>

        <div class="row bg-light">
          <div class="col-md-2">
            <label for="platform" class="col-form-label">Platform</label>
          </div>
          <div class="col-md-10">
            <select class="form-control" id="platform" name="platform">
              <option<?php echo (($platform == "Windows") ? ' selected>' : '>'); ?>Windows</option>
              <option<?php echo (($platform == "Linux") ? ' selected>' : '>'); ?>Linux</option>
              <option<?php echo (($platform == "Other") ? ' selected>' : '>'); ?>Other</option>
            </select>
            <p class="text-info"><small>Choose which platform the machines run</small></p>
          </div>
        </div>

        <div class="row bg-light">
          <div class="col-md-2">
            <label for="expires" class="col-form-label">Expires*</label>
          </div>
          <div class="col-md-10">
            <input type="date" class="form-control" id="expires" name="expires" <?php echo (($expires == '') ? 'placeholder="12/31/2020"' : 'value="' . $expires . '"'); ?> required>
            <p class="text-info"><small>Date this link stops working</small></p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <input type="hidden" name="vnctarget_id" id="vnctarget_id" />
            <input type="hidden" name="created" id="created" value="<?php echo time(); ?>"/>
            <input type="submit" name="insert1" id="insert" value="Insert and exit" class="btn btn-success" />
            <input type="submit" name="insert2" id="insert" value="Insert and add another" class="btn btn-success" />
          </div>
        </div>
      </form>
    </div><!-- container-fluid -->
  </div><!-- container -->
<?php endif; ?>
<?php if(! $u_admin) : ?>
         <br />
        <p class="lead" align="center">Please login with an administrator role to create classroom images.</p>
    </div>
<?php endif; ?>

<!-- jquery function to add/update database records -->
<!--
<script type="text/javascript">
	$(document).ready(function(){
		$('#insert_form').on("submit", function(event){
			event.preventDefault();
			if($('#host').val() == '') {
                alert("Host is required");
            } else if($('#port').val() == '') {
                alert("Port is required");
            } else if($('#token').val() == '') {
                alert("Token is required");
            } else if($('#classid').val() == '') {
                alert("Course ID is required");
            } else {
              $.post({
              	       data: $('#insert_form').serialize(),
                       beforeSend: function(){
                          $('#insert').val("Inserting");
                       },
                       success: function(data){
                       	  alert("Data loaded.");
                       }
                     });
            }
        });
    });
</script> -->
<?php
  require_once("includes/footer.php");
?>
