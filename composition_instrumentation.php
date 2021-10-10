<?php
session_start();
define('PAGE_TITLE', 'Enter instrumentation');
define('PAGE_NAME', 'Enter instrumentation');
require_once("includes/header.php");
error_log("RUNNING composition_instrumentation.php with parttypes=". $_POST["parttypes"]);
$u_admin = FALSE;
$u_user = FALSE;
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $u_admin = (strpos(htmlspecialchars($_SESSION['roles']), 'administrator') !== FALSE ? TRUE : FALSE);
    $u_user = (strpos(htmlspecialchars($_SESSION['roles']), 'user') !== FALSE ? TRUE : FALSE);
}
// Fill the parts table with information from the rows in this form
// Parts table:

//CREATE TABLE `parts` (
//    `catalog_number` varchar(255) NOT NULL DEFAULT '' COMMENT 'Library catalog number of the composition to which this part belongs',
//    `id_part_type` int(10) UNSIGNED NOT NULL COMMENT 'Which type of part, from the part_types table',
//    `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Name of the part, if different from the part type',
//    `description` varchar(255) DEFAULT '' COMMENT 'Description or comments of this particular part',
//    `is_part_collection` int(11) DEFAULT NULL COMMENT 'This is a part collection of other parts',
//    `paper_size` varchar(4) DEFAULT NULL COMMENT 'Physical size, from the paper_sizes table',
//    `page_count` int(11) DEFAULT NULL COMMENT 'How many pages does this part contain?',
//    `image_path` text DEFAULT NULL COMMENT 'Where an image of this part is stored.',
//    `originals_count` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Set greater than 0 if originals of this part exist',
//    `copies_count` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Set greater than 0 if copies of this part exist'
//  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table holds parts.';

