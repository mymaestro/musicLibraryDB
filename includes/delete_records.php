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

        if ($error_code == 1451) { // 1451 = foreign key constraint
            echo json_encode([
                'success' => false,
                'error' => 'Delete failed with ' . $error_code . ': '. $table_key . ' is referenced in another table. MSG: ' . $error_message
            ]);
        } else {
        echo json_encode([
            'success' => false,
            'error' => 'Database error code ' . $error_code . ': ' . $error_message
            ]);
        }
    }
}
?>