<?php
require_once('config.php');
require_once('functions.php');

// Called from login_newpassword.php, where the user entered their new password twice.
ferror_log("Running reset_password.php");

if (isset($_POST["reset-password-submit"])) {

    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = mysqli_real_escape_string($f_link, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($f_link, $_POST['confirm_password']);

    if (empty($password) || empty($confirm_password)) {
        header("Location: ../login_newpassword.php");
        exit();
    } else {
        // Validate confirm password
        $number = preg_match('@[0-9]@', $password);
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
        $passwordMatch = ($password === $confirm_password);
        if(strlen($password) < 8 || !$number || !$uppercase || !$lowercase || !$specialChars || !$passwordMatch) {
            echo "Confirm password must match the password, be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.";
            header("Location: ../login_newpassword.php");
            exit();
        }
    }

    $currentDate = date("U");

    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM password_reset WHERE password_reset_selector = ? AND password_reset_expires >= $currentDate ;";

    if (!$stmt = mysqli_prepare($f_link, $sql)) {
        echo "Database error.";
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $selector);
        mysqli_stmt_execute($stmt);

        $res = mysqli_stmt_get_result($stmt);
        if (!$row = mysqli_fetch_assoc($res)) {
            echo "Resubmit your password reset request.";
            exit();
        } else {
            $tokenBin = hex2bin($validator);
            $tokenCheck = password_verify($tokenBin, $row["password_reset_token"]);
            if($tokenCheck === false) {
                echo "Resubmit your password reset request.";
                exit();    
            } elseif ($tokenCheck === true) {
                $param_userEmail = $row["password_reset_email"];
                $sql = "SELECT * FROM users WHERE address=?;";

                if (!$stmt = mysqli_prepare($f_link, $sql)) {
                    echo "Database error.";
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $param_userEmail);
                    mysqli_stmt_execute($stmt);
                    $res = mysqli_stmt_get_result($stmt);
                    if (!$row = mysqli_fetch_assoc($res)) {
                        echo "Error reading users table.";
                        exit();
                    } else {
                        $sql = "UPDATE users SET password=? WHERE address=?;";
                        if (!$stmt = mysqli_prepare($f_link, $sql)) {
                            echo "Database error.";
                            exit();
                        } else {
                            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt, "ss", $passwordHash, $param_userEmail);
                            mysqli_stmt_execute($stmt);

                            $sql = "DELETE FROM password_reset WHERE password_reset_email=?;";
                            if (!$stmt = mysqli_prepare($f_link, $sql)) {
                                echo "Database error.";
                                exit();
                            } else {
                                mysqli_stmt_bind_param($stmt, "s", $param_userEmail);
                                mysqli_stmt_execute($stmt);
                                header("Location: ../login.php?newpassword=passwordupdated");
                            }
                        }
                    }
                }

            }
        }
    }

} else {
    header("Location: ../index.php");
}