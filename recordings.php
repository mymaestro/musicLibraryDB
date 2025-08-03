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
  require_once('includes/functions.php');
  require_once("includes/navbar.php");
  ferror_log("RUNNING recordings.php");
?>
<main role="main">
    <div class="container">
        <button type="button" class="btn btn-warning btn-floating btn-lg" id="btn-back-to-top">
            <i class="fas fa-arrow-up"></i>
        </button>
        <div class="row pb-1 pt-5 border-bottom"><h1><?php echo ORGNAME  . ' '. PAGE_NAME ?></h1></div>
        <div class="row pt-3 justify-content-end">
            <div class="col-auto">
                <input type="text" class="tablesearch-input" data-tablesearch-table="#recordings_table" placeholder="Search doesn't work">
            </div>
            <div class="col-auto">
                <button type="button" data-bs-toggle="modal" data-bs-target="#dataModal" id="view" class="btn btn-secondary view_data" disabled>Details</button>
<?php if($u_librarian) : ?>
                <button type="button" data-bs-toggle="modal" data-bs-target="#editModal" id="edit" class="btn btn-primary edit_data" disabled>Edit</button>
                <button type="button" data-bs-toggle="modal" data-bs-target="#deleteModal" id="delete" class="btn btn-danger delete_data" disabled>Delete</button>
                <button type="button" data-bs-toggle="modal" data-bs-target="#editModal" id="add"  class="btn btn-warning">Add</button>
