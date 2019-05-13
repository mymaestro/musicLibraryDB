<?php
  define('PAGE_TITLE', 'Connect training images');
  define('PAGE_NAME', 'connect');
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
?>
    <main role="main" class="container">
        <br />
        <img class="d-block mx-auto mb-4" src="images/main-logo.png" alt="" width="132" height="20">
        <h2 align="center">HCL Products and Platforms classroom images</h2>
<?php if($u_user) : ?>
        <div class="classroom_images">
          <div class="accordion">
          <br />
            <p class="lead">Connect to one of the available classroom images.</p>
<?php endif; ?>
<?php if(! $u_user) : ?>
         <br />
        <p class="lead" align="center">Please login with a user role to connect to one of the available classroom images.</p>
<?php endif; ?>
<?php
     if($u_user) {
            require_once('includes/config.php');
            require_once('includes/functions.php');
            $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $sql = 'SELECT vnc_targets.id as ID,
                           vnc_targets.created as CREATED,
                           vnc_targets.host as HOST,
                           vnc_targets.port as PORT,
                           vnc_targets.token as TOKEN,
                           vnc_targets.platform as PLATFORM,
                           vnc_targets.classid as CLASSID,
                           vnc_targets.expires as EXPIRES,
                           classes.course_code as COURSE_CODE,
                           classes.title as TITLE,
                           classes.product_categories as PORTFOLIO
                    FROM   vnc_targets
                    INNER JOIN classes
                    ON     vnc_targets.classid = classes.id
                    WHERE  DATE(vnc_targets.expires) > CURDATE()
                    ORDER BY classes.product_categories, classes.course_code;';
            $oldPortfolio = 'xyzzy';
            $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
            while ($rowList = mysqli_fetch_array($res)) {
                $rowID = $rowList['ID'];
                $platform = $rowList['PLATFORM'];
                $classid =  $rowList['CLASSID'];
                $vnchost = $rowList['HOST'];
                $vncport = $rowList['PORT'];
                $vnctoken = $rowList['TOKEN'];
                $expires = $rowList['EXPIRES'];
                $course_code = $rowList['COURSE_CODE'];
                $course_title = $rowList['TITLE'];
                $portfolio = $rowList['PORTFOLIO'];
                $proxyURL = 'https://' . PROXY_SERVER . '/vnc.html?path=?token='. $vnctoken;
                if ( $platform == "Windows") {
                  $platImage = "fab fa-microsoft";
                } elseif ($platform == "Linux") {
                  $platImage = "fab fa-linux";
                } else {
                  $platImage = "far fa-question-circle";
                }
                if ( $portfolio != $oldPortfolio ) {
                    if ( $oldPortfolio != "xyzzy" ) {
                        echo '
                        </div>
                     </div>';
                    }
                    echo '
                     <div class="panel panel-default">
                       <div class="panel-heading" role="tab" id="header'. $portfolio .'">
                         <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#section'.$portfolio.'" aria-expanded="true" aria-controls="section'.$portfolio.'">
                          '.$portfolio.' images
                          </a>
                         </h4>
                       </div>
                       <div id="section'.$portfolio.'" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="header'.$portfolio.'">
                        <div class="card-columns">
';
                    $oldPortfolio = $portfolio;
                }
                    echo'   
                        <div class="card">
                          <div class="card-body">
                            <h3 class="card-title"><a href="'. $proxyURL . '"><i class="'. $platImage . '"></i></a></h3>
                            <h4 class="card-subtitle">'.$course_code.'</h4>
                            <p class="card-text">'. $course_title .'</p>
                            <p class="card=text"><small class="text-muted">Expires ' .date('F d, Y', strtotime($expires)) . '</small></p>
                            <a href="'. $proxyURL . '" class="btn btn-sm btn-primary">Connect to '.$vnctoken.'</a>
                            <!-- vnc://' . $vnctoken . '@' . $vnchost . ':' . $vncport . '-->
                          </div>
                        </div>
                            ';

            }
            
            mysqli_close($f_link);
            error_log("returned: " . $sql);
          }  ?>
<?php if($u_user) : ?>

            </div>
        </div>
        </div>
        </div>
        </div>
<?php endif; ?>
    </main>
    <!-- /.container -->

<?php
  require_once("includes/footer.php");
?>
