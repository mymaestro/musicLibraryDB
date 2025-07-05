<?php
define('PAGE_TITLE', 'Register');
define('PAGE_NAME', 'Register');
require_once('includes/header.php');
require_once('includes/config.php');
require_once('includes/functions.php');
require_once('includes/password_hash.php');

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
$address = $address_err = $name = $name_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Validate username
    if(isset($_POST['username'])) {
        $username = mysqli_real_escape_string($f_link, $_POST['username']);
        // Connect to the database
        // Prepare a select statement
        $sql = "SELECT id_users FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($f_link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) $username_err = "This username is already taken.";
            } else {
                $username_err = "Oops! Problem looking for user names.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);

    } else $username_err = "Please enter a username.";

    // Validate name
    if(isset($_POST['name'])){
        $name = mysqli_real_escape_string($f_link, $_POST['name']);
        if(strlen(trim($name)) < 3) $name_err = "Your name must have at least 3 characters.";
    } else $name_err = "Please enter your name.";

    // Validate address
    if(isset($_POST['address'])) {
        $address = mysqli_real_escape_string($f_link, $_POST['address']);
        if(!filter_var($address, FILTER_VALIDATE_EMAIL)) $address_err = "Please enter a valid e-mail address.";
    } else {
        $address_err = "Please enter a valid e-mail address.";     
    }

    // Validate password
    if (isset($_POST['password'])) {
        $password = mysqli_real_escape_string($f_link, $_POST['password']);
        ferror_log("Sent password ". str_repeat("*",strlen($password)));
        $number = preg_match('@[0-9]@', $password);
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
        if(strlen($password) < 8 || !$number || !$uppercase || !$lowercase || !$specialChars) {
            $password_err = "Password must be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.";
        } 
    } else $password_err = "Please enter a password.";

    // Validate confirm password
    if (isset($_POST['confirm_password'])) {
        $confirm_password = mysqli_real_escape_string($f_link, $_POST['confirm_password']);
        ferror_log("Send confirmation password ". str_repeat("*",strlen($confirm_password));
        $number = preg_match('@[0-9]@', $confirm_password);
        $uppercase = preg_match('@[A-Z]@', $confirm_password);
        $lowercase = preg_match('@[a-z]@', $confirm_password);
        $specialChars = preg_match('@[^\w]@', $confirm_password);
        $passwordMatch = ($password === $confirm_password);
        if(strlen($confirm_password) < 8 || !$number || !$uppercase || !$lowercase || !$specialChars || !$passwordMatch) {
            $confirm_password_err = "Confirm password must match the password, be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.";
        }
    } else $confirm_password_err = "Please enter a password.";

    ferror_log("Working with username: " . $username . ", address: " . $address);

    // Check input errors before inserting in database
    if(empty($username_err) && empty($name_err) && empty($password_err) && empty($confirm_password_err) && empty($address_err)) {
    
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, name, password, address) VALUES (?, ?, ?, ?)";
        ferror_log($sql);
         
        if($stmt = mysqli_prepare($f_link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_name, $param_password, $param_address);
            
            // Set parameters
            $param_username = $username;
            $param_name = $name;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_address  = $address;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($f_link);
}
require_once('includes/navbar.php');
?>
<div class="container">
<main>
    <div class="py-5 text-center">
        <h1>Sign up for <?php echo ORGNAME ?> library access.</h1>
    </div>
    <div class="row g-5">
        <div class="col-md-7">
            <p class="lead">Please submit this form to create an account.</p>

            <div class="col-12">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="username" class="col-form-label">Username*</label>
                <input type="text" id="username" name="username" class="form-control<?php echo (!empty($username_err)) ? ' is-invalid' : ''; ?>" placeholder="username" value="<?php echo $username; ?>" required>
                <span class="help-block"><?php echo $username_err; ?></span>                            
            </div>
            <div class="col-12">
                <label for="name" class="col-form-label">Name (First Last)*</label>
                <input id="name" type="text" name="name" class="form-control<?php echo (!empty($name_err)) ? ' is-invalid' : ''; ?>" placeholder="First Last" value="<?php echo $name; ?>" required>
                <span class="help-block"><?php echo $name_err; ?></span>
            </div>
            <div class="col-sm-6">
                <label for="password" class="col-form-label">Password*</label>
                <input type="password" name="password" class="form-control<?php echo (!empty($password_err)) ? ' is-invalid' : ''; ?>" placeholder="password" value="<?php echo $password; ?>" required>
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="col-sm-6">
                <label for="confirm_password" class="col-form-label">Confirm password*</label>
                <input id="confirm_password" type="password" name="confirm_password" class="form-control<?php echo (!empty($confirm_password_err)) ? ' is-invalid' : ''; ?>" placeholder="repeat password" value="<?php echo $confirm_password; ?>" required>
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="col-12">
                <label for="address" class="col-form-label">e-mail address*</label>
                <input type="e-mail" name="address" class="form-control<?php echo (!empty($address_err)) ? ' is-invalid' : ''; ?>" placeholder="username@example.com" value="<?php echo $address; ?>" required>
                <span class="help-block"><?php echo $address_err; ?></span>
            </div>
            <hr class="my-4">
            <div class="col-12">
                <input type="submit" class="w-50 align-right btn btn-primary" value="Submit">
                </form>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-secondary">Already have an account?</h5>
                    <p class="card-text">Go to the login page.</p>
                    <a href="login.php" class="card-link">Login</a>
                </div>
            </div>
        </div>
    </div>

</main>
</div>
<?php require_once('includes/footer.php'); ?>
</body>
</html>
