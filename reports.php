<?php
  session_start();
  define('PAGE_TITLE', 'Reports about the music library');
  define('PAGE_NAME', 'reports');
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
  require_once("includes/config.php");
?>
<br />
<div class="container">
  <h1>Music Library Reports</h1>
  <p>Missing parts <input type="button" name="view" value="View" id="report_missing_parts" class="btn btn-secondary btn-sm missing_parts" /></p>
  <p>List <a href="list_recordings.php">Recordings</a></p>
  <p>Enter <a href="composition_instrumentation.php">composition instrumentations</a></p>
  <div class="modal" id="view_data_modal"><!-- view data -->
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Report details</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div><!-- modal-header -->
                <div class="modal-body" id="report_detail">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div><!-- modal-footer -->
            </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- view_data_modal -->
</div>
</main>
<script>
$(document).on('click', '.missing_parts', function(){
            var catalog_number = $(this).attr("id");
            if(catalog_number != '')
            {
                $.ajax({
                    url:"report_missing_parts.php",
                    type:"POST",
                    data:{report:"missing_parts"},
                    success:function(data){
                        $('#report_detail').html(data);
                        $('#view_data_modal').modal('show');
                    }
                });
            }
        });
</script>
<?php
  require_once("includes/footer.php");
?>
