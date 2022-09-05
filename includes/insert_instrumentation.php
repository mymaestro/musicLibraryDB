<?php
define('PAGE_TITLE', 'Insert instrumentation');
define('PAGE_NAME', 'Insert instrumentation');
require_once("header.php");
$u_admin = FALSE;
$u_librarian = FALSE;
$u_user = FALSE;
if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
  $u_admin = (strpos(htmlspecialchars($_SESSION['roles']), 'administrator') !== FALSE ? TRUE : FALSE);
  $u_librarian = (strpos(htmlspecialchars($_SESSION['roles']), 'librarian') !== FALSE ? TRUE : FALSE);
  $u_user = (strpos(htmlspecialchars($_SESSION['roles']), 'user') !== FALSE ? TRUE : FALSE);
}
require_once('config.php');
require_once("navbar.php");
?>
<main role="main">
    <?php
    require_once('functions.php');
    ferror_log("RUNNING insert_instrumentation.php with catalog_num=". $_POST["catalog_number"]);
    ?>
    <div class="container">
        <h1 align="center"><?php echo ORGNAME . ' ' . PAGE_NAME ?></h1>
        <?php if ($u_librarian) : ?>
        <?php if(!empty($_POST)) {
            $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if (isset($_POST['catalog_number'])) $catalog_number = mysqli_real_escape_string($f_link, $_POST['catalog_number']);
            if (isset( $_POST['paper_size'])) $paper_size = mysqli_real_escape_string($f_link, $_POST['paper_size']);
            if (isset( $_POST['page_count'])) $page_count = mysqli_real_escape_string($f_link, $_POST['page_count']);
            // parttypes could/should be an array, that is handled below
            if (isset($_POST['parttypes'])) {
                if (!is_array($_POST['parttypes'])) {
                    $parttypes = mysqli_real_escape_string($f_link, $_POST['parttypes']);
                } else {
                    $parttypes = $_POST['parttypes'];
                }
            }
            echo '<h4>You added the following parts:</h4>';
            if($_POST["submit"] == "add"){
    
                // loop over part types selected in the dropdown <option>

                if(!empty($_POST['parttypes']) && isset($catalog_number) && isset($paper_size) && isset($page_count)) {
                    echo '<form action="../parts.php" method="POST"><input type="hidden" name="catalog_number" value="'.$catalog_number.'"><button class="btn btn-primary"/>Edit parts</button></form>';
                    $output = '<table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Catalog number</th>
                            <th>Part type ID</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                    ';
                    $originals_count = 1;
                    $copies_count = 0;
                    $name = "$username " . date("Y-m-d");
                    foreach($_POST['parttypes'] as $id_part_type_num) {
                        // Expect to find duplicates
                        $id_part_type = mysqli_real_escape_string($f_link, $id_part_type_num);
                        $sql = "INSERT INTO parts(catalog_number, id_part_type, name, paper_size, page_count, originals_count, copies_count)
                        VALUES('$catalog_number', '$id_part_type', '$name', '$paper_size', $page_count, $originals_count, $copies_count);";
                        $output .= '<tr><td>' . $catalog_number . '</td><td>' . $id_part_type .  '</td><td>';
                        ferror_log("Running SQL ". $sql);
                        if(mysqli_query($f_link, $sql)) {
                            $output .= '<span class="text-success">Part ' . $catalog_number . '-' . $id_part_type . ' added successfully.</span></td>';
                        } else {
                            $error_message = mysqli_error($f_link);
                            $error_number = mysqli_errno($f_link);
                            if ($error_number == 1062) {
                                $output .= '<span class="text-secondary">Not added. Part already exists for '. $catalog_number . '-' . $id_part_type . '.</td>';
                            } else {
                                $output .= '<span class="text-danger">Insert failed. Error (' . $error_number . '): ' .$error_message . '</span></td>';
                                ferror_log("Error: " . $error_message);
                            }
                        }
                        $output .= '
                        </tr>
                        ';
                    } // Loop parts
                    $referred = $_SERVER['HTTP_REFERER'];
                    $query = parse_url($referred, PHP_URL_QUERY);
                    $referred = str_replace(array('?', $query), '', $referred);
                    echo $output;
                    echo '</tbody></table>';
                    echo '<p><a href="'.$referred.'">Return</a></p>';
                } // Part types array is not empty
            } // Submit function was "add"
         }?>
        <?php endif; ?>
</main>
</body>
<?php
require_once("footer.php");
?>
