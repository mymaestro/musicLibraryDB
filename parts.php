<?php
define('PAGE_TITLE', 'List parts');
define('PAGE_NAME', 'Parts');
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
require_once('includes/functions.php');
ferror_log("RUNNING parts.php");
?>
<main role="main">
    <div class="container">
        <h2 align="center"><?php echo ORGNAME ?> Instrument parts</h2>
        <hr>
        <div class="row">
            <div class="d-flex col-3">
                <div class="bg-light vh-100">
                    <div class="list-group overflow-auto h-100" id="parts_list">
                        <p class="d-flex align-content-center flex-wrap lead">Compositions with parts</p>
                    </div>
                </div>
            </div><!-- (Compositions) parts_list -->
            <div class="d-flex col-9" id="parts_table">
                <p class="d-flex align-content-center flex-wrap lead">Choose a composition from the menu on the left.</p>
            </div><!-- (Parts) parts_table -->
        </div>
        <div id="dataModal" class="modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Part details</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div><!-- modal-header -->
                    <div class="modal-body" id="part_detail">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div><!-- modal-footer -->
                </div><!-- modal-content -->
            </div><!-- modal-dialog -->
        </div><!-- dataModal -->
        <div id="deleteModal" class="modal" tabindex="-1" role="dialog">
            <!-- delete data -->
            <div class="modal-dialog" role="document">
                <div class="modal-content rounded-4 shadow">
                    <div class="modal-body p-4 text-center">
                        <h5 class="mb-0">Delete this part?</h5>
                        <p id="part2delete">You can cancel now.</p>
                    </div>
                    <div class="modal-footer flex-nowrap p-0">
                        <button type="button" class="btn btn-lg btn-link text-decoration-none rounded-0 border-right" id="confirm-delete" data-bs-dismiss="modal"><strong>Yes, delete</strong></button>
                        <button type="button" class="btn btn-lg btn-link text-decoration-none rounded-0" data-bs-dismiss="modal">No thanks</button>
                    </div><!-- modal-footer -->
                </div><!-- modal-content -->
            </div><!-- modal-dialog -->
        </div><!-- deleteModal -->
        <div id="add_data_Modal" class="modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Part information</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div><!-- modal-header -->
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form action="includes/insert_parts.php" method="post" id="insert_form">
                                <div class="row bg-light">
                                    <div class="col-md-2">
                                        <label for="id_part_type" class="col-form-label">Part type*</label>
                                    </div>
                                    <div class="col-md-3">
                                        <!-- Read part types from part_types table -->
                                        <?php
                                        $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                                        $sql = "SELECT `id_part_type`, `name` FROM part_types WHERE `enabled` = 1 ORDER BY collation;";
                                        //error_log("Running " . $sql);
                                        $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
                                        $opt = "<select class='form-select form-control' aria-label='Select part typee' id='id_part_type' name='id_part_type'>".PHP_EOL;
                                        while ($rowList = mysqli_fetch_array($res)) {
                                            $id_part_type = $rowList['id_part_type'];
                                            $part_type_name = $rowList['name'];
                                            $opt .= "                                           <option value='" . $id_part_type . "'>" . $part_type_name . "</option>" . PHP_EOL;
                                        }
                                        $opt .= "                                        </select>" . PHP_EOL;
                                        mysqli_close($f_link);
                                        echo $opt;
                                        //error_log("returned: " . $sql);
                                        ?>
                                        <input type="hidden" id="id_part_type_hold" name="id_part_type_hold" value="" />
                                        <input type="hidden" id="is_part_collection" name="is_part_collection" value="0" />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="catalog_number" class="col-form-label">Catalog number*</label>
                                    </div>
                                    <div class="col-md-4">
                                        <?php
                                        $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                                        $sql = "SELECT `catalog_number`, `name` FROM compositions ORDER BY catalog_number;";
                                        //error_log("Running " . $sql);
                                        // Need to preselect
                                        $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
                                        $opt = "<select class='form-select form-control' aria-label='Select composition' id='catalog_number' name='catalog_number'>".PHP_EOL;
                                        while ($rowList = mysqli_fetch_array($res)) {
                                            $comp_catno = $rowList['catalog_number'];
                                            $comp_name = $rowList['name'];
                                            $opt .= '                                            <option value="' . $comp_catno . '">' . $comp_catno . ': ' . $comp_name . '</option>' . PHP_EOL;
                                        }
                                        $opt .= "                                        </select>". PHP_EOL ;
                                        mysqli_close($f_link);
                                        echo $opt;
                                        //error_log("returned: " . $sql);
                                        ?>
                                        <input type="hidden" id="catalog_number_hold" name="catalog_number_hold" value="" />
                                    </div>
                                </div><!-- row -->
                                <div class="row bg-light">
                                    <div class="col-md-2">
                                        <label class="col-form-label">Pages*</label>
                                    </div>
                                    <div class="col-md-3">
                                        <!-- How many pages -->
                                        <input type="number" class="form-control" id="page_count" name="page_count" aria-label="Page count" min="1" max="12" required />
                                    </div>
                                    <div class="col-md-3">
                                        <!-- Request paper size -->
                                        <label for="paper_size" class="col-form-label">Paper size</label>
                                    </div>
                                    <div class="col-md-4">
                                        <?php
                                        $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                                        $sql = "SELECT `id_paper_size`, `name` FROM paper_sizes WHERE `enabled` = 1 ORDER BY name;";
                                        //error_log("Running " . $sql);
                                        $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
                                        $opt = "<select class='form-select form-control' aria-label='Select paper size' id='paper_size' name='paper_size'>".PHP_EOL;
                                        while ($rowList = mysqli_fetch_array($res)) {
                                            $id_paper_size = $rowList['id_paper_size'];
                                            $paper_size_name = $rowList['name'];
                                            $opt .= "                                            <option value='" . $id_paper_size . "'>" . $paper_size_name . "</option>" . PHP_EOL;
                                        }
                                        $opt .= "                                        </select>";
                                        mysqli_close($f_link);
                                        echo $opt;
                                        //error_log("returned: " . $sql);
                                        ?>
                                    </div>
                                </div><!-- row -->
                                <div class="row">
                                    <div class="col-auto">
                                        <hr />
                                    </div>
                                </div><!-- blank row -->
                                <div class="row bg-light">
                                    <div class="col-md-2">
                                        <label class="col-form-label">Originals count*</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" class="form-control" id="originals_count" name="originals_count" min="0" max="999" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label class="col-form-label">Copies count*</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" class="form-control" id="copies_count" name="copies_count" min="0" max="999" required />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="col-form-label">Name</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Name (optional)" />
                                    </div>
                                </div>
                                <div class="row bg-light">
                                    <div class="col-md-2">
                                        <label class="col-form-label">Description</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="description" name="description" placeholder="Description (optional)" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="d-flex" id="part_instruments">
                                        <div class="col-md-2">
                                            <label for="id_instrument_list" class="col-form-label">Instrument(s) on the part.</br></br>* default</label>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-select form-control text-muted d-flex" aria-label="Select instrument" id="id_instrument_list" name="id_instrument_list[]" multiple>
                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                        </br>
                                            <p class="text-center">
                                                <button type="button" class="btn btn-light" name="add_instrument" id="add_instrument"><i class="fa fa-angle-right"></i></button>
                                            </br>
                                                <button type="button" class="btn btn-light" id="remove_instrument"><i class="fa fa-angle-left"></i></button>
                                            </p>
                                        </div>
                                        <div class="col-md-5">
                                            <select class="form-select form-control d-flex" aria-label="Select instrument" id="id_instrument" name="id_instrument[]" multiple>
                                            </select>
                                        </div>
                                    </div><!-- part_instruments -->
                                </div>
                                <div class="row bg-light">
                                    <div class="col-md-2">
                                        <label for="image_path" class="col-form-label">Image path</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="image_path" name="image_path" aria-label="Image path" placeholder="https://acwe.org/parts/flute1.pdf (optional)" />
                                    </div>
                                </div>
                        </div><!-- container-fluid -->
                    </div><!-- modal-body -->
                    <div class="modal-footer">
                        <input type="hidden" name="update" id="update" value="0" />
                        <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" />
                        </form>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div><!-- modal-footer -->
                </div><!-- modal-content -->
            </div><!-- modal-dialog -->
        </div><!-- add_data_modal -->
    </div><!-- container -->

