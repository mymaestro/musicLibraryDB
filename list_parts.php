<?php
  define('PAGE_TITLE', 'List parts');
  define('PAGE_NAME', 'Parts');
  require_once("includes/header.php");
  session_start();
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
        <h2 align="center">Instrument parts</h2>
<?php if($u_admin) : ?>
        <div align="right">
            <button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-warning">Add</button>
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

                    if ( $portfolio != $oldPortfolio ) {
                        if ( $oldPortfolio != "xyzzy" ) {
                            echo '
                                </tbody>
                           </table>
                           </div><!-- table-responsive -->
                        </div><!-- section'.$oldPortfolio.' -->
                    </div><!-- class panel -->';
                        } // End the table, and not the very first one
                        echo '
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="header'. $portfolio .'">
                            <h4 class="panel-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#section'.$portfolio.'" aria-expanded="true" aria-controls="section'.$portfolio.'">'.$portfolio.'</a>
                            </h4>
                        </div><!-- div panel-heading -->
                        <div id="section'.$portfolio.'" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="header'.$portfolio.'">
                            <div class="table-repsonsive">
                            <table class="table table-hover">
                                <caption class="title">Available '.$portfolio .' parts</caption>
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
                                    <td>'.$id_part.'</td>
                                    <td>'.$catalog_number.'</td>
                                    <td>'.$id_part_type.'</td>
                                    <td>'.$name.'</td>
                                    <td>'.$description.'</td>
                                    <td>'.$originals_count.'</td>
                                    <td>'.$copies_count.'</td>';
                        if ($u_admin) { echo '
                                    <td><input type="button" name="edit" value="Edit" id="'.$rowID.'" class="btn btn-primary btn-sm edit_data" /></td>'; }
                    echo '
                                    <td><input type="button" name="view" value="View" id="'.$rowID.'" class="btn btn-secondary btn-sm view_data" /></td>
                                </tr>
                                ';
                }
                echo '
                                </tbody>
                           </table>
                           </div><!-- table-responsive -->
                        </div><!-- section'.$oldPortfolio.' -->
                    </div><!-- class panel -->
                ';
                mysqli_close($f_link);
                // error_log("returned: " . $sql);
                ?>
            </div><!-- accordion -->
            </div><!-- part_table -->
    </div><!-- container -->

    <div id="dataModal" class="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Part details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div><!-- modal-header -->
                <div class="modal-body" id="part_detail">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div><!-- modal-footer -->
            </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- dataModal -->
    <div id="add_data_Modal" class="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Part information</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div><!-- modal-header -->
                <div class="modal-body">
                  <div class="container-fluid">
                    <form method="post" id="insert_form">
                        <div class="row bg-light">
                            <div class="col-md-2">
                                <label for="id_part" class="col-form-label">Part ID*</label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="id_part" name="id_part" placeholder="P00001" required/>
                            </div>
                            <div class="col-md-3">
                                <label for="catalog_number" class="col-form-label">Catalog number*</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Lookup from compositions" required/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="col-form-label">Part type*</label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="part_type" name="part_type" placeholder="Lookup from part types" required/>
                            </div>
                            <div class="col-md-5">
                                <p id="composition_name">Composition title</p>
                        </div>
                        </div><hr />
                        <div class="row bg-light">
                            <div class="col-md-2">
                                <label class="col-form-label">Originals count*</label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="originals_count" name="originals_count" placeholder="1" required/>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label">Copies count</label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="copies_count" name="copies_count" placeholder="10"/>
                            </div>
                        </div>
                        <div class="row bg-light">
                            <div class="col-md-2">
                                <label class="col-form-label">Name</label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name (optional)"/>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label">Description</label>
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control" id="description" name="description" placeholder="Description (optional)"/>
                            </div>

                        </div>
                        <hr />
                        <input type="hidden" name="part_id" id="part_id" />
                        <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" />
                    </form>  
                  </div><!-- container-fluid -->
                </div><!-- modal-body -->
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                </div><!-- modal-footer -->
            </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- add_data_modal -->
<!-- jquery function to add/update database records -->
    <script>
    $(document).ready(function(){
        $('#add').click(function(){
            $('#insert').val("Insert");
            $('#insert_form')[0].reset();
        });
        $(document).on('click', '.edit_data', function(){
            var part_id = $(this).attr("id");
            $.ajax({
                url:"fetch_parts.php",
                method:"POST",
                data:{part_id:part_id},
                dataType:"json",
                success:function(data){
                    $('#id_part').val(data.id_part);
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
        $('#insert_form').on("submit", function(event){
            event.preventDefault();
            if($('#id_part').val() == "")
            {
                alert("Part ID is required");
            }
            else if($('#id_part').val() == '')
            {
                alert("part ID is required");
            }
            else
            {
                $.ajax({
                    url:"insert_parts.php",
                    method:"POST",
                    data:$('#insert_form').serialize(),
                    beforeSend:function(){
                        $('#insert').val("Inserting");
                    },
                    success:function(data){
                        $('#insert_form')[0].reset();
                        $('#add_data_Modal').modal('hide');
                        $('#part_table').html(data);
                    }
                });
            }
        });
        $(document).on('click', '.view_data', function(){
            var part_id = $(this).attr("id");
            if(part_id != '')
            {
                $.ajax({
                    url:"select_parts.php",
                    method:"POST",
                    data:{part_id:part_id},
                    success:function(data){
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
