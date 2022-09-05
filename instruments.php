<?php
  define('PAGE_TITLE', 'List instruments');
  define('PAGE_NAME', 'Instruments');
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
  ferror_log("RUNNING instruments.php");
?>
<main role="main">
    <div class="container">
        <h2 align="center"><?php echo ORGNAME ?> <?php echo PAGE_NAME?></h2>
<?php if($u_librarian) : ?>
        <div align="right">
            <a href="instrumentsorderlist.php" class="btn btn-info" role="button" name="sort" id="sort">Set score order</a>
            <button type="button" name="add" id="add" data-bs-toggle="modal" data-bs-target="#add_data_Modal" class="btn btn-warning">Add</button>
            <br />
        </div><!-- right button -->
<?php endif; ?>
        <div id="instrument_table" align="center">
            Loading table...
        </div><!-- instrument_table -->

        <div id="dataModal" class="modal"><!-- view data -->
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Instrument details</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div><!-- modal-header -->
                    <div class="modal-body" id="instrument_detail">
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
                        <h5 class="mb-0">Delete this instrument?</h5>
                        <p id="instrument2delete">You can cancel now.</p>
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
                        <h4 class="modal-title">Instrument information</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div><!-- modal-header -->
                    <div class="modal-body">
                    <div class="container-fluid">
                        <form method="post" id="insert_form">
                            <input type="hidden" name="id_instrument" id="id_instrument" />
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
                                    <label for="name" class="col-form-label">Instrument name*</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Vuvuzela 4" required/>
                                </div>
                            </div>
                            <div class="row bg-white">
                                <div class="col-md-3">
                                    <label for="family" class="col-form-label">Instrument family</label>
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
                                        <label class="form-check-label" for="Voice">Voice </label>
                                        <input type="radio" class="form-check-input" id="Voice" name="family" value="Voice">
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
                                    <div class="form-check">
                                        <label for="enabled" class="form-check-label">Enabled</label>
                                        <input class="form-check-input" id="enabled" name="enabled" type="checkbox" value="1"></>
                                    </div>
                                </div>
                            </div>
                    </div><!-- container-fluid -->
                    </div><!-- modal-body -->
                    <div class="modal-footer">  
                            <input type="hidden" name="result-message" id="result-message" value="Nothing to report" class="btn" />
                            <input type="hidden" name="update" id="update" value="0" />
                            <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" />
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>  
                        </form>  
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
<!-- jquery function to add/update database records -->
<script>
$(document).ready(function(){
    $.ajax({
        url:"includes/fetch_instruments.php",
        method:"POST",
        data:{
            user_role: "<?php echo ($u_librarian) ? 'librarian' : 'nobody'; ?>"
        },   
        success:function(data){
            $('#instrument_table').html(data);
        }
    });

    $('#add').click(function(){
        $('#insert').val("Insert");
        $('#update').val("add");
        $('#insert_form')[0].reset();
    });
    $(document).on('click', '.edit_data', function(){
        var id_instrument = $(this).attr("id");
        // Load instruments table
        $.ajax({
            url:"includes/fetch_instruments.php",
            method:"POST",
            data:{id_instrument:id_instrument},
            dataType:"json",
            success:function(data){
                $('#id_instrument').val(data.id_instrument);
                $('#collation').val(data.collation);
                $('#name').val(data.name);
                $('#description').val(data.description);
                $('#' + data.family).prop('checked', true);
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
        // input button name="delete" id="id_instrument" class="delete_data"
        var id_instrument = $(this).attr("id");
        $('#deleteModal').modal('show');
        $('#confirm-delete').data('id', id_instrument);
        $('#instrument2delete').text(id_instrument);
    });
    $('#confirm-delete').click(function(){
        // The confirm delete button
        var id_instrument = $(this).data('id');
        $.ajax({
            url:"includes/delete_records.php",
            method:"POST",
            data:{
                table_name: "instruments",
                table_key_name: "id_instrument",
                table_key: id_instrument
            },
            success:function(data){
                $('#message_detail').html(data);
                $('#messageModal').modal('show');
                $.ajax({
                    url:"includes/fetch_instruments.php",
                    method:"POST",
                    data:{
                        user_role: "<?php echo ($u_librarian) ? 'librarian' : 'nobody'; ?>"
                    },   
                    success:function(data){
                        $('#instrument_table').html(data);
                    }
                });
            }
        });
    });
    $('#insert_form').on("submit", function(event){
        event.preventDefault();        
        if($('#name').val() == "")
        {
            alert("Instrument name is required");
        }
        else if($('#collation').val() == '')
        {
            alert("Sort order is required");
        }
        else
        {
            $.ajax({
                url:"includes/insert_instruments.php",
                method:"POST",
                data:$('#insert_form').serialize(),
                beforeSend:function(){
                    $('#insert').val("Inserting");
                },
                success:function(data){
                    $('#insert_form')[0].reset();
                    $('#add_data_Modal').modal('hide');
                    $.ajax({
                        url:"includes/fetch_instruments.php",
                        method:"POST",
                        data:{
                            user_role: "<?php echo ($u_librarian) ? 'librarian' : 'nobody'; ?>"
                        },   
                        success:function(data){
                            $('#instrument_table').html(data);
                        }
                    });
                }
            });
        }
    });
    $(document).on('click', '.view_data', function(){
        var id_instrument = $(this).attr("id");
        if(id_instrument != '')
        {
            $.ajax({
                url:"includes/select_instruments.php",
                method:"POST",
                data:{id_instrument:id_instrument},
                success:function(data){
                    $('#instrument_detail').html(data);
                    $('#dataModal').modal('show');
                }
            });
        }
    });
});
</script>
</body>
</html>
