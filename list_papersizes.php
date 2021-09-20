<?php
  define('PAGE_TITLE', 'List paper sizes');
  define('PAGE_NAME', 'PaperSizes');
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
        <h2 align="center"><?php echo ORGNAME ?> Music Paper Sizes</h2>
<?php if($u_admin) : ?>
        <div align="right">
            <button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-warning">Add</button>
            <br />
        </div><!-- right -->
<?php endif; ?>
        <div id="paper_size_table">
        <?php
        require_once('includes/config.php');
        require_once('includes/functions.php');
        echo '
            <div class="panel panel-default">
               <div class="table-repsonsive">
                    <table class="table table-hover">
                    <caption class="title">Available paper sizes</caption>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Vertical dimension</th>
                        <th>Horizontal dimension</th>
                        <th>Enabled</th>
                    </tr>
                    </thead>
                    <tbody>';
        $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $sql = "SELECT * FROM paper_sizes ORDER BY name;";
        $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
        while ($rowList = mysqli_fetch_array($res)) {
            $id_paper_size = $rowList['id_paper_size'];
            $name = $rowList['name'];
            $description = $rowList['description'];
            $vertical = $rowList['vertical'];
            $horizontal = $rowList['horizontal'];
            $enabled = $rowList['enabled'];
            echo '<tr>
                        <td>'.$id_paper_size.'</td>
                        <td>'.$name.'</td>
                        <td>'.$description.'</td>
                        <td>'.$vertical.'</td>
                        <td>'.$horizontal.'</td>
                        <td>'. (($enabled == 1) ? "Yes" : "No") .'</td>';
            if ($u_admin) { echo '
                        <td><input type="button" name="delete" value="Delete" id="'.$id_paper_size.'" class="btn btn-danger btn-sm delete_data" /></td>
                        <td><input type="button" name="edit" value="Edit" id="'.$id_paper_size.'" class="btn btn-primary btn-sm edit_data" /></td>'; }
            echo '
                        <td><input type="button" name="view" value="View" id="'.$id_paper_size.'" class="btn btn-secondary btn-sm view_data" /></td>
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
                    <h3 class="modal-title">Paper Size Details</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div><!-- modal-header -->
                <div class="modal-body" id="paper_size_detail">
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
                    <h4 class="modal-title">Paper size information</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div><!-- modal-header -->
                <div class="modal-body">
                  <div class="container-fluid">
                    <form method="post" id="insert_form">
                        <div class="row bg-light">
                            <div class="col-md-3">
                                <label for="id_paper_size" class="col-form-label">ID*</label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="id_paper_size" name="id_paper_size" placeholder="X" required minlength="1" maxlength="4" size="4"/>
                            </div>
                        </div><hr />
                        <div class="row">
                            <div class="col-md-3">
                                <label for="name" class="col-form-label">Paper size name*</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Big" required minlength="4" maxlength="255"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="horizontal" class="col-form-label">Horizontal size, inches*</label>
                            </div>
                            <div class="col-md-7"><!-- DECIMAL(7,2) -->
                                <input type="text" class="form-control" id="horizontal" name="horizontal" placeholder="77.7" required minlength="1" maxlength="9"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="vertical" class="col-form-label">Vertical size, inches*</label>
                            </div>
                            <div class="col-md-7"><!-- DECIMAL(7,2)) -->
                                <input type="text" class="form-control" id="vertical" name="vertical" placeholder="89.5" required minlength="1" maxlength="9"/>
                            </div>
                        </div>                        <hr />
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
            var id_paper_size = $(this).attr("id");
            $.ajax({
                url:"fetch_papersizes.php",
                method:"POST",
                data:{id_paper_size:id_paper_size},
                dataType:"json",
                success:function(data){
                    $('#id_paper_size').val(data.id_paper_size);
                    $('#name').val(data.name);
                    $('#description').val(data.description);
                    $('#vertical').val(data.vertical);
                    $('#horizontal').val(data.horizontal);
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
            var id_paper_size = $(this).attr("id");
            $.ajax({
                url:"delete_records.php",
                method:"POST",
                data:{
                    table_name:"paper_sizes",
                    table_key_name:"id_paper_size",
                    table_key:id_paper_size},
                dataType:"json",
                success:function(data){
                    $('#paper_size_detail').html(data);
                    $('#dataModal').modal('show');
                }
           });
        });
        $('#insert_form').on("submit", function(event){
            event.preventDefault();
            if($('#name').val() == "")
            {
                alert("Name is required");
            }
            else
            {
                $.ajax({
                    url:"insert_papersizes.php",
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
            var id_paper_size = $(this).attr("id");
            if(id_paper_size != '')
            {
                $.ajax({
                    url:"select_papersizes.php",
                    method:"POST",
                    data:{id_paper_size:id_paper_size},
                    success:function(data){
                        $('#paper_size_detail').html(data);
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
