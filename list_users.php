<?php
  session_start();
  define('PAGE_TITLE', 'List users');
  define('PAGE_NAME', 'Users');
  require_once('includes/config.php');
  require_once('includes/functions.php');
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
  ferror_log("RUNNING list_users.php");
?>   <div class="container">
        <h2 align="center"><?php echo ORGNAME . ' ' . PAGE_NAME ?></h2>
<?php if($u_admin) : ?>
        <div align="right">
            <button type="button" name="add" id="add" data-bs-toggle="modal" data-bs-target="#add_data_Modal" class="btn btn-warning">Add</button>
            <br />
        </div><!-- right button -->
<?php endif; ?>
        <div id="user_table">
        <?php
        echo '            <div class="panel panel-default">
               <div class="table-repsonsive">';
            if($u_user){ 
                echo '
                <form action="enable_list.php" method="post" id="enable_list_form">';
            }    
        echo '
          <table class="table table-hover">
                    <caption class="title">Available users</caption>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>User name</th>
                        <th>Real name</th>
                        <th>e-mail address</th>
                        <th>User</th>
                        <th>Admin</th>
                    </tr>
                    </thead>
                    <tbody>';
        $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $sql = "SELECT * FROM users ORDER BY id_users;";
        $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
        while ($rowList = mysqli_fetch_array($res)) {
            $id_user = $rowList['id_users'];
            $username = $rowList['username'];
            $name = $rowList['name'];
            $address = $rowList['address'];
            $roles = $rowList['roles'];
            $isAdmin = (strpos(htmlspecialchars($roles), 'administrator') !== FALSE ? TRUE : FALSE);
            $isUser = (strpos(htmlspecialchars($roles), 'user') !== FALSE ? TRUE : FALSE);
            echo '<tr>
                        <td>'.$id_user.'<input type="hidden" name="id_user[]" value="'. $id_user .'"></td>
                        <td>'.$username.'</td>
                        <td>'.$name.'</td>
                        <td>'.$address.'</td>
                        <td><div class="form-check form-switch">
                        <input class="form-check-input" name="u_user[]" type="checkbox" role="switch" id="isUser" '. (($u_admin) ? "" : "disabled ") . (($isUser) ? "checked" : "") .'>
                        </div></td>
                        <td><div class="form-check form-switch">
                        <input class="form-check-input" name="u_admin[]" type="checkbox" role="switch" id="isAdmin" '. (($u_admin) ? "" : "disabled ") . (($isAdmin) ? "checked" : "") .'>
                        </div></td>';
                        if ($u_admin) { echo '
                        <td><input type="button" name="delete" value="Delete" id="'.$id_user.'" class="btn btn-danger btn-sm delete_data" /></td>
                        <td><input type="button" name="edit" value="Edit" id="'.$id_user.'" class="btn btn-primary btn-sm edit_data" /></td>'; }
            echo '
                        <td><input type="button" name="view" value="View" id="'.$id_user.'" class="btn btn-secondary btn-sm view_data" /></td>
                    </tr>
                    ';
        }
        echo '
                    </tbody>
                    </table>';
                    if($u_user){ 
                        echo '
                        </form>';
                    }
        echo '
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
                    <h3 class="modal-title">User details</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div><!-- modal-header -->
                <div class="modal-body" id="user_detail">
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
                    <h5 class="mb-0">Delete this user?</h5>
                    <p id="user2delete">You can cancel now.</p>
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
                    <h4 class="modal-title">User information</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div><!-- modal-header -->
                <div class="modal-body">
                  <div class="container-fluid">
                    <form method="post" id="insert_form">
                        <div class="row bg-light">
                            <div class="col-md-3">
                                <label for="id_user" class="col-form-label">ID*</label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="id_user" name="id_user" placeholder="X" size="4" maxlength="4" required/>
                                <input type="hidden" id="id_user_hold" name="id_user_hold" value="" />
                            </div>
                        </div><hr />
                        <div class="row bg-white">
                            <div class="col-md-3">
                                <label for="name" class="col-form-label">User name*</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Vuvuzela choir" required/>
                            </div>
                        </div><hr />
                        <div class="row bg-white">
                            <div class="col-md-12">
                                <label for="description" class="col-form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                <br />
                                <label for="link" class="col-form-label">Link</label>
                                <input type="text" class="form-control" id="link" name="link">
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
            var id_user = $(this).attr("id");
            $.ajax({
                url:"fetch_users.php",
                method:"POST",
                data:{id_user:id_user},
                dataType:"json",
                success:function(data){
                    $('#id_user').val(data.id_user);
                    $('#id_user_hold').val(data.id_user);
                    $('#name').val(data.name);
                    $('#description').val(data.description);
                    $('#link').val(data.link);
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
            // input button name="delete" id="id_user" class="delete_data"
            var id_user = $(this).attr("id");
            $('#deleteModal').modal('show');
            $('#confirm-delete').data('id', id_user);
            $('#user2delete').text(id_user);
        });
        $('#confirm-delete').click(function(){
            // The confirm delete button
            var id_user = $(this).data('id');
            $.ajax({
                url:"delete_records.php",
                method:"POST",
                data:{
                    table_name: "users",
                    table_key_name: "id_user",
                    table_key: id_user
                },
                success:function(data){
                    $('#insert_form')[0].reset();
                    $('#user_table').html(data);
                }
           });
        });
        $('#insert_form').on("submit", function(event){
            event.preventDefault();
            if($('#title').val() == "")
            {
                alert("Title is required");
            }
            else if($('#id_user').val() == '')
            {
                alert("user ID is required");
            }
            else
            {
                $.ajax({
                    url:"insert_users.php",
                    method:"POST",
                    data:$('#insert_form').serialize(),
                    beforeSend:function(){
                        $('#insert').val("Inserting");
                    },
                    success:function(data){
                        $('#insert_form')[0].reset();
                        $('#add_data_Modal').modal('hide');
                        $('#user_table').html(data);
                    }
                });
            }
        });
        $(document).on('click', '.view_data', function(){
            var id_user = $(this).attr("id");
            if(id_user != '')
            {
                $.ajax({
                    url:"select_users.php",
                    method:"POST",
                    data:{id_user:id_user},
                    success:function(data){
                        $('#user_detail').html(data);
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
