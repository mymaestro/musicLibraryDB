<?php
  define('PAGE_TITLE', 'List part types');
  define('PAGE_NAME', 'Part types');
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
  ferror_log("RUNNING parttypes.php");
?>
<main role="main">
    <div class="container">
        <h2 align="center"><?php echo ORGNAME ?> Part Types</h2>
<?php if($u_librarian) : ?>
        <div align="right">
            <button type="button" name="update" id="update" data-bs-toggle="modal" data-bs-target="#update_data_Modal" class="btn btn-warning">Update</button>
            <br />
        </div><!-- right button -->
<?php endif; ?>
        <div id="part_type_table">
        <?php
        echo '            <div class="panel panel-default">
               <div class="table-repsonsive">
                    <table class="table table-hover">
                    <caption class="title">Available part types</caption>
                    <thead>
                    <tr>
                        <th>Collation</th>
                        <th>Name</th>
                        <th>Family</th>
                        <th>Description</th>
                        <th>Part Collection</th>
                        <th>Enabled</th>
                    </tr>
                    </thead>
                    <tbody>';
        $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $sql = "SELECT * FROM part_types ORDER BY collation;";
        $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
        while ($rowList = mysqli_fetch_array($res)) {
            $id_part_type = $rowList['id_part_type'];
            $collation = $rowList['collation'];
            $name = $rowList['name'];
            $family = $rowList['family'];
            $description = $rowList['description'];
            $is_part_collection = $rowList['is_part_collection'];
            $enabled = $rowList['enabled'];
            echo '<tr>
                        <td>'.$collation.'</td>
                        <td>'.$name.'</td>
                        <td>'.$family.'</td>
                        <td>'.$description.'</td>
                        <td>'.$is_part_collection.'</td>
                        <td><div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="typeEnabled" disabled '. (($enabled == 1) ? "checked" : "") .'>
                        </div></td>
                    </tr>
                    ';
        }
        echo '
                    </tbody>
                    </table>
                </div><!-- table-responsive -->
            </div><!-- class panel -->
           ';
        mysqli_close($f_link);
        // ferror_log("returned: " . $sql);
        ?>
    </div><!-- container -->

</main>
<?php require_once("includes/footer.php");?>
<!-- jquery function to add/update database records -->
<script>
$(document).ready(function(){

});
</script>
</body>
</html>
