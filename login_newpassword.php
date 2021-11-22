<?php
// Include config file
define('PAGE_TITLE', 'New password');
define('PAGE_NAME', 'new password');

require_once('includes/header.php');
require_once('includes/config.php');
require_once('includes/navbar.php');

// Use this page to put in your new password
// User gets here only by clicking the link sent to their e-mail address
// which was sent with a selector and a validator

// The form on this page requests new password and matching new password.
// And calls includes/reset_password.php

// If the selector and validator match the request the new password gets stored in the database

?>
<div class="container">
<main>
    <div class="py-5 text-center">
        <h2><?php echo ORGNAME ?> library <?php echo PAGE_NAME ?></h2>
    </div>
    <div class="row g-5">
        <div class="col-md-7">
<?php
$selector = $_GET["selector"];
$validator = $_GET["validator"];

if (empty($selector) || empty($validator)) {
    echo '     <p class="lead text-center">Request failed.</p>';
} else {
    if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
        ?>
            <p class="lead">Please enter your new password.</p>

            <div class="col-6">
                <form action="includes/reset_password.php" method="post">
                <input type="hidden" name="selector" value="<?php echo $selector ?>">
                <input type="hidden" name="validator" value="<?php echo $validator ?>">
                <label for="password" class="col-form-label">Password*</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="password" required>
                <span class="help-block"></span>                            
            </div>
            <div class="col-6">
                <label for="confirm_password" class="col-form-label">Repeat password*</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Repeat password" required>
                <span class="help-block"></span>                            
            </div>
            <hr class="my-4">
            <div class="col-12">
                <input type="submit" name="reset-password-submit" class="w-50 align-right btn btn-primary" value="Submit">
                </form>
            </div>
    <?php
    }
}
?>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-secondary">Want to login?</h5>
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