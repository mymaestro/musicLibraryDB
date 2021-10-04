<?php
require_once('includes/password_hash.php');
require_once('includes/config.php');
require_once('includes/functions.php');

// Include config file
define('PAGE_TITLE', 'Login');
define('PAGE_NAME', 'login');

error_log("RUNNING login.php with username=". $_POST["username"]);

// Three ways to get here:
// 1. Direct request, not from a session or login request
// 2. From a login request (this page, with username/login completed)
//    Remember, this may also be a result of a failed request.
// 3. Direct request during a session (SESSION username/password are set)


if(!isset($_SESSION['username']) || empty($_SESSION['username'])){  // Not logged in; show signin form
    error_log("No session in place.");
    $login_success = FALSE;  
    if(!empty($_POST)) { // Login request
        error_log("Requesting password validation.");
        error_log("POST username=".$_POST["username"]);
        $username_err = $password_err = "";
        // Processing form data when form is submitted

        // Connect to the database
        $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $username = mysqli_real_escape_string($f_link, $_POST['username']);
        $password = mysqli_real_escape_string($f_link, $_POST['password']);
        // Prepare a select statement
        $sql = "SELECT username, password, roles FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($f_link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);           
            // Set parameters for 
            $param_username = $username;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $username, $hashed_password, $roles);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            /* Password is correct, so start a new session and save the username to the session */
                            session_start();
                            $_SESSION['username'] = $username;
                            $_SESSION['roles'] = $roles;
                            error_log("Session starting.");
                            $username_err = "Roles: " . $roles;
                            $password_err = "";
                            $login_success = TRUE;
                        } else {
                            // Display an error message if password is not valid
                            $password_err = 'The password you entered was not valid.';
                            error_log("Password does not match database.");
                            // Unset all of the session variables
                            $_SESSION = array();
                            // Destroy the session
                            session_destroy();
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = 'No account found with that username.';
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    } else { // Came directly to this page
        $username = $password = "";
        $username_err = $password_err = "";
    }
    if ($login_success) {
        $output = '
        <div class="container">
        <div class="page-header">
        <br />
        <h1>Hi, <b>' . htmlspecialchars($_SESSION['username']) . '</b>. Welcome to our site.</h1>
        <p>You have the role(s) <b>' . htmlspecialchars($_SESSION['roles']).'</b>. Use wisely.</p>
    </div>
    <p><a href="logout.php" class="btn btn-danger">Sign out of your account</a></p>
    <p>To sign out later, click the lock icon <i class="fas fa-unlock"></i> in the upper left.</p>
    </div>';
    } else {
    $output = '
    <div class="container">
    <br />
    <form class="form-signin" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post" style="width: 100%; max-width: 330px; padding: 15px;   margin: 0 auto;">
      <img class="d-block mx-auto mb-4" src="images/main-logo.png" alt="" width="184" height="256">
      <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
      <div class="form-group ' . ((!empty($username_err)) ? 'has-error' : '') . '">
        <label for="username" class="sr-only">User name</label>
        <input type="text" id="username" name="username" class="form-control" placeholder="username" value="'. $username .'" required autofocus>
        <span class="help-block">'. $username_err . '</span>
      </div>
      <div class="form-group '. ((!empty($password_err)) ? 'has-error' : '') . '">
        <label for="password" class="sr-only">Password</label>
        <input type="password" name="password" placeholder="password" class="form-control">
        <span class="help-block">'. $password_err . '</span>
      </div>

      <button class="btn btn-md btn-primary btn-block" type="submit">Sign in</button>
      <p>Need an account? <a href="register.php">Sign up now</a>.</p>
    </form>
    </div>';
    }
} else { // Entered this page already logged in.
$output = '
    <div class="container">
    <div class="page-header">
    <br />
    <h1>Hi, <b>' . htmlspecialchars($_SESSION['username']) . '</b>. Welcome to our site.</h1>
    <p>You have the role(s) <b>' . htmlspecialchars($_SESSION['roles']).'</b>. Use wisely.</p>
</div>
<p><a href="logout.php" class="btn btn-danger">Sign out of your account</a></p>
<p>To sign out later, click the lock icon <i class="fas fa-unlock"></i> in the upper left.</p>
</div>';
}
// Display the page contents
require_once("includes/header.php");
echo '<body class="text-center">';
require_once("includes/navbar.php");
echo $output;
require_once("includes/footer.php");
?>
