<?php
  define('PAGE_TITLE', 'List playgrams');
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
        <h1 align="center"><?php echo ORGNAME ?> Program playlists</h1>
<?php if($u_librarian) : ?>
        <div align="right">
            <a href="playgramsorderlist.php" class="btn btn-info" role="button" name="sort" id="sort">Set program order</a>
            <button id="editBtn" class="btn btn-primary" disabled>Edit</button>
            <button id="deleteBtn" class="btn btn-danger" disabled>Delete</button>
            <button type="button" name="add" id="add" data-bs-toggle="modal" data-bs-target="#add_data_Modal" class="btn btn-warning">Add</button>
            <br />
        </div><!-- right button -->
<?php endif; ?>
        <button type="button" class="btn btn-warning btn-floating btn-lg" id="btn-back-to-top">
            <i class="fas fa-arrow-up"></i>
        </button>
        <div id="playgram_table" align="center">
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
            <div class="modal-dialog" role="document">
                <div class="modal-content rounded-4 shadow">
                    <div class="modal-body p-4 text-center">
                        <h5 class="mb-0">Delete this program playlist?</h5>
                        <p id="playgram2delete">You can cancel now.</p>
                    </div>
                    <div class="modal-footer flex-nowrap p-0">
                        <button type="button" class="btn btn-lg btn-link text-decoration-none rounded-0 border-right" id="confirm-delete" data-bs-dismiss="modal"><strong>Yes, delete</strong></button>
                        <button type="button" class="btn btn-lg btn-link text-decoration-none rounded-0" data-bs-dismiss="modal">No thanks</button>
                    </div><!-- modal-footer -->
                </div><!-- modal-content -->
            </div><!-- modal-dialog -->
        </div><!-- deleteModal -->
        <div id="add_data_Modal" class="modal"><!-- add/edit data -->
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
        </div><!-- add_data_modal -->
    </div><!-- container -->
</main>
<?php require_once("includes/footer.php");?>
<script>
    // Load compositions data into a JSON array for frequent use
<?php
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$sql = "SELECT `id_instrument`, `collation`, `name` FROM instruments WHERE `enabled` = 1 ORDER BY collation;";
ferror_log("Running " . $sql);
$res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
$jsondata = "var instrumentdata = [";
while($rowList = mysqli_fetch_array($res)) {
    $id_instrument = $rowList['id_instrument'];
    $collation = $rowList['collation'];
    $instrument_name = $rowList['name'];
    $jsondata .= '{"collation":'.$collation.',"id":'.$id_instrument.',"name":"'.$instrument_name.'"},';
}
$jsondata = rtrim($jsondata, ',');
$jsondata .= ']'.PHP_EOL;
mysqli_close($f_link);
echo $jsondata;
ferror_log("returned: " . $sql);
?>

// Scroll-to-top button
let mybutton = document.getElementById("btn-back-to-top");
// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function () {
    scrollFunction();
};
function scrollFunction() {
    if (
        document.body.scrollTop > 20 ||
        document.documentElement.scrollTop > 20
        ) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }
    // When the user chooses scrollbutton, scroll to the top of the document
mybutton.addEventListener("click", backToTop);
function backToTop() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}
// jquery functions to add/update database records
$(document).ready(function(){
    // Enable edit buttons when row is selected
    $('.select-radio').on('change', function() {
        $('#editBtn, #deleteBtn').prop('disabled',false);
    });
    $.ajax({
        url:"includes/fetch_playgrams.php",
        method:"POST",
        data:{
            user_role: "<?php echo ($u_librarian) ? 'librarian' : 'nobody'; ?>"
        },   
        success:function(data){
            $('#playgram_table').html(data);
            var selectitems = '';
            $.each(instrumentdata, function(key, value) {
                selectitems += '<option value=' + value.id + '>' + value.name + '</option>';
                $(".instrument_" + value.id).text(value.name);
            });
            $('#default_instrument').html(selectitems);
        }
    });
    $('#add').click(function(){
        $('#insert').val("Insert");
        $('#update').val("add");
        $('#insert_form')[0].reset();
    });
    $(document).on('click', '.edit_data', function(){
        var id_playgram = $(this).attr("id");
        $.ajax({
            url:"includes/fetch_playgrams.php",
            method:"POST",
            data:{id_playgram:id_playgram},
            dataType:"json",
            success:function(data){
                $('#id_playgram').val(data.id_playgram);
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
        // input button name="delete" id="id_playgram" class="delete_data"
        var id_playgram = $(this).attr("id");
        $('#deleteModal').modal('show');
        $('#confirm-delete').data('id', id_playgram);
        $('#playgram2delete').text(id_playgram);
    });
    $('#confirm-delete').click(function(){
        // The confirm delete button
        var id_playgram = $(this).data('id');
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
                    $('#playgram_table').html('<p class="text-success">Record ' + response.message + ' deleted from playgrams</p>');
                } else {
                    $('#playgram_table').html('<p class="text-danger">Error: <emp>' + response.error + '</emp></p>');                
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
            alert("Program playlist name is required");
        }
        else if($('#collation').val() == '')
        {
            alert("Sort order is required");
        }
        else
        {
            $.ajax({
                url:"includes/insert_playgrams.php",
                method:"POST",
                data:$('#insert_form').serialize(),
                beforeSend:function(){
                    $('#insert').val("Inserting");
                },
                success:function(data){
                    $('#insert_form')[0].reset();
                    $('#add_data_Modal').modal('hide');
                    $.ajax({
                        url:"includes/fetch_playgrams.php",
                        method:"POST",
                        data:{
                            user_role: "<?php echo ($u_librarian) ? 'librarian' : 'nobody'; ?>"
                        },
                        success:function(data){
                            $('#playgram_table').html(data);
                            $.each(instrumentdata, function(key, value) {
                                $(".instrument_" + key).text(value);
                            });
                        }
                    });
                }
            });
        }
    });
    $(document).on('click', '.view_data', function(){
        var id_playgram = $(this).attr("id");
        if(id_playgram != '')
        {
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
