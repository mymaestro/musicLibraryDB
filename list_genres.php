<?php
  define('PAGE_TITLE', 'List genres');
  define('PAGE_NAME', 'Genres');
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
  error_log("RUNNING list_genres.php");
?>
    <br />
    <div class="container">
        <h2 align="center"><?php echo ORGNAME ?> Genres</h2>
<?php if($u_admin) : ?>
        <div align="right">
            <button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-warning">Add</button>
            <br />
        </div><!-- right -->
<?php endif; ?>
        <div id="genre_table">
        <?php
        require_once('includes/config.php');
        require_once('includes/functions.php');
        echo '
            <div class="panel panel-default">
               <div class="table-repsonsive">
                    <table class="table table-hover">
                    <caption class="title">Available Genres</caption>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Enabled</th>
                    </tr>
                    </thead>
                    <tbody>';
        $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $sql = "SELECT * FROM genres ORDER BY name;";
        $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
        while ($rowList = mysqli_fetch_array($res)) {
            $id_genre = $rowList['id_genre'];
            $name = $rowList['name'];
            $description = $rowList['description'];
            $enabled = $rowList['enabled'];
            echo '<tr>
                        <td>'.$id_genre.'</td>
                        <td>'.$name.'</td>
                        <td>'.$description.'</td>
                        <td>'. (($enabled == 1) ? "Yes" : "No") .'</td>';
            if ($u_admin) { echo '
                        <td><input type="button" name="delete" value="Delete" id="'.$id_genre.'" class="btn btn-danger btn-sm delete_data" /></td>
                        <td><input type="button" name="edit" value="Edit" id="'.$id_genre.'" class="btn btn-primary btn-sm edit_data" /></td>'; }
            echo '
                        <td><input type="button" name="view" value="View" id="'.$id_genre.'" class="btn btn-secondary btn-sm view_data" /></td>
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
                    <h3 class="modal-title">Genre details</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div><!-- modal-header -->
                <div class="modal-body" id="genre_detail">
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
                    <h4 class="modal-title">Genre information</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div><!-- modal-header -->
                <div class="modal-body">
                  <div class="container-fluid">
                    <form method="post" id="insert_form">
                        <div class="row bg-light">
                            <div class="col-md-3">
                                <label for="id_genre" class="col-form-label">ID*</label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="id_genre" name="id_genre" placeholder="X" required minlength="1" maxlength="4" size="4"/>
                            </div>
                        </div><hr />
                        <div class="row bg-white">
                            <div class="col-md-3">
                                <label for="name" class="col-form-label">Genre name*</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Musical comedy" required minlength="3" maxlength="255"/>
                            </div>
                        </div><hr />
                        <div class="row bg-white">
                            <div class="col-md-12">
                                <label for="description" class="col-form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" maxlength="255"></textarea>
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
            var id_genre = $(this).attr("id");
            $.ajax({
                url:"fetch_genres.php",
                method:"POST",
                data:{id_genre:id_genre},
                dataType:"json",
                success:function(data){
                    $('#id_genre').val(data.id_genre);
                    $('#name').val(data.name);
                    $('#description').val(data.description);
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
            var id_genre = $(this).attr("id");
            $.ajax({
                url:"delete_records.php",
                method:"POST",
                data:{
                    table_name: "genres",
                    table_key_name: "id_genre",
                    table_key:id_genre},
                dataType:"json",
                success:function(data){
                    $('#genre_detail').html(data);
                    $('#dataModal').modal('show');
                }
           });
        });
        $('#insert_form').on("submit", function(event){
            event.preventDefault();
            if($('#name').val() == "")
            {
                alert("Genre name is required");
            }
            else if($('#id_genre').val() == '')
            {
                alert("Genre ID is required");
            }
            else
            {
                $.ajax({
                    url:"insert_genres.php",
                    method:"POST",
                    data:$('#insert_form').serialize(),
                    beforeSend:function(){
                        $('#insert').val("Inserting");
                    },
                    success:function(data){
                        $('#insert_form')[0].reset();
                        $('#add_data_Modal').modal('hide');
                        $('#genre_table').html(data);
                    }
                });
            }
        });
        $(document).on('click', '.view_data', function(){
            var id_genre = $(this).attr("id");
            if(id_genre != '')
            {
                $.ajax({
                    url:"select_genres.php",
                    method:"POST",
                    data:{id_genre:id_genre},
                    success:function(data){
                        $('#genre_detail').html(data);
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
