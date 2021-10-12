<?php
  session_start();
  define('PAGE_TITLE', 'List part type collections');
  define('PAGE_NAME', 'PartTypeCollections');
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
  error_log("RUNNING list_partcollections.php");
?>
    <br />
    <div class="container">
        <h2 align="center"><?php echo ORGNAME ?> Part Type Collections</h2>
<?php if($u_admin) : ?>
        <div align="right">
            <button type="button" name="add" id="add" data-bs-toggle="modal" data-bs-target="#add_data_Modal" class="btn btn-warning">Add</button>
            <br />
        </div><!-- right -->
<?php endif; ?>
        <div id="part_collection_table">
        <?php
        require_once('includes/config.php');
        require_once('includes/functions.php');
        echo '
            <div class="panel panel-default">
               <div class="table-repsonsive">
                    <table class="table table-hover">
                    <caption class="title">Available part type collections</caption>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Part Type</th>
                        <th>Enabled</th>
                    </tr>
                    </thead>
                    <tbody>';
        $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $sql = "SELECT * FROM part_collections ORDER BY name;";
        $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
        while ($rowList = mysqli_fetch_array($res)) {
            $id_part_collection = $rowList['id_part_collection'];
            $name = $rowList['name'];
            $description = $rowList['description'];
            $id_part_type = $rowList['id_part_type'];
            $enabled = $rowList['enabled'];
            echo '<tr>
                        <td>'.$id_part_collection.'</td>
                        <td>'.$name.'</td>
                        <td>'.$description.'</td>
                        <td>'.$id_part_type.'</td>
                        <td>'. (($enabled == 1) ? "Yes" : "No") .'</td>';
            if ($u_admin) { echo '
                        <td><input type="button" name="delete" value="Delete" id="'.$id_part_collection.'" class="btn btn-danger btn-sm delete_data" /></td>
                        <td><input type="button" name="edit" value="Edit" id="'.$id_part_collection.'" class="btn btn-primary btn-sm edit_data" /></td>'; }
            echo '
                        <td><input type="button" name="view" value="View" id="'.$id_part_collection.'" class="btn btn-secondary btn-sm view_data" /></td>
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
                    <h3 class="modal-title">Part Type Collection Details</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div><!-- modal-header -->
                <div class="modal-body" id="part_collection_detail">
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
                    <h5 class="mb-0">Delete this part_collection?</h5>
                    <p id="part_collection2delete">You can cancel now.</p>
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
                    <h4 class="modal-title">Part type collection information</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div><!-- modal-header -->
                <div class="modal-body">
                  <div class="container-fluid">
                    <form method="post" id="insert_form">
                        <input type="hidden" name="id_part_collection" id="id_part_collection" value="0" />
                        <div class="row bg-white">
                            <div class="col-md-3">
                                <label for="name" class="col-form-label">Part type collection name*</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Percussion 44" required/>
                            </div>
                        </div><hr />
                        <div class="row bg-white">
                            <div class="col-md-12">
                                <label for="description" class="col-form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                <br />
                                <label for="link" class="col-form-label">Part types that are in this collection (link)</label>
                                <input type="text" class="form-control" id="id_part_type" name="id_part_type" placeholder="This will be a pick list of part types">
                                <br />
                                <div class="form-check">
                                    <label for="enabled" class="form-check-label">Enabled</label>
                                    <input class="form-check-input" id="enabled" name="enabled" type="checkbox" value="1"></>
                                </div>
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
    $(document).ready(function(){
        $('#add').click(function(){
            $('#insert').val("Insert");
            $('#update').val("add");
            $('#insert_form')[0].reset();
        });
        $(document).on('click', '.edit_data', function(){
            var id_part_collection = $(this).attr("id");
            $.ajax({
                url:"fetch_partcollections.php",
                method:"POST",
                data:{id_part_collection:id_part_collection},
                dataType:"json",
                success:function(data){
                    $('#id_part_collection').val(data.id_part_collection);
                    $('#name').val(data.name);
                    $('#description').val(data.description);
                    $('#id_part_type').val(data.id_part_type);
                    if ((data.enabled) == 1) {
                        $('#enabled').prop('checked',true);
                    }
                    $('#insert').val("Update");
                    $('#update').val("update");
                    $('#add_data_Modal').modal('show');
                }
           });
        });
        $(document).on('click', '.delete_data', function(){ // button that brings up modal
            // input button name="delete" id="id_part_collection" class="delete_data"
            var id_part_collection = $(this).attr("id");
            $('#deleteModal').modal('show');
            $('#confirm-delete').data('id', id_part_collection);
            $('#part_collection2delete').text(id_part_collection);
        });
        $('#confirm-delete').click(function(){
            // The confirm delete button
            var id_part_collection = $(this).data('id');
            $.ajax({
                url:"delete_records.php",
                method:"POST",
                data:{
                    table_name: "part_collections",
                    table_key_name: "id_part_collection",
                    table_key: id_part_collection
                },
                success:function(data){
                    $('#insert_form')[0].reset();
                    $('#part_collection_table').html(data);
                }
           });
        });
        $('#insert_form').on("submit", function(event){
            event.preventDefault();
            if($('#title').val() == "")
            {
                alert("Title is required");
            }
            else if($('#id_part_collection').val() == '')
            {
                alert("Part type ID is required");
            }
            else
            {
                $.ajax({
                    url:"insert_partcollections.php",
                    method:"POST",
                    data:$('#insert_form').serialize(),
                    beforeSend:function(){
                        $('#insert').val("Inserting");
                    },
                    success:function(data){
                        $('#insert_form')[0].reset();
                        $('#add_data_Modal').modal('hide');
                        $('#part_collection_table').html(data);
                    }
                });
            }
        });
        $(document).on('click', '.view_data', function(){
            var id_part_collection = $(this).attr("id");
            if(id_part_collection != '')
            {
                $.ajax({
                    url:"select_partcollections.php",
                    method:"POST",
                    data:{id_part_collection:id_part_collection},
                    success:function(data){
                        $('#part_collection_detail').html(data);
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
