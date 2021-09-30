<?php
  define('PAGE_TITLE', 'List ensembles');
  define('PAGE_NAME', 'Ensembles');
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
  error_log("RUNNING list_ensembles.php");
?>
    <br />
    <div class="container">
        <h2 align="center"><?php echo ORGNAME ?> Ensembles</h2>
<?php if($u_admin) : ?>
        <div align="right">
            <button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-warning">Add</button>
            <br />
        </div><!-- right -->
<?php endif; ?>
        <div id="ensemble_table">
        <?php
        require_once('includes/config.php');
        require_once('includes/functions.php');
        echo '
            <div class="panel panel-default">
               <div class="table-repsonsive">
                    <table class="table table-hover">
                    <caption class="title">Available ensembles</caption>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Link</th>
                        <th>Enabled</th>
                    </tr>
                    </thead>
                    <tbody>';
        $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $sql = "SELECT * FROM ensembles ORDER BY name;";
        $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
        while ($rowList = mysqli_fetch_array($res)) {
            $id_ensemble = $rowList['id_ensemble'];
            $title = $rowList['name'];
            $description = $rowList['description'];
            $link = $rowList['link'];
            $enabled = $rowList['enabled'];
            echo '<tr>
                        <td>'.$id_ensemble.'</td>
                        <td>'.$title.'</td>
                        <td>'.$description.'</td>
                        <td>'.$link.'</td>
                        <td>'. (($enabled == 1) ? "Yes" : "No") .'</td>';
            if ($u_admin) { echo '
                        <td><input type="button" name="delete" value="Delete" id="'.$id_ensemble.'" class="btn btn-danger btn-sm delete_data" /></td>
                        <td><input type="button" name="edit" value="Edit" id="'.$id_ensemble.'" class="btn btn-primary btn-sm edit_data" /></td>'; }
            echo '
                        <td><input type="button" name="view" value="View" id="'.$id_ensemble.'" class="btn btn-secondary btn-sm view_data" /></td>
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
                    <h3 class="modal-title">Ensemble Details</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div><!-- modal-header -->
                <div class="modal-body" id="ensemble_detail">
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
                    <h4 class="modal-title">Ensemble information</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div><!-- modal-header -->
                <div class="modal-body">
                  <div class="container-fluid">
                    <form method="post" id="insert_form">
                        <div class="row bg-light">
                            <div class="col-md-3">
                                <label for="id_ensemble" class="col-form-label">ID*</label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="id_ensemble" name="id_ensemble" placeholder="X" required/>
                                <input type="hidden" id="id_ensemble_hold" name="id_ensemble_hold" value="" />
                            </div>
                        </div><hr />
                        <div class="row bg-white">
                            <div class="col-md-3">
                                <label for="name" class="col-form-label">Ensemble name*</label>
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
            var id_ensemble = $(this).attr("id");
            $.ajax({
                url:"fetch_ensembles.php",
                method:"POST",
                data:{id_ensemble:id_ensemble},
                dataType:"json",
                success:function(data){
                    $('#id_ensemble').val(data.id_ensemble);
                    $('#id_ensemble_hold').val(data.id_ensemble);
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
        $(document).on('click', '.delete_data', function(){
            var id_ensemble = $(this).attr("id");
            $.ajax({
                url:"delete_records.php",
                method:"POST",
                data:{
                    table_name: "ensembles",
                    table_key_name: "id_ensemble",
                    table_key:id_ensemble},
                dataType:"json",
                success:function(data){
                    $('#ensemble_detail').html(data);
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
            else if($('#id_ensemble').val() == '')
            {
                alert("Ensemble ID is required");
            }
            else
            {
                $.ajax({
                    url:"insert_ensembles.php",
                    method:"POST",
                    data:$('#insert_form').serialize(),
                    beforeSend:function(){
                        $('#insert').val("Inserting");
                    },
                    success:function(data){
                        $('#insert_form')[0].reset();
                        $('#add_data_Modal').modal('hide');
                        $('#ensemble_table').html(data);
                    }
                });
            }
        });
        $(document).on('click', '.view_data', function(){
            var id_ensemble = $(this).attr("id");
            if(id_ensemble != '')
            {
                $.ajax({
                    url:"select_ensembles.php",
                    method:"POST",
                    data:{id_ensemble:id_ensemble},
                    success:function(data){
                        $('#ensemble_detail').html(data);
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
