<?php  
 //fetch.php
define('DB_HOST', 'localhost');
define('DB_NAME', 'classinfo');
define('DB_USER', 'classadmin');
define('DB_PASS', 'careful6productivity@Adequate');
 $connect = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);  
 if(isset($_POST["employee_id"]))  
 {  
      $query = "SELECT * FROM tbl_employee WHERE id = '".$_POST["employee_id"]."'";  
      $result = mysqli_query($connect, $query);  
      $row = mysqli_fetch_array($result);  
      echo json_encode($row);  
 }  
?>