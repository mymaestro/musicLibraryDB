<?php
  define('PAGE_TITLE', 'List recordings');
  define('PAGE_NAME', 'Recordings');
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
  require_once("includes/navbar.php");
  require_once('includes/functions.php');
  ferror_log("RUNNING recordings.php");
?>
<main role="main" class="container">
    <div class="container">
        <button type="button" class="btn btn-warning btn-floating btn-lg" id="btn-back-to-top">
            <i class="fas fa-arrow-up"></i>
        </button>
        <div class="row pb-3 pt-5 border-bottom"><h1><?php echo ORGNAME  . ' '. PAGE_NAME ?></h1></div>
        <div class="row pt-3 justify-content-end">
            <div class="col-auto">
                <input type="text" class="tablesearch-input" data-tablesearch-table="#cpdatatable" placeholder="Search">
<?php if($u_librarian) : ?>
                <button type="button" name="add" id="add" data-bs-toggle="modal" data-bs-target="#add_data_Modal" class="btn btn-warning">Add</button>
<?php endif; ?>            </div>
        </div>

        </div><!-- right -->
        <div id="recordings_table">
            <p class="text-center">Loading recordings...</p>
        </div><!-- recordings_table -->

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
                                <div class="col-md-1">
                                    <label for="id_recording" class="col-form-label">ID</label>
                                </div>
                                <div class="col-md-1">
                                    <input type="text" class="form-control" id="id_recording" name="id_recording" placeholder="X" minlength="1" maxlength="4" size="4" disabled/>
                                    <input type="hidden" id="id_recording_hold" name="id_recording_hold" value=""/>
                                </div>
                                <div class="col-md-2">
                                    <label for="catalog_number" class="col-form-label">Catalog number*</label>
                                </div>
                                <div class="col-md-1">
                                    <p class="text-light" id="catalog_number_display" name="catalog_number_display">000</p>
                                </div>
                                <div class="col-md-7">
                                    <?php
                                    // Build the reference compositions
                                    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                                    $sql = "SELECT `catalog_number`, `name`, `composer`,`arranger` FROM compositions WHERE `enabled` = 1 ORDER BY name;";
                                    //ferror_log("Running " . $sql);
                                    $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
                                    $opt = "<select class='form-select form-control' aria-label='Select composition' id='catalog_number' name='catalog_number'>";
                                    while ($rowList = mysqli_fetch_array($res)) {
                                        $comp_catno = $rowList['catalog_number'];
                                        $comp_name = $rowList['name'];
                                        $comp_composer = $rowList['composer'];
                                        $comp_arranger = $rowList['arranger'];
                                        $comp_display = $comp_name . " - " . $comp_catno;
                                        if (("$comp_composer" <> "" ) || ("$comp_arranger" <> "")) $comp_display .= ' (';
                                        if (("$comp_composer" <> "" ) && ("$comp_arranger" <> "")) $comp_display .= $comp_composer . ", arr. " . $comp_arranger . ")";
                                        if (("$comp_composer" == "" ) && ("$comp_arranger" <> "")) $comp_display .= "arr. " . $comp_arranger . ")";
                                        if (("$comp_composer" <> "" ) && ("$comp_arranger" == "")) $comp_display .=  $comp_composer . ")";
                                        $opt .= "<option value='" . $comp_catno . "'>" . $comp_display . "</option>";
                                    }
                                    $opt .= "</select>";
                                    mysqli_close($f_link);
                                    echo $opt;
                                    //error_log("returned: " . $sql);
                                    ?>
                                    <input type="hidden" id="catalog_number_hold" name="catalog_number_hold" value="" />
                                    <p class="text-light">Some kind of recording</p>
                                </div>
                            </div><hr />
                            <div class="row bg-light">
                                <div class="col-md-2">
                                    <label for="ensemble" class="col-form-label">Ensemble*</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="ensemble" name="ensemble" placeholder="Austin Civic Wind Ensemble" required minlength="3" maxlength="255"/>
                                </div>
                                <div class="col-md-2">
                                    <label for="name" class="col-form-label">Recording name*</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Musical comedy" required minlength="3" maxlength="255"/>
                                </div>
                            </div>
                            <div class="row bg-white">
                                <div class="col-md-2">
                                    <label for="date" class="col-form-control">Date*</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="date" class="form-control" id="date" name="date" placeholder="2000-12-25" required />
                                </div>
                                <div class="col-md-2">
                                    <label for="link" class="col-form-control">File*</label>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <input type="file" class="form-control" name="link" id="link">
                                        <label class="input-group-text" for="link">Upload</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row bg-white">
                                <div class="col-md-12">
                                    <p class="text-info text-center"><?php echo ORGFILES ?><span id="filedate">0000-00-00</span>/<span id="filebase">00file.mp3</span></p>
                                </div>
                            </div>
                            <div class="row bg-light">
                                <div class="col-md-2">
                                    <label for="composer" class="col-form-control">Composer</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="composer" name="composer" placeholder="Last, First"/>
                                </div>
                                <div class="col-md-2">
                                    <label for="arranger" class="col-form-control">Arranger</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="arranger" name="arranger" placeholder="Last, First" />
                                </div>
                            </div>
                            <div class="row bg-white">
                                <div class="col-md-2">
                                    <label for="venue" class="col-form-control">Venue</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="venue" name="venue" placeholder="Band Hall" />
                                </div>
                            </div>
                            <div class="row bg-light">
                                <div class="col-md-12">
                                    <label for="concert" class="col-form-label">Description</label>
                                    <textarea class="form-control" id="concert" name="concert" rows="3" maxlength="255"></textarea>
                                    <br />
                                </div>
                            </div>
                            <div class="row bg-white">
                                <div class="form-check">
                                    <label for="enabled" class="form-check-label">Enabled</label>
                                    <input class="form-check-input" id="enabled" name="enabled" type="checkbox" value="1"></>
                                </div>
                            </div><!-- row -->
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
        <div id="messageModal" class="modal"><!-- message feedback -->
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Message</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div><!-- modal-header -->
                    <div class="modal-body" id="message_detail">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div><!-- modal-footer -->
                </div><!-- modal-content -->
            </div><!-- modal-dialog -->
        </div><!-- messageModal -->
    </div><!-- container -->
