<?php
  session_start();
  define('PAGE_TITLE', 'List recordings');
  define('PAGE_NAME', 'Recordings');
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
  require_once('includes/config.php');
  require_once('includes/functions.php');
  ferror_log("RUNNING list_recordings.php");
?>
    <br />
    <div class="container">
        <h2 align="center"><?php echo ORGNAME ?> Recordings</h2>
<?php if($u_admin) : ?>
        <div align="right">
            <button type="button" name="add" id="add" data-bs-toggle="modal" data-bs-target="#add_data_Modal" class="btn btn-warning">Add</button>
            <br />
        </div><!-- right -->
<?php endif; ?>
        <div id="recording_table">
        <?php
        echo '
            <div class="panel panel-default">
               <div class="table-repsonsive">
                    <table class="table table-hover">
                    <caption class="title">Available recordings</caption>
                    <thead>
                    <tr>
                        <th data-tablesort-type="string">ID <i class="fa fa-sort" aria-hidden="true"></i></th>
                        <th data-tablesort-type="string">Catalog number <i class="fa fa-sort" aria-hidden="true"></i></th>
                        <th data-tablesort-type="string">Name <i class="fa fa-sort" aria-hidden="true"></i></th>
                        <th data-tablesort-type="date">Date <i class="fa fa-sort" aria-hidden="true"></i></th>
                        <th data-tablesort-type="string">File name <i class="fa fa-sort" aria-hidden="true"></i></th>
                        <th data-tablesort-type="string">Concert <i class="fa fa-sort" aria-hidden="true"></i></th>
                        <th data-tablesort-type="string">Venue <i class="fa fa-sort" aria-hidden="true"></i></th>
                        <th data-tablesort-type="string">Enabled <i class="fa fa-sort" aria-hidden="true"></i></th>
                    </tr>
                    </thead>
                    <tbody>';
        $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $sql = "SELECT * FROM recordings ORDER BY date;";
        $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
        while ($rowList = mysqli_fetch_array($res)) {
            $id_recording = $rowList["id_recording"];
            $catalog_number = $rowList["catalog_number"];
            $date = $rowList["date"];
            $name = $rowList["name"];
            $link = $rowList["link"];
            $concert = $rowList["concert"];
            $venue = $rowList["venue"];
            $enabled = $rowList["enabled"];
            echo '<tr>
                    <td>'. $id_recording . '</td>
                    <td>'. $catalog_number . '</td>
                    <td>'. $name . '</td>
                    <td>'. $date . '</td>
                    <td><a href="'. ORGFILES . $date . '/' . $link . '">'.$link.'</a></td>
                    <td>'. $concert . '</td>
                    <td>'. $venue . '</td>
                    <td>'. (($enabled == 1) ? "Yes" : "No") .'</td>';
            if ($u_admin) { echo '
                        <td><input type="button" name="delete" value="Delete" id="'.$id_recording.'" class="btn btn-danger btn-sm delete_data" /></td>
                        <td><input type="button" name="edit" value="Edit" id="'.$id_recording.'" class="btn btn-primary btn-sm edit_data" /></td>'; }
            echo '
                        <td><input type="button" name="view" value="View" id="'.$id_recording.'" class="btn btn-secondary btn-sm view_data" /></td>
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
        ferror_log("returned: " . $sql);
        ?>
    </div><!-- container -->

    <div id="dataModal" class="modal"><!-- view data -->
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Recording details</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div><!-- modal-header -->
                <div class="modal-body" id="recording_detail">
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
                    <h5 class="mb-0">Delete this recording?</h5>
                    <p id="recording2delete">You can cancel now.</p>
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
                    <h4 class="modal-title">Recording information</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div><!-- modal-header -->
                <div class="modal-body">
                  <div class="container-fluid">
                    <form method="post" id="insert_form">
                        <div class="row bg-light">
                            <div class="col-md-3">
                                <label for="id_recording" class="col-form-label">ID*</label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="id_recording" name="id_recording" placeholder="X" minlength="1" maxlength="4" size="4" required/>
                                <input type="hidden" id="id_recording_hold" name="id_recording_hold" value=""/>
                            </div>
                        </div><hr />
                        <div class="row bg-white">
                            <div class="col-md-3">
                                <label for="name" class="col-form-label">Recording name*</label>
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
    <script src="js/auto-tables.js"></script>
<!-- jquery function to add/update database records -->
    <script>
    $(document).ready(function(){
        $('#add').click(function(){
            $('#insert').val("Insert");
            $('#update').val("add");
            $('#insert_form')[0].reset();
        });
        $(document).on('click', '.edit_data', function(){
            var id_recording = $(this).attr("id");
            $.ajax({
                url:"fetch_recordings.php",
                method:"POST",
                data:{id_recording:id_recording},
                dataType:"json",
                success:function(data){
                    $('#id_recording').val(data.id_recording);
                    $('#id_recording_hold').val(data.id_recording);
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
        $(document).on('click', '.delete_data', function(){ // button that brings up modal
            // input button name="delete" id="id_recording" class="delete_data"
            var id_recording = $(this).attr("id");
            $('#deleteModal').modal('show');
            $('#confirm-delete').data('id', id_recording);
            $('#recording2delete').text(id_recording);
        });
        $('#confirm-delete').click(function(){
            // The confirm delete button
            var id_recording = $(this).data('id');
            $.ajax({
                url:"delete_records.php",
                method:"POST",
                data:{
                    table_name: "recordings",
                    table_key_name: "id_recording",
                    table_key: id_recording
                },
                success:function(data){
                    $('#insert_form')[0].reset();
                    $('#recording_table').html(data);
                }
           });
        });
        $('#insert_form').on("submit", function(event){
            event.preventDefault();
            if($('#name').val() == "")
            {
                alert("Recording name is required");
            }
            else if($('#id_recording').val() == '')
            {
                alert("Recording ID is required");
            }
            else
            {
                $.ajax({
                    url:"insert_recordings.php",
                    method:"POST",
                    data:$('#insert_form').serialize(),
                    beforeSend:function(){
                        $('#insert').val("Inserting");
                    },
                    success:function(data){
                        $('#insert_form')[0].reset();
                        $('#add_data_Modal').modal('hide');
                        $('#recording_table').html(data);
                    }
                });
            }
        });
        $(document).on('click', '.view_data', function(){
            var id_recording = $(this).attr("id");
            if(id_recording != '')
            {
                $.ajax({
                    url:"select_recordings.php",
                    method:"POST",
                    data:{id_recording:id_recording},
                    success:function(data){
                        $('#recording_detail').html(data);
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
