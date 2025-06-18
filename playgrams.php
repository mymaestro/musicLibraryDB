<?php
  define('PAGE_TITLE', 'Playgrams');
  define('PAGE_NAME', 'Playgrams');
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
  ferror_log("RUNNING playgrams.php");
?>
<main role="main">
    <div class="container">
        <button type="button" class="btn btn-warning btn-floating btn-lg" id="btn-back-to-top">
            <i class="fas fa-arrow-up"></i>
        </button>
        <div class="row pb-3 pt-5 border-bottom"><h1><?php echo ORGNAME . ' '. PAGE_NAME ?></h1></div>
<?php if($u_librarian) : ?>
        <div class="row pt-3 justify-content-end">
            <div class="col-auto">
                <a href="playgramsorderlist.php" class="btn btn-info disabled" role="button" name="sort" id="sort">Set program order</a>
                <button type="button" data-bs-toggle="modal" data-bs-target="#editModal" id="edit" class="btn btn-primary edit_data" disabled>Edit</button>
                <button type="button" data-bs-toggle="modal" data-bs-target="#deleteModal" id="delete" class="btn btn-danger delete_data" disabled>Delete</button>
                <button type="button" data-bs-toggle="modal" data-bs-target="#editModal" id="add"  class="btn btn-warning">Add</button>
            </div>
        </div><!-- right button -->
<?php endif; ?>
        <div id="playgram_table">
            Loading table...
        </div><!-- playgram_table -->
        <div id="dataModal" class="modal"><!-- view data -->
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Program playlist details</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div><!-- modal-header -->
                    <div class="modal-body" id="playgram_detail">
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
                        <h5 class="mb-0">Delete program playlist <span id="playgram2delete">#</span>?</h5>
                        <div class="modal-body text-start" id="playgram-delete_detail">
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
        <div id="editModal" class="modal" tabindex="-1" aria-hidden="true"><!-- add/edit data -->
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Program playlist information</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div><!-- modal-header -->
                    <div class="modal-body">
                    <div class="container-fluid">
                        <form method="post" id="insert_form">
                            <input type="hidden" name="id_playgram" id="id_playgram" />
                            <div class="row bg-white">
                                <div class="col-md-3">
                                    <label for="name" class="col-form-label">Program playlist name*</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Playlist Fall 2029" required/>
                                </div>
                            </div>
                            <div class="row bg-white">
                                <div class="col-md-12">
                                    <label for="description" class="col-form-label">Description (up to 2048 characters)</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" maxlength="2048"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="id_composition_list" class="col-form-label">Composition(s) on the program.</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-flex" id="playgram_compositions">
                                    <div class="col-md-5">
                                        <select class="form-select form-control text-muted d-flex" aria-label="Select composition" size="19" id="id_composition_list" name="id_composition_list[]" multiple>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                    </br>
                                        <p class="text-center">
                                            <button type="button" class="btn btn-light" name="add_composition" id="add_composition"><i class="fa fa-angle-right"></i></button>
                                        </br>
                                            <button type="button" class="btn btn-light" id="remove_composition"><i class="fa fa-angle-left"></i></button>
                                        </p>
                                    </div>
                                    <div class="col-md-5">
                                        <select class="form-select form-control d-flex" aria-label="Select composition" size="19" id="id_composition" name="id_composition[]" multiple>
                                        </select>
                                    </div>
                                </div><!-- part_compositions -->                                
                            </div>
                            <hr />
                            <div class="row bg-white">
                                <div class="col-md-12">
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
        </div><!-- editModal -->
    </div><!-- container -->