</main>
<?php require_once("includes/footer.php");?>
<!-- script to sort and filter table views -->
<script src="js/auto-tables.js"></script>
<!-- jquery function to add/update database records -->
<script>
$("#link").change(function(){
    $('#filebase').text($('#link').val());
});
$("#date").change(function(){
    $('#filedate').text($('#date').val());
});
$(document).ready(function(){
    // Scroll-to-top button
    let $upButton = $("#btn-back-to-top");
    // When the user scrolls down 20px from the top of the document, show the button
    $(window).on("scroll", function () {
        if ($(document).scrollTop() > 20) {
            $upButton.show();
        } else {
            $upButton.hide();
        }
    });
    // When the user clicks the button, scroll to the top of the document
    $upButton.on("click", function () {
        $("html, body").animate({ scrollTop: 0 }, "fast");
    });

    $.ajax({
        url:"includes/fetch_recordings.php",
        method:"POST",
        data:{
            user_role: "<?php echo ($u_librarian) ? 'librarian' : 'nobody'; ?>"
        },   
        success:function(data){
            $('#recordings_table').html(data);
        }
    });
    $('#add').click(function(){
        $('#insert').val("Insert");
        $('#update').val("add");
        $('#insert_form')[0].reset();
    });
    $('#catalog_number').change(function() {
        var catalog_number = this.value;
        $.ajax({
            url:"includes/fetch_recordings.php",
            method:"POST",
            dataType: "json",
            data:{
                catalog_number: catalog_number, 
                user_role: "<?php echo ($u_librarian) ? 'librarian' : 'nobody'; ?>"
            },
            success:function(data){
                $('#catalog_number').val(data.catalog_number);
                $('#composer').val(data.composer);
                $('#arranger').val(data.arranger);
            }
        });
    });
    $(document).on('click', '.edit_data', function(){
        var id_recording = $(this).attr("id");
        $.ajax({
            url:"includes/fetch_recordings.php",
            method:"POST",
            data:{id_recording:id_recording},
            dataType:"json",
            success:function(data){
                $('#id_recording').val(data.id_recording);
                $('#id_recording_hold').val(data.id_recording);
                $('#catalog_number').val(data.catalog_number);
                $('#name').val(data.name);
                $('#date').val(data.date);
                $('#ensemble').val(data.ensemble);
                $('#link').val(data.link);
                $('#concert').val(data.concert);
                $('#venue').val(data.venue);
                $('#composer').val(data.composer);
                $('#arranger').val(data.arranger);
                if ((data.enabled) == 1) {
                    $('#enabled').prop('checked',true);
                }
                $('#filebase').text(data.link);
                $('#filedate').text(data.date);
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
            url:"includes/delete_records.php",
            method:"POST",
            data:{
                table_name: "recordings",
                table_key_name: "id_recording",
                table_key: id_recording
            },
            success:function(response){
                if (response.success) {
                    $('#message_detail').html('<p class="text-success">Record ' + response.message + ' deleted from recordings</p>');
                    $('#messageModal').modal('show');
                    $.ajax({
                        url:"includes/fetch_recordings.php",
                        method:"POST",
                        data:{
                            user_role: "<?php echo ($u_librarian) ? 'librarian' : 'nobody'; ?>"
                        },
                        success:function(data){
                            $('#recordings_table').html(data);
                        }
                    });
                 } else {
                    $('#message_detail').html('<p class="text-danger">Error: <emp>' + response.error + '</emp></p>');
                    $('#messageModal').modal('show');
                }
            },
            error:function(xhr, status, error){
                alert("Unexpected XHR error " + error);
            }
        });
    });
    $('#insert_form').on("submit", function(event){
        event.preventDefault();
        if($('#name').val() == "")
        {
            alert("Recording name is required");
        }
        else if($('#ensemble').val() == '')
        {
            alert("Ensemble is required");
        }
        else
        {
            $.ajax({
                url:"includes/insert_recordings.php",
                method:"POST",
                data:$('#insert_form').serialize(),
                beforeSend:function(){
                    $('#insert').val("Inserting");
                },
                success:function(data){
                    $('#insert_form')[0].reset();
                    $('#add_data_Modal').modal('hide');
                    $.ajax({
                        url:"includes/fetch_recordings.php",
                        method:"POST",
                        data:{
                            user_role: "<?php echo ($u_librarian) ? 'librarian' : 'nobody'; ?>"
                        },   
                        success:function(data){
                            $('#recordings_table').html(data);
                        }
                    });
                }
            });
        }
    });
    $(document).on('click', '.view_data', function(){
        var id_recording = $(this).attr("id");
        if(id_recording != '')
        {
            $.ajax({
                url:"includes/select_recordings.php",
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
</body>
</html>
