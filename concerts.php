<?php
define('PAGE_TITLE', 'Concerts');
define('PAGE_NAME', 'concerts');
require_once("includes/header.php");
$u_admin = FALSE;
$u_librarian = FALSE;
$u_user = FALSE;
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $u_admin = (strpos(htmlspecialchars($_SESSION['roles']), 'administrator') !== FALSE ? TRUE : FALSE);
    $u_librarian = (strpos(htmlspecialchars($_SESSION['roles']), 'librarian') !== FALSE ? TRUE : FALSE);
    $u_user = (strpos(htmlspecialchars($_SESSION['roles']), 'user') !== FALSE ? TRUE : FALSE);
}
require_once("includes/config.php");
require_once("includes/navbar.php");
?>
<main role="main" class="container">
    <div class="container">
        <div class="row pb-3 pt-5 border-bottom"><h1><?php echo ORGNAME ?> Concerts</h1></div>
        <div class="row pt-3">
            <p>Nothing to see here yet</p>
        </div>
    </div>
</main>
<?php require_once("includes/footer.php"); ?>
<script>
    $(document).on('click', '.missing_parts', function() {
        var catalog_number = $(this).attr("id");
        if (catalog_number != '') {
            $.ajax({
                url: "includes/report_missing_parts.php",
                type: "POST",
                data: {
                    report: "missing_parts"
                },
                success: function(data) {
                    $('#report_detail').html(data);
                    $('#view_data_modal').modal('show');
                }
            });
        }
    });
</script>
</body>

</html>