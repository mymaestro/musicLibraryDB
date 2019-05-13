<?php
// Include config file
define('PAGE_TITLE', 'Login');
define('PAGE_NAME', 'login');
require_once("includes/header.php");
require_once('includes/password_hash.php');
require_once('includes/config.php');
require_once('includes/functions.php');

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
     // Check if username is empty
    if(!trim($_POST["username"])) {
        $username_err = 'Please enter username.';
    } else{
        $username = trim($_POST["username"]);
    }
    // Check if password is empty
    if(!trim($_POST['password'])){
        $password_err = 'Please enter your password.';
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Connect to the database
        $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        // Prepare a select statement
        $sql = "SELECT username, password, roles FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($f_link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
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
                            /* Password is correct, so start a new session and
                            save the username to the session */
                            session_start();
                            $_SESSION['username'] = $username;
                            $_SESSION['roles'] = $roles;
                            header("location: welcome.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = 'The password you entered was not valid.';
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
    }
}
?>
<body class="text-center">
<?php
  require_once("includes/navbar.php");
?>
    <div class="container">
    <br />
    <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="width: 100%; max-width: 330px; padding: 15px;   margin: 0 auto;">
      <img class="d-block mx-auto mb-4" src="images/main-logo.png" alt="" width="184" height="256">
      <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
      <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
        <label for="username" class="sr-only">User name</label>
        <input type="text" id="username" name="username" class="form-control" placeholder="username" value="<?php echo $username; ?>" required autofocus>
        <span class="help-block"><?php echo $username_err; ?></span>
      </div>
      <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
        <label for="password" class="sr-only">Password</label>
        <input type="password" name="password" placeholder="password" class="form-control">
        <span class="help-block"><?php echo $password_err; ?></span>
      </div>

      <button class="btn btn-md btn-primary btn-block" type="submit">Sign in</button>
      <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
    </form>
</div>
<?php
  require_once("includes/footer.php");
?>
