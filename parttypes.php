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
<?php if($u_admin) : ?>
        <div align="right">
            <button type="button" name="add" id="add" data-bs-toggle="modal" data-bs-target="#add_data_Modal" class="btn btn-warning">Add</button>
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
                        </div></td>';
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
        // ferror_log("returned: " . $sql);
        ?>
    </div><!-- container -->

    <div id="dataModal" class="modal"><!-- view data -->
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Part Type Details</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div><!-- modal-header -->
                <div class="modal-body" id="part_type_detail">
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
                    <h5 class="mb-0">Delete this part type?</h5>
                    <p id="part_type2delete">You can cancel now.</p>
                </div>
                <div class="modal-footer flex-nowrap p-0">
                    <button type="button" class="btn btn-lg btn-link text-decoration-none rounded-0 border-right" id="confirm-delete" data-bs-dismiss="modal"><strong>Yes, delete</strong></button>
                    <button type="button" class="btn btn-lg btn-link text-decoration-none rounded-0" data-bs-dismiss="modal">No thanks</button>
                </div><!-- modal-footer -->
            </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- deleteModal -->
    <div id="add_data_Modal" class="modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Part type information</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
                            <div class="col-md-7">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="Woodwind">Woodwind </label>
                                    <input type="radio" class="form-check-input" id="Woodwind" name="family" value="Woodwind">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="Brass">Brass </label>
                                    <input type="radio" class="form-check-input" id="Brass" name="family" value="Brass">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="Percussion">Percussion </label>
                                    <input type="radio" class="form-check-input" id="Percussion" name="family" value="Percussion">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="Strings">Strings </label>
                                    <input type="radio" class="form-check-input" id="Strings" name="family" value="Strings">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="Other">Other </label>
                                    <input type="radio" class="form-check-input" id="Other" name="family" value="Other">
                                </div>
                            </div>
                        </div><hr />
                        <div class="row bg-white">
                            <div class="col-md-12">
                                <label for="description" class="col-form-label">Description (up to 2048 characters)</label>
                                <textarea class="form-control" id="description" name="description" rows="3" maxlength="2048"></textarea>
                                <br />
                                <label for="link" class="col-form-label">Part type collection? (How many parts in the collection)</label>
                                <input type="number" class="form-control" id="is_part_collection" name="is_part_collection">
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
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>  
                     </form>  
                </div><!-- modal-footer -->
            </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- add_data_modal -->
</main>
<?php require_once("includes/footer.php");?>
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
            url:"includes/fetch_parttypes.php",
            method:"POST",
            data:{id_part_type:id_part_type},
            dataType:"json",
            success:function(data){
                $('#id_part_type').val(data.id_part_type);
                $('#collation').val(data.collation);
                $('#name').val(data.name);
                $('#description').val(data.description);
                $('#' + data.family).prop('checked', true);
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
    $(document).on('click', '.delete_data', function(){ // button that brings up modal
        // input button name="delete" id="id_part_type" class="delete_data"
        var id_part_type = $(this).attr("id");
        $('#deleteModal').modal('show');
        $('#confirm-delete').data('id', id_part_type);
        $('#part_type2delete').text(id_part_type);
    });
    $('#confirm-delete').click(function(){
        // The confirm delete button
        var id_part_type = $(this).data('id');
        $.ajax({
            url:"includes/delete_records.php",
            method:"POST",
            data:{
                table_name: "part_types",
                table_key_name: "id_part_type",
                table_key: id_part_type
            },
            success:function(data){
                $('#insert_form')[0].reset();
                $('#part_type_table').html(data);
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
                url:"includes/insert_parttypes.php",
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
                url:"includes/select_parttypes.php",
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
</body>
</html>