</main>
<?php require_once("includes/footer.php");?>
<script>
// Load compositions data into a JSON array for frequent use
<?php
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$sql = "SELECT `catalog_number`, `name`, `composer`,`arranger` FROM compositions WHERE `enabled` = 1 ORDER BY name;";
ferror_log("Running " . $sql);
$res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
$jsondata = "var compositionData = [";
while($rowList = mysqli_fetch_array($res)) {
    $comp_catno = $rowList['catalog_number'];
    $comp_name = $rowList['name'];
    $comp_composer = $rowList['composer'];
    $comp_arranger = $rowList['arranger'];
    $comp_display = $comp_name . " - " . $comp_catno;
    if (("$comp_composer" <> "" ) || ("$comp_arranger" <> "")) $comp_display .= ' (';
    if (("$comp_composer" <> "" ) && ("$comp_arranger" <> "")) $comp_display .= $comp_composer . ", arr. " . $comp_arranger . ")";
    if (("$comp_composer" == "" ) && ("$comp_arranger" <> "")) $comp_display .= "arr. " . $comp_arranger . ")";
    if (("$comp_composer" <> "" ) && ("$comp_arranger" == "")) $comp_display .=  $comp_composer . ")";
    $jsondata .= '{"catalog_number":"'.$comp_catno.'","name":"'.$comp_display.'"},';
}
$jsondata = rtrim($jsondata, ',');
$jsondata .= ']'.PHP_EOL;
mysqli_close($f_link);
echo $jsondata;
?>
// jQuery functions
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

    let id_playgram = null;  // Which row user clicks
    $.ajax({
        url:"includes/fetch_playgrams.php",
        method:"POST",
        data:{
            user_role: "<?php echo ($u_librarian) ? 'librarian' : 'nobody'; ?>"
        },
        success:function(data){
            $('#playgram_table').html(data);
        }
    });

    $('#add').click(function(){
        $('#insert').val("Insert");
        $('#update').val("add");
        $('#insert_form')[0].reset();
        var selectitems = '';
        $.each(compositionData, function(key, value) {
            selectitems += '<option value=' + value.catalog_number +'>'+ value.name+'</option>';
        });
        $('#id_composition_list').html(selectitems);
    });
    // Enable the edit and delete buttons, and get the playgram ID when a table row is clicked
    $(document).on('click', '#playgram_table tbody tr', function(){
        $(this).find('input[type="radio"]').prop('checked',true);
        $('#edit, #delete').prop('disabled',false);
        $('#sort').removeClass('disabled');
        id_playgram = $(this).data('id'); // data-id attribute
    });

    $(document).on('click', '.edit_data', function(){
        $.ajax({
            url:"includes/fetch_playgrams.php",
            method:"POST",
            data:{ id_playgram : id_playgram },
            dataType:"json",
            success:function(result){
                const obj = JSON.parse(result);
                var playgram = obj.playgram;
                var compositions = obj.compositions;
                var selectitems = '';
                // Available compositions
                $.each(compositionData, function(key, value) {
                    selectitems += '<option value=' + value.catalog_number +'>'+ value.name+'</option>';
                });
                $('#id_composition_list').html(selectitems);
                // Selected compositions
                //selectitems = '';
                $('#id_composition').empty();
                $.each(compositions, function(key, value) {
                    const match = compositionData.find(item => item.catalog_number === value.catalog_number);
                    if (match) { name = match.name } else { name = "Unknown"};
                    //selectitems += '<option value='+value.catalog_number+'>'+name+'</option>';
                    $('#id_composition').append($('<option>', {
                        value: value.catalog_number,
                        text: name
                    }))
                });
                //$('#id_composition').html(selectitems);
                // Remove already selected items from available options
                $('#id_composition option').each(function () {
                    let val = $(this).val();
                    $('#id_composition_list option[value="'+ val + '"]').remove();
                });
                $('#id_playgram').val(playgram.id_playgram);
                $('#name').val(playgram.name);
                $('#description').val(playgram.description);
                if ((playgram.enabled) == 1) {
                    $('#enabled').prop('checked',true);
                };
                $('#insert').val("Update");
                $('#update').val("update");
                $('#editModal').modal('show');
            }
        });
    });

    // Move compositions left or right
    $("#add_composition").click(function() {
        $("#id_composition_list :selected").each(function(){
            $(this).remove().appendTo('#id_composition');
        });
    });
    $('#remove_composition').click(function() {
        $("#id_composition :selected").each(function(){
            $(this).remove().appendTo('#id_composition_list');
        });
    });

    $(document).on('click', '.delete_data', function() { // button that brings up delete modal
        if(id_playgram !== null) {
            $.ajax({
                url:"includes/select_playgrams.php",
                method:"POST",
                data:{id_playgram:id_playgram},
                success:function(data){
                    $('#playgram-delete_detail').html(data);
                }
            });
        }
        $('#confirm-delete').data('id', id_playgram); // Set the id for delete function
        $('#playgram2delete').text(id_playgram); // Update ID in the modal
    });
    $('#confirm-delete').click(function(){ // The confirm delete button
        $.ajax({
            url:"includes/delete_records.php",
            method:"POST",
            data:{
                table_name: "playgrams",
                table_key_name: "id_playgram",
                table_key: id_playgram
            },
            success:function(response){
                $('#insert_form')[0].reset();
                if (response.success) {
                    $('#playgram_table').html('<p><a href="#" onclick="window.location.reload(true)">Return</a></p><p class="text-success">Record ' + response.message + ' deleted from playgrams</p>');
                } else {
                    $('#playgram_table').html('<p class="text-danger">Error: <emp>' + response.error + '</emp></p>');                
                }
            },
            error:function(xhr, status, error){
                alert("Unexpected XHR error " + error);
            }
        });
        // NEED TO ALSO DELETE MATCHING PLAYGRAM_ITEMS
    });
    $('#insert_form').on("submit", function(event){
        event.preventDefault();
        if ($('#id_composition') === undefined || $('#id_composition').length === 0) {
            alert("No compositions!");
        }
        $('#id_composition option').prop('selected',true);
        if($('#name').val() == "")
        {
            alert("Program playlist name is required");
        } else {
            $.ajax({
                url:"includes/insert_playgrams.php",
                method:"POST",
                data:$('#insert_form').serialize(),
                beforeSend:function(){
                    $('#insert').val("Inserting");
                },
                success:function(data){
                    $('#insert_form')[0].reset();
                    $('#editModal').modal('hide');
                    $.ajax({
                        url:"includes/fetch_playgrams.php",
                        method:"POST",
                        data:{
                            user_role: "<?php echo ($u_librarian) ? 'librarian' : 'nobody'; ?>"
                        },
                        success:function(data){
                            $('#playgram_table').html(data);
                        }
                    });
                }
            });
        }
    });
    $(document).on('click', '.view_data', function(){
        var id_playgram = $(this).attr("id");
        if(id_playgram !== null) {
            $.ajax({
                url:"includes/select_playgrams.php",
                method:"POST",
                data:{id_playgram:id_playgram},
                success:function(data){
                    $('#playgram_detail').html(data);
                    $('#dataModal').modal('show');
                }
            });
        }
    });
});
</script>
</body>
</html>