</main>
<?php require_once("includes/footer.php"); ?>
<script>
// Load instruments into a JSON array
<?php
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$sql = "SELECT `id_instrument`, `collation`, `name` FROM instruments WHERE `enabled` = 1 ORDER BY collation;";
ferror_log("Running " . $sql);
$res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
$jsondataArray = "var instrumentdataArray = [";
$jsondata = "var instrumentdata = {";
while($rowList = mysqli_fetch_array($res)) {
    $id_instrument = $rowList['id_instrument'];
    $collation = $rowList['collation'];
    $instrument_name = $rowList['name'];
    $jsondataArray .= '{"collation":'.$collation.',"id":'.$id_instrument.',"name":"'.$instrument_name.'"},';
    $jsondata .= '"'.$id_instrument.'":"'.$instrument_name.'",';
}
$jsondata = rtrim($jsondata, ',');
$jsondata .= '}'.PHP_EOL;
$jsondataArray = rtrim($jsondataArray, ',');
$jsondataArray .= ']'.PHP_EOL;
mysqli_close($f_link);
echo $jsondata;
echo $jsondataArray;
ferror_log("returned: " . $sql);
?>
// jquery functions to add/update database records
$(document).ready(function() {
    $.ajax({
        url:"includes/fetch_parts.php",
        method:"POST",
        data:{
            user_role: "<?php echo ($u_librarian) ? 'librarian' : 'nobody'; ?>"
        },   
        success:function(data){
            $('#parts_list').html(data);
            <?php
            if(isset($_POST["catalog_number"])){
                $catalog_select = "catno_".$_POST["catalog_number"];
                echo '    $("#'.$catalog_select.'").trigger("click");'.PHP_EOL;
            }
            ?>
        }
    });
    $("#parts_list").on('click','.list-group-item-action',function(e) {
        e.preventDefault();
        var catno_select = $(this).attr("id");
        var catno_name = $(this).closest('a').text();
        const regex = /^catno_/i
        var catalog_number = catno_select.replace(regex, '');
        $.ajax({
            url: "includes/fetch_parts.php",
            method: "POST",
            data: {
                catalog_number: catalog_number,
                user_role: "<?php echo ($u_librarian) ? 'librarian' : 'nobody'; ?>"
            },
            success: function(data) {
                $('#parts_table').html(data);
                $('#composition_header').text(catno_name);
            }
        });
    });
    $('#add').click(function() {
        $('#insert').val("Insert");
        $('#update').val("add");
        $('#insert_form')[0].reset();
    });
    $("#add_instrument").click(function() {
        $("#id_instrument_list :selected").each(function(){
            //alert("selected " + key + ":"+ value);
            optionval = $(this).val();
            optiontext = instrumentdata[optionval];
            $('#id_instrument').append($('<option/>',{
               value: optionval,
               text: optiontext
            }));
        });
    });
    $('#remove_instrument').click(function() {
        $("#id_instrument :selected").each(function(){
            $(this).remove();
        });
    });
    $(document).on('click', '.edit_data', function() {
        var part_id = $(this).attr("id");
        var catalog_number = part_id.split('-')[0];
        var id_part_type = part_id.split('-')[1];
        $.ajax({
            url: "includes/fetch_parts.php",
            method: "POST",
            data: {
                id_part_type: id_part_type,
                catalog_number: catalog_number
            },
            dataType: "json",
            success: function(result) {
                const obj = JSON.parse(result);
                var part=obj.part;
                var inst_options=obj.instruments;
                var selectitems = '';
                $.each(instrumentdataArray, function(key, value) {
                    selectitems += '<option value=' + value.id + '>' + value.name + '</option>';
                    $(".instrument_" + value.id).text(value.name);
                });
                $('#id_instrument_list').html(selectitems);
                selectitems = '';
                $.each(inst_options, function(key, value) {
                    selectitems += '<option value=' + value.id_instrument_key + '>' + instrumentdata[value.id_instrument_key] + '</option>';
                });
                if(selectitems == '' && part.default_instrument !== null ) {
                    selectitems += '<option value=' + part.default_instrument + '>' + instrumentdata[part.default_instrument] + '*</option>';
                }
                $('#id_instrument').html(selectitems);
                selectitems = '';
                $('#catalog_number').val(part.catalog_number);
                $('#catalog_number_hold').val(part.catalog_number);
                $('#id_part_type').val(part.id_part_type);
                $('#id_part_type_hold').val(part.id_part_type);
                $('#name').val(part.name);
                $('#description').val(part.description);
                $('#is_part_collection').val(part.is_part_collection);
                $('#paper_size').val(part.paper_size);
                $('#page_count').val(part.page_count);
                $('#image_path').val(part.image_path);
                $('#originals_count').val(part.originals_count);
                $('#copies_count').val(part.copies_count);
                $('#insert').val("Update");
                $('#update').val("update");
                $('#add_data_Modal').modal('show');
            }
        });
    });
    $(document).on('click', '.delete_data', function() { // button that brings up Delete this part? modal
        var part_id = $(this).attr("id");
        var id_part_type = part_id.split('-')[1];
        var part_name = instrumentdata[id_part_type];
        $('#deleteModal').modal('show');
        $('#confirm-delete').data('id', part_id);
        $('#part2delete').text(part_name);
    });
    $('#confirm-delete').click(function() {
        catno_name = $('#composition_header').text();
        // The confirm delete button
        var part_id = $(this).data('id');
        var catalog_number = part_id.split('-')[0];
        var id_part_type = part_id.split('-')[1];
        $.ajax({
            url: "includes/delete_parts.php",
            method: "POST",
            data: {
                catalog_number: catalog_number,
                id_part_type: id_part_type
            },
            success: function(data) {
                $('#insert_form')[0].reset();
                $.ajax({
                    url: "includes/fetch_parts.php",
                    method: "POST",
                    data: {
                        catalog_number: catalog_number,
                        user_role: "<?php echo ($u_librarian) ? 'librarian' : 'nobody'; ?>"
                    },
                    success: function(data) {
                        $('#parts_table').html(data);
                        $('#composition_header').text(catno_name);
                    }
                });
            }
        });
    });
    $('#insert_form').on("submit", function(event) {
        catno_name = $('#composition_header').text();
        event.preventDefault();
        if ($('#id_part_type').val() == "") {
            alert("Part type ID is required");
        } else if ($('#catalog_number').val() == '') {
            alert("Catalog number is required");
        } else {
            catalog_number = $('#catalog_number').val();
            $('#id_instrument option').prop('selected',true);
            $.ajax({
                url: "includes/insert_parts.php",
                method: "POST",
                data: $('#insert_form').serialize(),
                beforeSend: function() {
                    $('#insert').val("Inserting");
                },
                success: function(data) {
                    $('#insert_form')[0].reset();
                    $('#add_data_Modal').modal('hide');
                    $.ajax({
                        url: "includes/fetch_parts.php",
                        method: "POST",
                        data: {
                            catalog_number: catalog_number,
                            user_role: "<?php echo ($u_librarian) ? 'librarian' : 'nobody'; ?>"
                        },
                        success: function(data) {
                            $('#parts_table').html(data);
                            $('#composition_header').text(catno_name);
                        }
                    });
                }
            });
        }
    });
    $(document).on('click', '.view_data', function() {
        var part_id = $(this).attr("id");
        var catalog_number = part_id.split('-')[0];
        var id_part_type = part_id.split('-')[1];
        if (id_part_type != '') {
            $.ajax({
                url: "includes/select_parts.php",
                method: "POST",
                data: {
                    id_part_type: id_part_type,
                    catalog_number: catalog_number
                },
                success: function(data) {
                    $('#part_detail').html(data);
                    $('#dataModal').modal('show');
                }
            });
        }
    });
});
</script>
</body>

</html>