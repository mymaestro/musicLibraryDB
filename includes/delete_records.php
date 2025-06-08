<?php  
 //delete_records.php
 // remodel to fit music library database
require_once('config.php');
require_once('functions.php');
error_log("Running delete_records.php");
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (isset($_POST["table_name"])) $table_name = mysqli_real_escape_string($f_link, $_POST['table_name']);
if (isset($_POST["table_key_name"])) $table_key_name = mysqli_real_escape_string($f_link, $_POST['table_key_name']);
if (isset($_POST["table_key"])) $table_key = mysqli_real_escape_string($f_link, $_POST['table_key']);

if (isset($table_name) && isset($table_key_name) && isset($table_key)) {
    $timestamp = time();
    // JSON comin' atcha
    header('Content-Type: application/json');
    ferror_log("table=". $table_name );
    ferror_log("table key=". $table_key);
    ferror_log("table key name=". $table_key_name);

    $sql = "DELETE FROM " . $table_name . " WHERE ".$table_key_name . " = ?";

    ferror_log("Delete SQL: " . $sql);
    ferror_log("Command:" . $sql);

    try {
        $stmt = mysqli_prepare($f_link, $sql);
        mysqli_stmt_bind_param($stmt, "s", $table_key);  // i=integer, d=double, s=string, b=BLOB
        mysqli_stmt_execute($stmt);
        echo json_encode(['success' => true,
            'message' => $table_key ]);
    } catch ( mysqli_sql_exception $e) {
        $error_code = $e->getCode();
        $error_message = $e->getMessage();
        ferror_log("Ended with error code " . $error_code . ": " . $error_message);
        // 1451 = foreign key constraint
        echo json_encode([
            'success' => false,
            'error' => 'Database error code ' . $error_code . ': ' . $error_message
        ]);
    }

// ERROR
//       echo '<p class="text-danger">Error deleting <emp>'.$table_key.'</emp> from '.$table_name.'.</p><p>Error message:<br/>'. $error_message . '</p>';

// SUCCESS
//       echo '<p class="text-success">Record '.$table_key.' deleted from '.$table_name.'</p>';

}
?>