<?php  
 //fetch_login.php
require_once('config.php');
require_once('functions.php');
error_log("Running fetch_login.php with id=". $_POST["username"]);
ferror_log("LOGIN! " . $_POST["username"]);
$message = "error";
if(isset($_POST["username"]) && isset($_POST["password"])) {
    // Connect to the database
    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $username = mysqli_real_escape_string($f_link, $_POST['username']);
    $password = mysqli_real_escape_string($f_link, $_POST['password']);
    error_log("Login attempt by " . $username);
    // Prepare a select statement
    $sql = "SELECT username, password, roles FROM users WHERE username = ?";
    ferror_log("SQL: ". $sql);

    if ($stmt = mysqli_prepare($f_link, $sql)) {
        // Bind variables to the prepared statement as parameters and set parameters
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = $username;
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            // Check if username exists, if yes then verify password
            if (mysqli_stmt_num_rows($stmt) == 1) {
                // Bind result variables
                mysqli_stmt_bind_result($stmt, $username, $hashed_password, $roles);
                if (mysqli_stmt_fetch($stmt)) {
                    if (password_verify($password, $hashed_password)) {
                        /* Password is correct, so start a new session and save the username to the session */
                        session_start();
                        $_SESSION['username'] = $username;
                        $_SESSION['roles'] = $roles;
                        ferror_log("Session starting.");
                        ferror_log("SESSION username = " . $_SESSION['username']);
                        ferror_log("SESSION roles = " . $_SESSION['roles']);
                        $message = "success";
                    } else {
                        // Display an error message if password is not valid
                        $message = "password";
                        ferror_log("Password does not match database.");
                        // Unset all of the session variables
                        $_SESSION = array();
                        // Destroy the session
                        session_destroy();
                    }
                }
            } else {
                // Display an error message if username doesn't exist
                ferror_log("No account found with that username.");
                $message = "username";
            }
        } else {
            ferror_log("Oops! Something went wrong. Please try again later.");
            $message = "error";
        }
    }
 
    // echo json_encode($rowList);
    echo $message;
}
?>