// It is expected that all the instrumentation (parts) for a composition will by default have the same
// catalog_number, paper_size, and page_count
// The code inserts a  
?>
<body>
    <?php
    require_once("includes/navbar.php");
    require_once('includes/config.php');
    error_log("RUNNING composition_instrumentation.php");
    ?>
    <br />
    <br />
    <br />
    <div class="container">
        <h1 align="center"><?php echo ORGNAME ?> Add instrumentation</h1>
        <?php if ($u_admin) : ?>
            <div align="right">
                <button type="button" name="add" id="add" data-bs-toggle="modal" data-bs-target="#add_data_Modal" class="btn btn-warning">Add</button>
                <br />
            </div><!-- right -->
        <?php endif; ?>
        <?php
        if(!empty($_POST)) {
            echo '<h4>You selected</h4>';
            echo '<table>';
            // loop over checked checkboxes
            foreach($_POST as $key => $value) {
                echo '<tr><td>'. $key . '</td>';
                echo "    <td>". $value . "</td></tr>";
            }
            if(!empty($_POST['parttypes'])){
                echo "<p>Part types selected:</p>";
                echo "<ol>";
                foreach($_POST['parttypes'] as $selected) {
                    echo "<li>" . $selected . "</li>";
                }
                echo "</ol>";
            }
            echo '</table>';
         }?>
    <div id="instrumentation">
        <form action="composition_instrumentation.php" method="post" id="instrumentation_form">
            <div class="row mb-3">
                <div class="col-sm-2 col-form-label">
                    <label for="catalog_number" class="form-label">Catalog number</label>
                </div>
                <div class="col-md-4">
                    <!-- Choose from a composition in the database -->
                    <!-- Unless one is already provided in the _POST('catalog_number') -->
                <?php
                    require_once('includes/functions.php');
                    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                    $sql = "SELECT `catalog_number`, `name` FROM compositions WHERE `enabled` = 1 ORDER BY name;";
                    //error_log("Running " . $sql);
                    $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
                    $opt = "<select class='form-select form-control' aria-label='Select composition' id='catalog_number' name='catalog_number' aria-describedby='catalog_numberHelp'>";
                    while ($rowList = mysqli_fetch_array($res)) {
                        $comp_catno = $rowList['catalog_number'];
                        $comp_name = $rowList['name'];
                        $opt .= "<option value='" . $comp_catno . "'>" . $comp_name . "</option>";
                    }
                    $opt .= "</select>";
                    mysqli_close($f_link);
                    echo $opt;
                    //error_log("returned: " . $sql);
                    ?>
                </div>
                <div class="col-sm-6">
                    <div id="catalog_numberHelp" class="form-text">The catalog number from the composition to set instrumentation.</div>                
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-2 col-form-label">
                    <label for="paper_size" class="form-label">Paper size</label>
                </div>
                <div class="col-sm-4">
                <?php
                    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                    $sql = "SELECT `id_paper_size`, `name` FROM paper_sizes WHERE `enabled` = 1 ORDER BY name;";
                    //error_log("Running " . $sql);
                    $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
                    $opt = "<select class='form-select form-control' aria-label='Select paper size' id='paper_size' name='paper_size' aria-describedby='paper_sizeHelp'>";
                    while ($rowList = mysqli_fetch_array($res)) {
                        $id_paper_size = $rowList['id_paper_size'];
                        $paper_size_name = $rowList['name'];
                        $opt .= "<option value='" . $id_paper_size . "'>" . $paper_size_name . "</option>";
                    }
                    $opt .= "</select>";
                    mysqli_close($f_link);
                    echo $opt;
                    //error_log("returned: " . $sql);
                ?>
                </div>
                <div class="col-sm-6">
                    <div id="paper_sizeHelp" class="form-text">On what size paper the original parts are printed.</div>                
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-2 col-form-label">
                    <label for="page_count" class="form-label">Page count</label>
                </div>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="page_count" name="page_count" aria-describedby="page_countHelp">
                </div>
                <div class="col-sm-6">
                    <div id="page_countHelp" class="form-text">How many pages per part (default).</div>                
                </div>
            </div>
            <hr />
            <div class="row mb-3">
                <legend class="col-form-label col-sm-2 pt-0">Instrument parts</legend>
                <div class="col-sm-10 offset-sm-2">
                <!-- Read part types from part_types table -->
                <?php
                    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                    $sql = "SELECT `id_part_type`, `name` FROM part_types WHERE `enabled` = 1 ORDER BY collation;";
                    $rowcount = 0;
                    //error_log("Running " . $sql);
                    $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
                    while ($rowList = mysqli_fetch_array($res)) {
                        $rowcount++;
                        $id_part_type = $rowList['id_part_type'];
                        $part_type_name = $rowList['name'];
                        echo '<div class="form-check">';
                        echo '<input class="form-check-input form-check-input-lg" type="checkbox" name="parttypes[]" id="parttypes' . $rowcount .'" value="'. $id_part_type .'">';
                        echo '<label class="form-check-label" for="parttypes'.$rowcount .'">';
                        echo '            '. $part_type_name;
                        echo '</label>';
                        echo '</div>';
                    }
                    mysqli_close($f_link);
                    //error_log("returned: " . $sql);
                ?>
            </div>
            <div class="row mb-3" align="right">
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
        </form>
    </div>
    <!-- jquery function to add/update database records -->
    <script>
    $(document).ready(function(){
        $('#add').click(function(){
            $('#insert').val("Insert");
            $('#update').val("add");
            $('#instrumentation_form')[0].reset();
        });
        $(document).on('click', '.edit_data', function(){
            var id_part_type = $(this).attr("id");
            $.ajax({
                url:"fetch_partscomp.php",
                method:"POST",
                data:{id_part_type:id_part_type},
                dataType:"json",
                success:function(data){
                    $('#id_part_type').val(data.id_part_type);
                    $('#collation').val(data.collation);
                    $('#name').val(data.name);
                    $('#description').val(data.description);
                    $('#family').val(data.family);
                    $('#id_part_collection').val(data.id_part_collection);
                    if ((data.enabled) == 1) {
                        $('#enabled').prop('checked',true);
                    }
                    $('#insert').val("Update");
                    $('#update').val("update");
                    $('#add_data_Modal').modal('show');

                }
           });
        });
        $('#insert_form').on("submit", function(event){
            event.preventDefault();
            if($('#name').val() == "")
            {
                alert("Part type name is required");
            }
            else if($('#collation').val() == '')
            {
                alert("Sort order is required");
            }
            else
            {
                $.ajax({
                    url:"insert_parttypes.php",
                    method:"POST",
                    data:$('#insert_form').serialize(),
                    beforeSend:function(){
                        $('#insert').val("Inserting");
                    },
                    success:function(data){
                        $('#insert_form')[0].reset();
                        $('#add_data_Modal').modal('hide');
                        $('#part_type_table').html(data);
                    }
                });
            }
        });
    });
    </script>
<?php
require_once("includes/footer.php");
?>