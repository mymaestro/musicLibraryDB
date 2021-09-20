<?php
  define('PAGE_TITLE', 'List part types');
  define('PAGE_NAME', 'PartTypes');
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
  error_log("RUNNING list_parttypes.php");
?>
    <br />
    <div class="container">
        <h2 align="center"><?php echo ORGNAME ?> Part Types</h2>
<?php if($u_admin) : ?>
        <div align="right">
            <button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-warning">Add</button>
            <br />
        </div><!-- right -->
<?php endif; ?>
        <div id="part_type_table">
        <?php
        require_once('includes/config.php');
        require_once('includes/functions.php');
        echo '
            <div class="panel panel-default">
               <div class="table-repsonsive">
                    <table class="table table-hover">
                    <caption class="title">Available part types</caption>
                    <thead>
                    <tr>
                        <th>ID</th>
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
            $id_part_collection = $rowList['id_part_collection'];
            $enabled = $rowList['enabled'];
            echo '<tr>
                        <td>'.$id_part_type.'</td>
                        <td>'.$collation.'</td>
                        <td>'.$name.'</td>
                        <td>'.$family.'</td>
                        <td>'.$description.'</td>
                        <td>'.$id_part_collection.'</td>
                        <td>'. (($enabled == 1) ? "Yes" : "No") .'</td>';
            if ($u_admin) { echo '
                        <td><input type="button" name="delete" value="Delete" id="'.$id_part_type.'" class="btn btn-danger btn-sm delete_data" /></td>
                        <td><input type="button" name="edit" value="Edit" id="'.$id_part_type.'" class="btn btn-primary btn-sm edit_data" /></td>'; }
            echo '
                        <td><input type="button" name="view" value="View" id="'.$id_part_type.'" class="btn btn-secondary btn-sm view_data" /></td>
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
        // error_log("returned: " . $sql);
        ?>
    </div><!-- container -->

    <div id="dataModal" class="modal"><!-- view data -->
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Part Type Details</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div><!-- modal-header -->
                <div class="modal-body" id="part_type_detail">
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
                    <h4 class="modal-title">Part type information</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div><!-- modal-header -->
                <div class="modal-body">
                  <div class="container-fluid">
                    <form method="post" id="insert_form">
                        <input type="hidden" name="id_part_type" id="id_part_type" />
                        <div class="row bg-light">
                            <div class="col-md-3">
                                <label for="collation" class="col-form-label">Sorting order*</label>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control" id="collation" name="collation" placeholder="999" required/>
                            </div>
                        </div><hr />
                        <div class="row bg-white">
                            <div class="col-md-3">
                                <label for="name" class="col-form-label">Part type name*</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Vuvuzela 4" required/>
                            </div>
                        </div>
                        <div class="row bg-white">
                            <div class="col-md-3">
                                <label for="family" class="col-form-label">Part type family</label>
                            </div>
                            <div class="col-md-7 form-check form-check-inline">
                                <label class="form-check-label" for="familywood">Woodwind </label>
                                <input type="radio" class="form-check-input" id="familywood" name="family" value="Woodwind" checked>
                                <label class="form-check-label" for="familybrass">Brass </label>
                                <input type="radio" class="form-check-input" id="familybrass" name="family" value="Brass">
                                <label class="form-check-label" for="familyperc">Percussion </label>
                                <input type="radio" class="form-check-input" id="familyperc" name="family" value="Percussion">
                                <label class="form-check-label" for="familystring">Strings </label>
                                <input type="radio" class="form-check-input" id="familystring" name="family" value="Strings">
                                <label class="form-check-label" for="familyother">Other </label>
                                <input type="radio" class="form-check-input" id="familyother" name="family" value="Other">
                            </div>
                        </div><hr />
                        <div class="row bg-white">
                            <div class="col-md-12">
                                <label for="description" class="col-form-label">Description (up to 2048 characters)</label>
                                <textarea class="form-control" id="description" name="description" rows="3" maxlength="2048"></textarea>
                                <br />
                                <label for="link" class="col-form-label">Part type collection (link)</label>
                                <input type="number" class="form-control" id="id_part_collection" name="id_part_collection">
                                <br />
                                <label for="enabled" class="col-form-label">Enabled</label>
                                <div class="form-check form-check-inline">
                                <input class="form-control" id="enabled" name="enabled" type="checkbox" value="1"></>
                            </div>
                        </div>
                        <input type="hidden" name="update" id="update" value="0" />
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
            $('#update').val("add");
            $('#insert_form')[0].reset();
        });
        $(document).on('click', '.edit_data', function(){
            var id_part_type = $(this).attr("id");
            $.ajax({
                url:"fetch_parttypes.php",
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
        $(document).on('click', '.delete_data', function(){
            var id_part_type = $(this).attr("id");
            $.ajax({
                url:"delete_records.php",
                method:"POST",
                data:{
                    table_name:"part_types",
                    table_key_name:"id_part_type",
                    table_key:id_part_type},
                dataType:"json",
                success:function(data){
                    $('#part_type_detail').html(data);
                    $('#dataModal').modal('show');
                }
           });
        });
        $('#insert_form').on("submit", function(event){
            event.preventDefault();
            if($('#title').val() == "")
            {
                alert("Title is required");
            }
            else if($('#id_part_type').val() == '')
            {
                alert("Part Type ID is required");
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
        $(document).on('click', '.view_data', function(){
            var id_part_type = $(this).attr("id");
            if(id_part_type != '')
            {
                $.ajax({
                    url:"select_parttypes.php",
                    method:"POST",
                    data:{id_part_type:id_part_type},
                    success:function(data){
                        $('#part_type_detail').html(data);
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
