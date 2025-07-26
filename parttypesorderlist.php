<?php
  define('PAGE_TITLE', 'Score order');
  define('PAGE_NAME', 'Part types order');
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
  require_once('includes/config.php');
  require_once('includes/functions.php');
  require_once("includes/navbar.php");
  ferror_log("RUNNING parttypesorderlist.php");
?>
<main role="main">
    <div class="container">
        <h1><?php echo ORGNAME . ' ' . PAGE_TITLE ?></h1>
<?php if($u_librarian) : ?>
        <button type="button" class="btn btn-warning btn-floating btn-lg" id="btn-back-to-top">
            <i class="fas fa-arrow-up"></i>
        </button>
        <div align="center">
            <span id="scoreordersavemessage">Choose and drag each item in the list to sort. </span><button type="button" name="update" id="update" class="btn btn-success">Update</button>
            <button onclick="history.back()" class="btn btn-secondary">Back</button>
            <br />
        </div><!-- right button -->
        <div class="row">
            <div class="col align-self-start">&nbsp</div>
        <div class="col align-self-center" id="part_type_list">
        <?php
        echo '           
               <ul class="list-group" id="partscoreorder">';
        $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $sql = "SELECT * FROM part_types ORDER BY collation;";
        $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
        while ($rowList = mysqli_fetch_array($res)) {
            $id_part_type = $rowList['id_part_type'];
            $collation = $rowList['collation'];
            $name = $rowList['name'];
            echo '<li class="list-group-item" id="part_'.$id_part_type.'">'.$name.'</li>';
        }
        echo '</ul>
            </div><div class="col align-self-end">&nbsp</div>
            </div><!-- class col -->
           ';
        mysqli_close($f_link);
        // ferror_log("returned: " . $sql);
        ?>
    </div><!-- container -->
<?php else: ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info">
                    You do not have permission to view this page.
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

</main>
<?php require_once("includes/footer.php");?>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js" integrity="sha256-eTyxS0rkjpLEo16uXTS0uVCS4815lc40K2iVpWDvdSY=" crossorigin="anonymous"></script>
<!-- jquery function to add/update database records -->
<script>
$(document).ready(function(){
    // Scroll-to-top button
    let $upButton = $("#btn-back-to-top");
    // When the user scrolls down 20px from the top of the document, show the button
    $(window).on("scroll", function () {
        if ($(document).scrollTop() > 20) {
            $upButton.show();
        } else {
            $upButton.hide();
        }
    });
    // When the user clicks the button, scroll to the top of the document
    $upButton.on("click", function () {
        $("html, body").animate({ scrollTop: 0 }, "fast");
    });

    $("ul#partscoreorder").sortable({
        opacity: 0.6,
        cursor: 'move',
        update: function(){
            $('#scoreordersavemessage').html('Changes not saved. Choose ');
            $('#scoreordersavemessage').css("color", "red");
            }
    });
    $("#update").click(function(){
        var order=$("ul#partscoreorder").sortable("serialize");
        $('#scoreordersavemessage').html('Saving changes.');
        $.post("includes/update_scoreorder.php",order,function(theResponse){
            $('#scoreordersavemessage').html(theResponse);
            $('#scoreordersavemessage').css("color", "green");
        });
    });
});
</script>
</body>
</html>
