<?php
session_start();
define('PAGE_TITLE', 'List parts');
define('PAGE_NAME', 'Parts');
require_once("includes/header.php");
require_once('includes/config.php');
require_once('includes/functions.php');
$u_admin = FALSE;
$u_user = FALSE;
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $u_admin = (strpos(htmlspecialchars($_SESSION['roles']), 'administrator') !== FALSE ? TRUE : FALSE);
    $u_user = (strpos(htmlspecialchars($_SESSION['roles']), 'user') !== FALSE ? TRUE : FALSE);
}
?>
<body>
    <?php
    require_once("includes/navbar.php");
    ferror_log("RUNNING list_parts.php");
    ?>
    <br />
    <div class="container">
        <h2 align="center"><?php echo ORGNAME ?> Instrument parts</h2>
        <?php if ($u_user) : ?>
            <div align="right">
                <button type="button" name="add" id="add" data-bs-toggle="modal" data-bs-target="#add_data_Modal" class="btn btn-warning">Add</button>
                <br />
            </div><!-- right -->
        <?php endif; ?>
        <div id="parts_table">
            <div class="accordion accordion-flush" id="parts_accordion">
                <?php
                $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                $sql = "SELECT p.catalog_number,
                               c.name title,
                               p.id_part_type,
                               y.name part_type,
                               y.collation,
                               p.name,
                               p.description,
                               p.is_part_collection,
                               p.paper_size,
                               z.name paper,
                               p.page_count,
                               p.image_path,
                               p.originals_count,
                               p.copies_count
                        FROM   parts p
                        JOIN   compositions c
                        ON     p.catalog_number = c.catalog_number
                        JOIN   part_types y
                        ON     y.id_part_type = p.id_part_type
                        JOIN   paper_sizes z
                        ON     z.id_paper_size = p.paper_size
                        ORDER BY catalog_number, y.collation;";

                $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
                $old_catalog_number = "xyzzy";
                while ($rowList = mysqli_fetch_array($res)) {
                    $catalog_number = $rowList['catalog_number'];
                    $title = $rowList['title'];
                    $id_part_type = $rowList['id_part_type'];
                    $part_type = $rowList['part_type'];
                    $is_part_collection = $rowList['is_part_collection'];
                    $paper = $rowList['paper'];
                    $page_count = $rowList['page_count'];
                    $name = $rowList['name'];
                    $description = $rowList['description'];
                    $originals_count = $rowList['originals_count'];
                    $copies_count = $rowList['copies_count'];

                    if ($catalog_number != $old_catalog_number) {
                        if ($old_catalog_number != "xyzzy") {
                            echo '
                                </tbody>
                           </table>
                           </div><!-- table-responsive -->
                        </div><!-- section' . $old_catalog_number . ' -->
                    </div><!-- class panel -->';
                        } // End the table, and not the very first one
                        echo '
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-' . $catalog_number . '">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-' . $catalog_number . '" aria-expanded="false" aria-controls="collapse-' . $catalog_number . '">
                                '. $catalog_number .': '. $title .'
                            </button>
                        </h2>
                        <div id="collapse-' . $catalog_number . '" class="accordion-collapse collapse" aria-labelledby="heading-'. $catalog_number .'" data-bs-parent="parts_accordion">
                            <div class="accordion-body">
                                <div class="table-repsonsive">
                                <table class="table table-hover">
                                    <caption class="title">' . $title . ' parts</caption>
                                    <thead>
                                    <tr>
                                        <th>Part type</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Paper size</th>
                                        <th>Pages</th>
                                        <th>Collection</th>
                                        <th>Originals</th>
                                        <th>Copies</th>
                                    </tr>
                                    </thead>
                                    <tbody>';
                        $old_catalog_number = $catalog_number;
                    }
                    $table_row_class = "";
                    if ($copies_count == 0) {
                        $table_row_class = "table-warning";
                    }
                    if ($originals_count == 0) {
                        $table_row_class = "table-danger";
                    }

                    echo '<tr class="'. $table_row_class .'">
                                    <td>' . $part_type . '</td>
                                    <td>' . $name . '</td>
                                    <td>' . $description . '</td>
                                    <td>' . $paper . '</td>
                                    <td>' . $page_count . '</td>
                                    <td>' . $is_part_collection . '</td>
                                    <td>' . $originals_count . '</td>
                                    <td>' . $copies_count . '</td>';
                    if ($u_user) {
                        echo '
                                    <td><input type="button" name="delete" value="Delete" id="' . $catalog_number . '-' . $id_part_type . '" class="btn btn-danger btn-sm delete_data" /></td>
                                    <td><input type="button" name="edit" value="Edit" id="' . $catalog_number . '-' . $id_part_type . '" class="btn btn-primary btn-sm edit_data" /></td>';
                    }
                    echo '
                                    <td><input type="button" name="view" value="View" id="' . $catalog_number . '-' . $id_part_type  . '" class="btn btn-secondary btn-sm view_data" /></td>
                                </tr>
                                ';
                }
                echo '
                                </tbody>
                           </table>
                           </div><!-- table-responsive -->
                        </div><!-- accordion-body-' . $old_catalog_number . ' -->
                    </div><!-- accordion-item -->
                ';
                mysqli_close($f_link);
                // ferror_log("returned: " . $sql);
                ?>
            </div><!-- accordion -->
        </div><!-- parts_table -->
    </div><!-- container -->
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
    <div id="deleteModal" class="modal" tabindex="-1" role="dialog"><!-- delete data -->
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
                        <form method="post" id="insert_form">
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
                                    $opt = "<select class='form-select form-control' aria-label='Select part typee' id='id_part_type' name='id_part_type'>";
                                    while ($rowList = mysqli_fetch_array($res)) {
                                        $id_part_type = $rowList['id_part_type'];
                                        $part_type_name = $rowList['name'];
                                        $opt .= "<option value='" . $id_part_type . "'>" . $part_type_name . "</option>";
                                    }
                                    $opt .= "</select>";
                                    mysqli_close($f_link);
                                    echo $opt;
                                    //error_log("returned: " . $sql);
                                    ?>
                                    <input type="hidden" id="id_part_type_hold" name="id_part_type_hold" value="" />
                                </div>
                                <div class="col-md-3">
                                    <label for="catalog_number" class="col-form-label">Catalog number*</label>
                                </div>
                                <div class="col-md-4">
                                    <?php
                                    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                                    $sql = "SELECT `catalog_number`, `name` FROM compositions WHERE `enabled` = 1 ORDER BY name;";
                                    //error_log("Running " . $sql);
                                    $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
                                    $opt = "<select class='form-select form-control' aria-label='Select composition' id='catalog_number' name='catalog_number'>";
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
                                    $opt = "<select class='form-select form-control' aria-label='Select paper size' id='paper_size' name='paper_size'>";
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
                            </div><!-- row -->
                            <div class="row"><div class="col-auto"><hr /></div></div><!-- blank row -->
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
                                    <div class="col-md-8">
                                        <label for="image_path" class="col-form-label">If this part has more than one instrument, enter the number of instruments on the part.</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" class="form-control" id="is_part_collection" name="is_part_collection" aria-label="Part collection" />
                                    </div>
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
    <!-- jquery function to add/update database records -->
    <script>
        $(document).ready(function() {
            $('#add').click(function() {
                $('#insert').val("Insert");
                $('#update').val("add");
                $('#insert_form')[0].reset();
            });
            $(document).on('click', '.edit_data', function() {
                var part_id = $(this).attr("id");
                var catalog_number = part_id.split('-')[0];
                var id_part_type = part_id.split('-')[1];
                $.ajax({
                    url: "fetch_parts.php",
                    method: "POST",
                    data: {
                        id_part_type: id_part_type,
                        catalog_number: catalog_number
                    },
                    dataType: "json",
                    success: function(data) {
                        $('#catalog_number').val(data.catalog_number);
                        $('#catalog_number_hold').val(data.catalog_number);
                        $('#id_part_type').val(data.id_part_type);
                        $('#id_part_type_hold').val(data.id_part_type);
                        $('#name').val(data.name);
                        $('#description').val(data.description);
                        $('#is_part_collection').val(data.is_part_collection);
                        $('#paper_size').val(data.paper_size);
                        $('#page_count').val(data.page_count);
                        $('#image_path').val(data.image_path);
                        $('#originals_count').val(data.originals_count);
                        $('#copies_count').val(data.copies_count);
                        $('#insert').val("Update");
                        $('#update').val("update");
                        $('#add_data_Modal').modal('show');
                    }
                });
            });
            $(document).on('click', '.delete_data', function(){ // button that brings up modal
                // input button name="delete" id="id_part" class="delete_data"
                var part_id = $(this).attr("id");
                $('#deleteModal').modal('show');
                $('#confirm-delete').data('id', part_id);
                $('#part2delete').text(part_id);
            });
            $('#confirm-delete').click(function(){
                // The confirm delete button
                var part_id = $(this).data('id');
                var catalog_number = part_id.split('-')[0];
                var id_part_type = part_id.split('-')[1];
                $.ajax({
                    url:"delete_parts.php",
                    method:"POST",
                    data:{
                        catalog_number: catalog_number,
                        id_part_type: id_part_type
                    },
                    success:function(data){
                        $('#insert_form')[0].reset();
                        $('#parts_table').html(data);
                    }
                });
            });
            $('#insert_form').on("submit", function(event) {
                event.preventDefault();
                if ($('#id_part_type').val() == "") {
                    alert("Part type ID is required");
                } else if ($('#catalog_number').val() == '') {
                    alert("Catalog number is required");
                } else {
                    $.ajax({
                        url: "insert_parts.php",
                        method: "POST",
                        data: $('#insert_form').serialize(),
                        beforeSend: function() {
                            $('#insert').val("Inserting");
                        },
                        success: function(data) {
                            $('#insert_form')[0].reset();
                            $('#add_data_Modal').modal('hide');
                            $('#parts_table').html(data);
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
                        url: "select_parts.php",
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
    <?php
    require_once("includes/footer.php");
    ?>