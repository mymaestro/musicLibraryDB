<?php  
 //delete_records.php
require_once('includes/config.php');
require_once('includes/functions.php');
error_log("Running delete_records.php with id=". $_POST["vnctarget_id"]);
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$output = '';
$message = '';
if(!empty($_POST)) {
    if($_POST["vnctarget_id"] != '') {
        $sql = "
        DELETE FROM vnc_targets 
        WHERE id='".$_POST["vnctarget_id"]."'";
        $res = mysqli_query($f_link, $sql);
        $message = 'Deleted';
        error_log("Delete SQL: " . $sql);

        /* Write out the VNC targets file configuration for websockify */
        $sql= "SELECT token, host, port FROM vnc_targets WHERE  DATE(vnc_targets.expires) > CURDATE()";
        $res = mysqli_query($f_link, $sql);
        error_log("result: ". mysqli_num_rows($res) . " rows.");

        /* Preserve the existing configuration file */
        $vnc_targets_file = "/var/www/vncproxy/vnc_targets";
        if (is_file($vnc_targets_file)) {
            rename($vnc_targets_file, $vnc_targets_file . "_" . date('Ymd_His'));
        }

        $vnc_targets_ini = fopen($vnc_targets_file, "w") or die("Unable to open vnc_targets");
        while($row = mysqli_fetch_array($res)) {
            $output = $row["token"] . ': '. $row["host"] . ':' . $row["port"] . "\n";
            fwrite($vnc_targets_ini, $output);
        }
        fclose($vnc_targets_ini);
        error_log("New vnc_targets configuration written.");
        }
    } else {
        $created = date('Y-m-d H:i:s.u');
        $sql = "";
        error_log("Delete SQL (N/A): " . $sql);
        $message = 'No data deleted';
    }
echo json_encode($message);
?>