<?php endif; ?>
            </div>
        </div><!-- right buttons -->
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
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content rounded-4 shadow">
                    <div class="modal-body p-4 text-center">
                        <h5 class="mb-0">Delete recording <span id="recording2delete">#</span>?</h5>
                        <div class="modal-body text-start" id="recording-delete_detail">
                        <p>You can cancel now.</p>
                        </div>
                    </div>
                    <div class="modal-footer flex-nowrap p-0">
                        <button type="button" class="btn btn-lg btn-link text-decoration-none rounded-0 border-right" id="confirm-delete" data-bs-dismiss="modal"><strong>Yes, delete</strong></button>
                        <button type="button" class="btn btn-lg btn-link text-decoration-none rounded-0" data-bs-dismiss="modal">No thanks</button>
                    </div><!-- modal-footer -->
                </div><!-- modal-content -->
            </div><!-- modal-dialog -->
        </div><!-- deleteModal -->
        <div id="editModal" class="modal" tabindex="-1" role="dialog"><!-- edit data -->
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Recording information</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div><!-- modal-header -->
                    <div class="modal-body">
                        <form method="post" id="insert_form" enctype="multipart/form-data">
                        <div class="hidden">
                            <input type="text" name="id_recording" id="id_recording" class="form-control-plaintext" placeholder="0" readonly />
                        </div>
                        <div class="form-floating">
                            <select class='form-select form-control' aria-label='Choose concert' id='id_concert' name='concert'>
                                <option value=''>Select concert</option>
                            </select>
                            <label for="id_concert" class="col-form-label">Concert*</label>
                        </div><!-- row -->
                        <div class="form-floating"><!-- catalog number, from playgram_items -->
                            <select class='form-select form-control' aria-label='Choose composition' id='catalog_number' name='catalog_number'>
                                <option value="">Select catalog number</option>
                            </select>
                            <label for="catalog_number" class="col-form-label">Catalog number*</label>
                        </div><!-- row -->
                        <div class="form-floating">
                            <select class='form-select form-control' aria-label='Select ensemble' id='id_ensemble' name='id_ensemble'>
                                <option value=''>Select ensemble</option>
                            </select>
                            <label for="id_ensemble" class="col-form-label">Ensemble*</label>
                        </div><!-- row -->
                        <div class="form-floating">
                            <textarea class="form-control" id="ensemble" name="ensemble" placeholder="It's a wind ensemble" minlength="3" maxlength="255" style="height: 100px"></textarea>
                            <label for="ensemble" class="col-form-label">Ensemble description</label>
                         </div><!-- row -->
                        <div class="form-floating mb-1">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Musical comedy" maxlength="255"/>
                            <label for="name" class="col-form-label">Recording name</label>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="composer" name="composer" placeholder="Last, First"/>
                                    <label for="composer" class="col-form-label">Composer</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="arranger" name="arranger" placeholder="Last, First" />
                                    <label for="arranger" class="col-form-label">Arranger</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating">
                                <textarea class="form-control" id="notes" name="notes" style="height: 200px"></textarea>
                                <label for="notes" class="col-form-label">Description (recording notes)</label>
                        </div>
                        <div class="col-md-2">
                            <label for="link" class="col-form-control">File*</label>
                        </div>
                        <div class="col-md-8">
                            <div class="input-group mb-3">
                                <input type="file" class="form-control" name="link" id="link" accept=".mp3,.flac,.ogg" />
                                <!-- <button class="btn btn-primary" type="button" id="uploadRecording">Upload</button> -->
                            </div>
                            <div id="uploadStatus" class="text-info small"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" id="filedate" name="filedate" value="0000-00-00" />
                                <input type="hidden" id="venue" name="venue" value="ACWE studio" />
                                <p class="text-info text-center"><?php echo ORGRECORDINGS ?><span id="filedateDisplay">0000-00-00</span>/<span id="linkDisplay">-----.---</span></p>
                            </div>
                        </div>            
                    </div><!-- modal-body -->
                    <div class="modal-footer">  
                            <input type="hidden" name="update" id="update" value="0" />
                            <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" />
                        </form>  
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>  
                    </div><!-- modal-footer -->
                </div><!-- modal-content -->
            </div><!-- modal-dialog -->
        </div><!-- editModal -->
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
<!-- Reference concerts data -->
<?php
// Build the reference concerts as a JSON array for JavaScript
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$sql = "SELECT `id_concert`, `id_playgram`, `performance_date`, `venue`, `conductor` FROM concerts ORDER BY performance_date DESC;";
$res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
$concerts = [];
while ($rowList = mysqli_fetch_assoc($res)) {
    $concerts[] = [
        'id_concert' => $rowList['id_concert'],
        'id_playgram' => $rowList['id_playgram'],
        'performance_date' => $rowList['performance_date'],
        'venue' => $rowList['venue'],
        'conductor' => $rowList['conductor']
    ];
}
mysqli_close($f_link);
// Build the reference ensembles
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$sql = "SELECT `id_ensemble`, `name` FROM ensembles WHERE `enabled` = 1 ORDER BY name;";
$res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
$ensembles = [];
while ($rowList = mysqli_fetch_assoc($res)) {
    $ensembles[] = [
        'id_ensemble' => $rowList['id_ensemble'],
        'name' => $rowList['name']
    ];
}
mysqli_close($f_link);
?>
<!-- Use window.concerts, and window.ensembles in JavaScript to reference concerts and ensembles data -->
<script>
    window.concerts = <?php echo json_encode($concerts, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
    window.ensembles = <?php echo json_encode($ensembles, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
</script>
<!-- jquery function to add/update database records -->
<script>
// Load concert date and file name when the user selects a concert or file
$("#id_concert").change(function(){
    let selectedConcert = $('#id_concert').val();
    let concert = window.concerts.find(c => c.id_concert == selectedConcert);

    if (concert) {
        $('#filedate').val(concert.performance_date); // Set the file date to the concert date
        $('#filedateDisplay').text(concert.performance_date); // Set the display text
        $('#venue').val(concert.venue || 'ACWE studio'); // Set the venue, default to ACWE studio if not set
        console.log("Concert date set to: " + concert.performance_date);
    } else {
        $('#filedate').val('0000-00-00'); // Reset if no concert selected
        $('#filedateDisplay').text('0000-00-00');
        $('#venue').val('ACWE studio'); // Reset venue
    }
    let concertText = $('#id_concert option:selected').text();
    $('#concert').val(concertText);

    // Dynamically update catalog_number options based on selected concert
    $.ajax({
        url: "includes/fetch_playgram_items.php",
        method: "POST",
        data: { id_concert: selectedConcert },
        success: function(options) {
            if (options.trim() !== "") {
                $('#catalog_number').html(options);
            } else {
                $('#catalog_number').html('<option value="">No compositions for this concert</option>');
            }
        }
    });
});
$("#concert").change(function(){
    $('#filedate').text($('#concert').val());
    $('#filedateDisplay').text($('#concert').val());
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

    let id_recording = null; // Which row the user clicks

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

    // Populate the concert select with options from window.concerts
    var $concertSelect = $('#id_concert');
    $concertSelect.empty();
    $concertSelect.append("<option value=''>Select concert</option>");
    window.concerts.forEach(function(concert) {
        var display = concert.performance_date + " at " + concert.venue;
        if (concert.conductor) {
            display += " (conducted by " + concert.conductor + ")";
        }
        $concertSelect.append(
            $("<option>")
                .val(concert.id_concert)
                .text(display)
        );
    });

    // Populate the ensemble select with options from window.ensembles
    var $ensembleSelect = $('#id_ensemble');
    $ensembleSelect.empty();
    $ensembleSelect.append("<option value=''>Select ensemble</option>");
    window.ensembles.forEach(function(ensemble) {
        $ensembleSelect.append(
            $("<option>")
                .val(ensemble.id_ensemble)
                .text(ensemble.name)
        );
    });

    // Add button click handler
    // This will reset the form for a new recording
    $('#add').click(function(){
        $('#insert').val("Insert");
        $('#update').val("add");
        $('#insert_form')[0].reset();
    });
    $('#catalog_number').change(function() { // when user selects a catalog number get its details
        // Get the catalog number from the selected option
        // and fetch its details via AJAX
        console.log("Catalog number changed");
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
    // Enable the edit and delete buttons, and get the playgram ID when a table row is clicked
    $(document).on('click', '#recordings_table tbody tr', function(){
        $(this).find('input[type="radio"]').prop('checked',true);
        $('#edit, #delete, #sort').prop('disabled',false);
        id_recording = $(this).data('id'); // data-id attribute
    });

    // Get recording when user clicks the edit button
    $(document).on('click', '.edit_data', function(){
        $.ajax({
            url:"includes/fetch_recordings.php",
            method:"POST",
            data:{id_recording:id_recording},
            dataType:"json",
            success:function(result){
                $('#id_recording').val(result.id_recording);
                $('#id_concert').val(result.id_concert);

                // Trigger change to load catalog numbers for this concert
                $('#id_concert').trigger('change');

                // Wait for AJAX call to finish before setting catalog number
                // Use a small timeout to ensure the concert options are loaded
                setTimeout(function() {
                    $('#catalog_number').val(result.catalog_number);
                }, 300);

                $('#name').val(result.name);
                $('#id_ensemble').val(result.id_ensemble);
                $('#ensemble').val(result.ensemble);
                $('#date').val(result.date);
                $('#notes').val(result.concert_notes);
                $('#venue').val(result.venue);
                $('#composer').val(result.composer);
                $('#arranger').val(result.arranger);

                if ((result.enabled) == 1) {
                    $('#enabled').prop('checked',true);
                } else {
                    $('#enabled').prop('checked',false);
                }
                $('#filedate').text(result.date);
                $('#linkDisplay').text(result.link);
                // Form is ready to update
                $('#insert').val("Update");
                $('#update').val("update");
            }
        });
    });
    $(document).on('click', '.delete_data', function(){ // button that brings up modal
        // var id_recording = $(this).attr("id");
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
    $('#link').on('change', function() {
        var fileInput = this;
        if (fileInput.files && fileInput.files[0]) {
            var fileName = fileInput.files[0].name;
            $('#linkDisplay').text(fileName);
        } else {
            $('#linkDisplay').text('-----.---');
        }
    });
    $('#insert_form').on("submit", function(event){
        event.preventDefault();
        if ($('#catalog_number').val() === "") {
            alert("Please choose a composition (catalog number)");
        } else if ($('#id_concert').val() === "") {
            alert("Please choose a concert");
        } else if ($('#id_ensemble').val() === "") {
            alert("Please choose an ensemble");
        } else if (!$('#link')[0].files.length && !($('#id_recording').val() !== "" && $('#update').val() === "update")) {
            // Only require a file if not updating
            alert("Please choose a file to upload");
        } else if ($('#filedate').val() === "0000-00-00") {
            alert("Please set the file date to the concert date");
        } else {
            var formData = new FormData(this);
            formData.append('filedate', $('#filedate').val());
            formData.append('linkDisplay', $('#linkDisplay').text());
            formData.append('venue', $('#venue').val()); // Add the venue to the form data
            console.log("Form data: " + JSON.stringify(Object.fromEntries(formData)));
            $.ajax({
                url:"includes/insert_recordings.php",
                method:"POST",
                data:formData,
                contentType: false,
                processData: false,
                beforeSend:function(){
                    $('#insert').val("Inserting");
                },
                success:function(data){
                    $('#insert_form')[0].reset();
                    $('#editModal').modal('hide');
                    // Show the message modal with the response
                    $('#message_detail').html('<p class="' + (data.success ? 'text-success' : 'text-danger') + '">' + data.message + '</p>');
                    $('#messageModal').modal('show');
                    // Refresh the table
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
        var view_id_recording = $(this).attr("id");
        // id_recording will look like "view_123"
        if(view_id_recording != '')
        {
            let id_recording = view_id_recording.substr(5);
            console.log("View recording " + id_recording);
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
