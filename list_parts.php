<?php
session_start();
define('PAGE_TITLE', 'List parts');
define('PAGE_NAME', 'Parts');
require_once("includes/header.php");
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
    error_log("RUNNING list_parts.php");
    ?>
    <br />
    <div class="container">
        <h2 align="center"><?php echo ORGNAME ?> Instrument parts</h2>
        <?php if ($u_admin) : ?>
            <div align="right">
                <button type="button" name="add" id="add" data-bs-toggle="modal" data-bs-target="#add_data_Modal" class="btn btn-warning">Add</button>
                <br />
            </div><!-- right -->
        <?php endif; ?>
        <div id="parts_table">
            <div id="accordion">
                <?php
                require_once('includes/config.php');
                require_once('includes/functions.php');
                $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                $sql = "SELECT * FROM parts ORDER BY catalog_number;";
                $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
                $oldPortfolio = "xyzzy";
                while ($rowList = mysqli_fetch_array($res)) {
                    $id_part = $rowList['id_part'];
                    $catalog_number = $rowList['catalog_number'];
                    $id_part_type = $rowList['id_part_type'];
                    $name = $rowList['catalog_number'];
                    $description = $rowList['description'];
                    $originals_count = $rowList['originals_count'];
                    $copies_count = $rowList['copies_count'];

                    if ($portfolio != $oldPortfolio) {
                        if ($oldPortfolio != "xyzzy") {
                            echo '
                                </tbody>
                           </table>
                           </div><!-- table-responsive -->
                        </div><!-- section' . $oldPortfolio . ' -->
                    </div><!-- class panel -->';
                        } // End the table, and not the very first one
                        echo '
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="header' . $portfolio . '">
                            <h4 class="panel-title">
                              <a data-bs-toggle="collapse" data-bs-parent="#accordion" href="#section' . $portfolio . '" aria-expanded="true" aria-controls="section' . $portfolio . '">' . $portfolio . '</a>
                            </h4>
                        </div><!-- div panel-heading -->
                        <div id="section' . $portfolio . '" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="header' . $portfolio . '">
                            <div class="table-repsonsive">
                            <table class="table table-hover">
                                <caption class="title">Available ' . $portfolio . ' parts</caption>
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Catalog number</th>
                                    <th>Part type</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Originals</th>
                                    <th>Copies</th>
                                </tr>
                                </thead>
                                <tbody>';
                        $oldPortfolio = $portfolio;
                    }
                    echo '<tr>
                                    <td>' . $id_part . '</td>
                                    <td>' . $catalog_number . '</td>
                                    <td>' . $id_part_type . '</td>
                                    <td>' . $name . '</td>
                                    <td>' . $description . '</td>
                                    <td>' . $originals_count . '</td>
                                    <td>' . $copies_count . '</td>';
                    if ($u_admin) {
                        echo '
                                    <td><input type="button" name="edit" value="Edit" id="' . $rowID . '" class="btn btn-primary btn-sm edit_data" /></td>';
                    }
                    echo '
                                    <td><input type="button" name="view" value="View" id="' . $rowID . '" class="btn btn-secondary btn-sm view_data" /></td>
                                </tr>
                                ';
                }
                echo '
                                </tbody>
                           </table>
                           </div><!-- table-responsive -->
                        </div><!-- section' . $oldPortfolio . ' -->
                    </div><!-- class panel -->
                ';
                mysqli_close($f_link);
                // error_log("returned: " . $sql);
                ?>
            </div><!-- accordion -->
        </div><!-- parts_table -->
    </div><!-- container -->

    <div id="dataModal" class="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Part details</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                </div><!-- modal-header -->
                <div class="modal-body" id="part_detail">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                </div><!-- modal-footer -->
            </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- dataModal -->
    <div id="add_data_Modal" class="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Part information</h4>
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div><!-- modal-header -->
                <div class="modal-body">
                    <div class="container-fluid">
                        <form method="post" id="insert_form">
                            <div class="row bg-light">
                                <div class="col-md-2">
                                    <label for="id_part" class="col-form-label">Part ID*</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="id_part" name="id_part" placeholder="P00001" required />
                                    <input type="hidden" id="id_part_hold" name="id_part_hold" value="" />
                                </div>
                                <div class="col-md-3">
                                    <label for="catalog_number" class="col-form-label">Catalog number*</label>
                                </div>
                                <div class="col-md-4">
                                    <?php
                                    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                                    $sql = "SELECT `catalog_number`, `name` FROM compositions WHERE `enabled` = 1 ORDER BY catalog_number;";
                                    error_log("Running " . $sql);
                                    $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
                                    $opt = "<select class='form-select form-control' aria-label='Select composition' id='title' name='title'>";
                                    while ($rowList = mysqli_fetch_array($res)) {
                                        $comp_catno = $rowList['catalog_number'];
                                        $comp_name = $rowList['name'];
                                        $opt .= "<option value='" . $comp_catno . "'>" . $comp_name . "</option>";
                                    }
                                    $opt .= "</select>";
                                    mysqli_close($f_link);
                                    echo $opt;
                                    error_log("returned: " . $sql);
                                    ?>
                                </div>
                            </div><!-- row -->
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="col-form-label">Part type*</label>
                                </div>
                                <div class="col-md-3">
                                    <!-- Read part types from part_types table -->
                                    <?php
                                    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                                    $sql = "SELECT `id_part_type`, `name` FROM part_types WHERE `enabled` = 1 ORDER BY collation;";
                                    error_log("Running " . $sql);
                                    $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
                                    $opt = "<select class='form-select form-control' aria-label='Select part typee' id='part_type' name='part_type'>";
                                    while ($rowList = mysqli_fetch_array($res)) {
                                        $id_part_type = $rowList['id_part_type'];
                                        $part_type_name = $rowList['name'];
                                        $opt .= "<option value='" . $id_part_type . "'>" . $part_type_name . "</option>";
                                    }
                                    $opt .= "</select>";
                                    mysqli_close($f_link);
                                    echo $opt;
                                    error_log("returned: " . $sql);
                                    ?>
                                </div>
                                <div class="col-md-3">
                                    <!-- request paper size -->
                                    <label for="paper_size" class="col-form-label">Paper size</label>
                                </div>
                                <div class="col-md-4">
                                    <?php
                                    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                                    $sql = "SELECT `id_paper_size`, `name` FROM paper_sizes WHERE `enabled` = 1 ORDER BY name;";
                                    error_log("Running " . $sql);
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
                                    error_log("returned: " . $sql);
                                    ?>
                                </div>
                                </div>
                                <div class="row bg-light">
                                    <div class="col-md-2">
                                        <label class="col-form-label">Pages*</label>
                                    </div>
                                    <div class="col-md-3">
                                        <!-- How many pages -->
                                        <input type="number" class="form-control" id="page_count" name="page_count" aria-label="Page count" min="1" max="12" />
                                    </div>

                                </div>
                                <div class="col-md-4">
                                </div>
                                <hr />
                                <div class="row bg-light">
                                    <div class="col-md-2">
                                        <label class="col-form-label">Originals count*</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" class="form-control" id="originals_count" name="originals_count" min="0" max="999" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label class="col-form-label">Copies count</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" class="form-control" id="copies_count" name="copies_count" min="0" max="999" />
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
                                    <div class="col-md-2">
                                        <label for="image_path" class="col-form-label">Image path</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="image_path" name="image_path" aria-label="Image path" placeholder="https://acwe.org/parts/flute1.pdf (optional)" />
                                    </div>
                                </div>
                                <hr />
                                <input type="hidden" name="part_id" id="part_id" />
                                <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" />
                        </form>
                    </div><!-- container-fluid -->
                </div><!-- modal-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                </div><!-- modal-footer -->
            </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- add_data_modal -->
    <!-- jquery function to add/update database records -->
    <script>
        $(document).ready(function() {
            $('#add').click(function() {
                $('#insert').val("Insert");
                $('#insert_form')[0].reset();
            });
            $(document).on('click', '.edit_data', function() {
                var part_id = $(this).attr("id");
                $.ajax({
                    url: "fetch_parts.php",
                    method: "POST",
                    data: {
                        part_id: part_id
                    },
                    dataType: "json",
                    success: function(data) {
                        $('#id_part').val(data.id_part);
                        $('#id_part_hold').val(data.id_part);
                        $('#catalog_number').val(data.catalog_number);
                        $('#id_part_type').val(data.id_part_type);
                        $('#name').val(data.name);
                        $('#description').val(data.description);
                        $('#originals_count').val(data.originals_count);
                        $('#copies_count').val(data.copies_count);
                        $('#insert').val("Update");
                        $('#add_data_Modal').modal('show');
                    }
                });
            });
            $(document).on('click', '.delete_data', function() {
                var part_id = $(this).attr("id");
                $.ajax({
                    url: "delete_records.php",
                    method: "POST",
                    data: {
                        table_name: "parts",
                        table_key_name: "id_part",
                        table_key: id_part
                    },
                    dataType: "json",
                    success: function(data) {
                        $('#part_detail').html(data)
                        $('#dataModal').modal('show');
                    }
                });
            });
            $('#insert_form').on("submit", function(event) {
                event.preventDefault();
                if ($('#id_part').val() == "") {
                    alert("Part ID is required");
                } else if ($('#id_part').val() == '') {
                    alert("part ID is required");
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
                var id_part = $(this).attr("id");
                if (id_part != '') {
                    $.ajax({
                        url: "select_parts.php",
                        method: "POST",
                        data: {
                            id_part: id_part
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