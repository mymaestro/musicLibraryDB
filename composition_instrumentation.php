<?php
define('PAGE_TITLE', 'Enter instrumentation');
define('PAGE_NAME', 'Enter instrumentation');
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
require_once("includes/navbar.php");

// Ways to get here:
// 1. Directly from the menu. Select Composition by name, enter default parts, click submit (need form validation)
// 2. From the compositions table. Same as 1, but with Catalog Number preselected
// 3. Edit mode... same as 2, but read the parts table and pre-populate the parts selection
// 4. User mode: Like 3 but view only

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
<main role="main" class="container">
    <div class="container">
        <h1 align="center"><?php echo ORGNAME . ' '. PAGE_NAME ?></h1>
        <?php if($u_librarian) : ?>
    <div id="instrumentation">
        <form action="includes/insert_instrumentation.php" method="post" id="instrumentation_form">
            <div class="row mb-3">
                <div class="col-sm-2 col-form-label">
                    <label for="catalog_number" class="form-label">Catalog number*</label>
                </div>
                <div class="col-md-4">
                    <!-- Choose from a composition in the database -->
                    <!-- Unless one is already provided in the _POST('catalog_number') -->
                    <!-- check if we got here by instr button in list_compositions -->
                <?php
                    require_once('includes/functions.php');
                    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                    // Clicked to get here
                    // $_POST catalog_number=C123
                    // $_POST compositions=Instrumentation
                    if(!empty($_POST["catalog_number"])) {
                        $catalog_number = mysqli_real_escape_string($f_link, $_POST['catalog_number']);
                        $sql = "SELECT `name` FROM compositions WHERE `enabled` = 1 AND `catalog_number` = '".$catalog_number."' ORDER BY name;";
                        $opt = '<input type="hidden" name="catalog_number" value="'.$catalog_number.'" />';
                        $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
                        while ($rowList = mysqli_fetch_array($res)) {
                            $comp_name = $rowList['name'];
                            $opt .= $catalog_number . " - " .$comp_name;
                        }
                        mysqli_close($f_link);
                    } else {
                        $sql = "SELECT `catalog_number`, `name` FROM compositions WHERE `enabled` = 1 ORDER BY name;";
                        //ferror_log("Running " . $sql);
                        $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
                        $opt = "<select class='form-select form-control' aria-label='Select composition' id='catalog_number' name='catalog_number' aria-describedby='catalog_numberHelp'>";
                        while ($rowList = mysqli_fetch_array($res)) {
                            $comp_catno = $rowList['catalog_number'];
                            $comp_name = $rowList['name'];
                            $opt .= "<option value='" . $comp_catno . "'>" . $comp_name . "</option>";
                        }
                        $opt .= "</select>";
                        mysqli_close($f_link);
                    }
                    echo $opt;
                    //ferror_log("returned: " . $sql);
                    ?>
                </div>
                <div class="col-sm-6">
                    <div id="catalog_numberHelp" class="form-text">The catalog number from the composition to set instrumentation.</div>                
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-2 col-form-label">
                    <label for="paper_size" class="form-label">Paper size*</label>
                </div>
                <div class="col-sm-4">
                <?php
                    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                    $sql = "SELECT `id_paper_size`, `name` FROM paper_sizes WHERE `enabled` = 1 ORDER BY name;";
                    //ferror_log("Running " . $sql);
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
                    //ferror_log("returned: " . $sql);
                ?>
                </div>
                <div class="col-sm-6">
                    <div id="paper_sizeHelp" class="form-text">On what size paper the original parts are printed.</div>                
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-2 col-form-label">
                    <label for="page_count" class="form-label">Page count*</label>
                </div>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="page_count" name="page_count" aria-describedby="page_countHelp" required>
                </div>
                <div class="col-sm-6">
                    <div id="page_countHelp" class="form-text">How many pages per part (default).</div>                
                </div>
            </div>
            <hr />
            <div class="row mb-3">
                <div class="col-form-label col-sm-2 pt-0">Instrument parts*</div>
                <div class="col-sm-10 offset-sm-2">
                    <p>Select multiple parts by holding the Shift or Ctrl keys while clicking.</p>
                    <p>Enter single parts <i>and</i> parts that are collections (Percussion I, for example). If a type of part does not appear on the list, check the <a href="parttypes.php">Part types</a> page.</p>
                <!-- Read part types from part_types table -->
                <?php
                    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                    $sql = "SELECT `id_part_type`, `name` FROM part_types WHERE `enabled` = 1 ORDER BY collation;";
                    $rowcount = 0;
                    //ferror_log("Running " . $sql);
                    $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
                    $opt = "<select class='form-select form-control' aria-label='Select part types' id='parttypes' name='parttypes[]' size='17' multiple>";
                    while ($rowList = mysqli_fetch_array($res)) {
                        $rowcount++;
                        $id_part_type = $rowList['id_part_type'];
                        $part_type_name = $rowList['name'];
                        $opt .= "<option value='".$id_part_type ."'>" . $part_type_name . "</option>";
                    }
                    $opt .= "</select>";
                    mysqli_close($f_link);
                    echo $opt;
                    //ferror_log("returned: " . $sql);
                ?>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <button class="btn btn-primary" type="submit" name="submit" value="add">Add parts</button>
                </div>
            </div>
        </form>
    </div>
    <?php else: ?>
    <div id="instrumentation_view">
        <div class="row mb-3">
            <p class="text-center">You must be logged in as a user to see this page</p>
        </div>
        </div>
    </div>
    <?php endif; ?>
</main>
<?php require_once("includes/footer.php");?>
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
            url:"includes/fetch_partscomp.php",
            method:"POST",
            data:{id_part_type:id_part_type},
            dataType:"json",
            success:function(data){
                $('#id_part_type').val(data.id_part_type);
                $('#collation').val(data.collation);
                $('#name').val(data.name);
                $('#description').val(data.description);
                $('#family').val(data.family);
                $('#is_part_collection').val(data.is_part_collection);
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
                url:"includes/insert_parts.php",
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
</body>
</html>
