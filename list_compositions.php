<?php
  define('PAGE_TITLE', 'List compositions');
  define('PAGE_NAME', 'Compositions');
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
  error_log("RUNNING list_compositions.php");
?>
    <br />
    <div class="container">
        <h2 align="center"><?php echo ORGNAME ?> Compositions</h2>
<?php if($u_admin) : ?>
        <div align="right">
            <button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-warning">Add</button>
            <br />
        </div><!-- right -->
<?php endif; ?>
        <div id="compositions_table">
        <?php
        require_once('includes/config.php');
        require_once('includes/functions.php');
        echo '
            <div class="panel panel-default">
               <div class="table-repsonsive">
                    <table class="table table-hover">
                    <caption class="title">Available Compositions</caption>
                    <thead>
                    <tr>
                        <th>Catalog number</th>
                        <th>Name</th>
                        <th>Composer</th>
                        <th>Description</th>
                        <th>Enabled</th>
                    </tr>
                    </thead>
                    <tbody>';
        $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $sql = "SELECT * FROM compositions ORDER BY catalog_number;";
        $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
        while ($rowList = mysqli_fetch_array($res)) {
            $catalog_number = $rowList['catalog_number'];
            $name = $rowList['name'];
            $description = $rowList['description'];
            $composer = $rowList['composer'];
            $enabled = $rowList['enabled'];
            echo '<tr>
                        <td>'.$catalog_number.'</td>
                        <td>'.$name.'</td>
                        <td>'.$composer.'</td>
                        <td>'.$description.'</td>
                        <td>'. (($enabled == 1) ? "Yes" : "No") .'</td>';
            if ($u_admin) { echo '
                        <td><input type="button" name="delete" value="Delete" id="'.$catalog_number.'" class="btn btn-danger btn-sm delete_data" /></td>
                        <td><input type="button" name="edit" value="Edit" id="'.$catalog_number.'" class="btn btn-primary btn-sm edit_data" /></td>'; }
            echo '
                        <td><input type="button" name="view" value="View" id="'.$catalog_number.'" class="btn btn-secondary btn-sm view_data" /></td>
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Composition details</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div><!-- modal-header -->
                <div class="modal-body" id="composition_detail">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div><!-- modal-footer -->
            </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- dataModal -->
    <div id="add_data_Modal" class="modal" role="document"><!-- add_data_Modal -->
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Compositions information</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div><!-- modal-header -->
                <div class="modal-body">
                  <div class="container-fluid">
                    <form method="post" id="insert_form">
                        <div class="row bg-light">
                            <div class="col-md-3">
                                <!-- catalog_number (5 characters) 'The catalog number is a letter and 3-digit number, for example M101' -->
                                <label for="catalog_number" class="col-form-label">Catalog number*</label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="catalog_number" name="catalog_number" placeholder="X" required minlength="2" maxlength="5" size="5"/>
                            </div>
                        </div>
                        <hr />
                        <div class="row bg-white">
                            <div class="col-md-3">
                                <!-- name (255 characters)  'The title of the composition' -->
                                <label for="name" class="col-form-label">Title*</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Musical comedy with a plot" aria-describedby="titleHelp" required minlength="3" maxlength="255"/>
                                <small id="titleHelp" class="form-text text-muted">Enter the title of the composition</small>
                            </div>
                        </div>
                        <div class="row bg-white">
                            <div class="col-md-12">
                                <!-- description (512 characters)  'Description of the composition' -->
                                <label for="description" class="col-form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" maxlength="255" aria-describedby="descriptionHelp"></textarea>
                                <small id="descriptionHelp" class="form-text text-muted">Enter a description of the composition</small>
                            </div>
                        </div>
                        <div class="row bg-white">
                            <div class="col-md-2">
                                <!-- composer (255 characters)  'The composer of the piece' -->
                                <label for="composer" class="col-form-label">Composer*</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="composer" name="composer" placeholder="Comb Poseur" required maxlength="255"/>
                                <small id="composerHelp" class="form-text text-muted">Enter the name of the composer of the composition</small>
                            </div>
                            <div class="col-md-2">
                                <!-- editor (255 characters)  'The editor or lyricist' -->
                                <label for="editor" class="col-form-label">Editor</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="editor" name="editor" placeholder="Ed Itor" maxlength="255"/>
                                <small id="editorHelp" class="form-text text-muted">Enter the name of the editor of the composition</small>
                            </div>
                        </div>
                        <div class="row bg-white">
                            <div class="col-md-2">
                                <!-- arranger (255 characters)  'The arranger of the piece' -->
                                <label for="arranger" class="col-form-label">Arranger</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="arranger" name="arranger" placeholder="Art Ranger" maxlength="255"/>
                                <small id="arrangerHelp" class="form-text text-muted">Enter the name of the arranger of the composition</small>
                            </div>
                            <div class="col-md-2">
                                <!-- publisher (255 characters)  'The name of the publishing company' -->
                                <label for="publisher" class="col-form-label">Publisher</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="publisher" name="publisher" placeholder="P. Blisher" maxlength="255"/>
                                <small id="publisherHelp" class="form-text text-muted">Enter the name of the publisher of the composition</small>
                            </div>
                        </div>
                        <div class="row bg-white">
                            <div class="col-md-2">
                                <!-- genre (4 characters)  'Which genre is the piece (from the genres table)' -->
                                <label for="genre" class="col-form-label">Genre</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="genre" name="genre" placeholder="Z" maxlength="4"/>
                                <small id="genreHelp" class="form-text text-muted">This will be a selection from the Genres table</small>
                            </div>
                            <div class="col-md-2">
                                <!-- ensemble (4 characters)  'Which ensemble plays this piece ' -->
                                <label for="ensemble" class="col-form-label">Ensemble</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="ensemble" name="ensemble" placeholder="Z" maxlength="4"/>
                                <small id="ensembleHelp" class="form-text text-muted">This will be a selection from the Ensembles table</small>
                            </div>
                        </div>
                        <div class="row bg-white">
                            <div class="col-md-2">
                                <!-- grade decimal(1,1) UNSIGNED  'Grade of difficulty' -->
                                <label for="grade" class="col-form-label">Grade level (1-5)</label>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="grade" id="grade1" value="1">
                                    <label class="form-check-label" for="grade1">1</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="grade" id="grade2" value="2">
                                    <label class="form-check-label" for="grade2">2</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="grade" id="grade3" value="3">
                                    <label class="form-check-label" for="grade3">3</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="grade" id="grade4" value="4">
                                    <label class="form-check-label" for="grade4">4</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="grade" id="grade5" value="5">
                                    <label class="form-check-label" for="grade4">5</label>
                                </div>
                                <small id="gradeHelp" class="form-text text-muted">Level of difficulty</small>
                            </div>
                            <div class="col-md-2">
                                <!-- paper_size (4 characters)  'Physical size, from the paper_sizes table' -->
                                <label for="paper_size" class="col-form-label">Paper size</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="paper_size" name="paper_size" placeholder="Z" maxlength="4"/>
                                <small id="paper_sizeHelp" class="form-text text-muted">What size of paper are the parts on? Select from the paper_sizes options.</small>
                            </div>
                        </div>
                        <div class="row bg-white">
                            <div class="col-md-2">
                                <!-- last_performance_date datetime  'When the composition was last performed' -->
                                <label for="last_performance_date" class="col-form-label">Last performed</label>
                            </div>
                            <div class="col-md-4">
                                <input type="date" class="form-control" id="last_performance_date" name="last_performance_date" placeholder="20180101T220000" />
                                <small id="last_performance_dateHelp" class="form-text text-muted">The date this piece was last performed</small>
                            </div>
                            <div class="col-md-2">
                                <!-- duration_start datetime  'Time the piece starts - to calculate duration' -->
                                <!-- duration_end datetime  'The time the piece ends - to calculate duration' -->
                                <label for="duration_start" class="col-form-label">Duration (start/end time)</label>
                            </div>
                            <div class="col-md-4">
                                <input type="datetime" class="form-control" id="duration_start" name="duration_start" placeholder="20180101T220000" />
                                <input type="datetime" class="form-control" id="duration_end" name="duration_end" placeholder="20180101T220000" />
                                <small id="durationHelp" class="form-text text-muted">Start and end times to calculate performance duration</small>
                            </div>
                        </div>
                        <div class="row bg-white">
                            <div class="col-md-12">
                                <!-- comments (4096 characters)  'Comments about the piece, liner notes' -->
                                <label for="comments" class="col-form-label">Comments</label>
                                <textarea class="form-control" id="comments" name="comments" rows="3" maxlength="4096"></textarea>
                                <small id="commentsHelp" class="form-text text-muted">Comments, or "liner notes" about this piece - they could appear in programs.</small>
                            </div>
                        </div>
                        <div class="row bg-white">
                            <div class="col-md-12">
                                <!-- performance_notes (2048 characters)  'Performance notes (how to rehearse it, for example)' -->
                                <label for="performance_notes" class="col-form-label">Performance notes</label>
                                <textarea class="form-control" id="performance_notes" name="performance_notes" rows="3" maxlength="2048"></textarea>
                                <small id="performance_notesHelp" class="form-text text-muted">Performance notes (how to rehearse it, for example).</small>
                            </div>
                        </div>
                        <div class="row bg-white">
                            <div class="col-md-2">
                            <!-- storage_location (255 characters)  'Where it is kept (which drawer)' -->
                            <label for="storage_location" class="col-form-label">Storage location</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="storage_location" name="storage_location" placeholder="Third drawer from the left." maxlength="255"/>
                                <small id="storage_locationHelp" class="form-text text-muted">In which city, building, filing cabinet, or drawer might one find this piece of music?</small>
                            </div>
                        </div>
                        <div class="row bg-white">
                            <div class="col-md-2">
                            <!-- date_acquired datetime  'When the piece was acquired' -->
                            <label for="date_acquired" class="col-form-label">Date acquired</label>
                            </div>
                            <div class="col-md-4">
                                <input type="date" class="form-control" id="date_acquired" name="date_acquired" placeholder="20180101T220000" />
                                <small id="date_acquiredHelp" class="form-text text-muted">When was the piece of music acquired?</small>
                            </div>
                            <div class="col-md-2">
                                <!-- cost decimal(4,2)  'How much did it cost, in dollars and cents' -->
                                <label for="cost" class="col-form-label">Cost</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="cost" name="cost" placeholder="999.99" maxlength="6"/>
                                <small id="costHelp" class="form-text text-muted">How much did the piece of music cost (or, how much will it cost to replace)?</small>
                            </div>
                        </div>
                        <div class="row bg-white">
                            <div class="col-md-2">
                            <!-- listening_example_link (255 characters)  'A link to a listening example, maybe on YouTube' -->
                            <label for="listening_example_link" class="col-form-label">Listening example</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="listening_example_link" name="listening_example_link" placeholder="https://acwe.org/recordings/piece.mp3" maxlength="255"/>
                                <small id="listening_example_linkHelp" class="form-text text-muted">Where can you find a recording of this arrangement of this piece?</small>
                            </div>
                        </div>
                        <div class="row bg-white">
                            <div class="col-md-2">
                            <!-- windrep (255 characters)  'A link to this piece on windrep.org' -->
                            <label for="windrep_link" class="col-form-label">Wind Repertory Project link</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="windrep_link" name="windrep_link" placeholder="https://www.windrep.org/Russian_Christmas_Music" maxlength="255"/>
                                <small id="windrep_linkHelp" class="form-text text-muted">Where can you this arrangement on the Wind Repertory site?</small>
                            </div>
                        </div>
                        <div class="row bg-white">
                            <div class="col-md-2">
                            <!-- checked_out (255 characters)  'To whom was this piece lended' -->
                            <label for="checked_out" class="col-form-label">Checked out</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="checked_out" name="checked_out" placeholder="Not checked out" maxlength="255"/>
                                <small id="checked_outHelp" class="form-text text-muted">If this piece is on loan to someone else, where is it?</small>
                            </div>
                        </div>
                        <div class="row bg-white">
                            <div class="col-md-2">
                            <!-- last_inventory_date datetime  'When was the last time somebody touched this music' -->
                            <label for="last_inventory_date" class="col-form-label">Last inventory</label>
                            </div>
                            <div class="col-md-4">
                                <input type="date" class="form-control" id="last_inventory_date" name="last_inventory_date" placeholder="20180101T220000" />
                                <small id="last_inventory_dateHelp" class="form-text text-muted">When was the last time somebody touched this music</small>
                            </div>
                        </div>
                                <br />
                                <label for="enabled" class="col-form-label">Enabled</label>
                                <div class="form-check form-check-inline">
                                <!-- enabled (0 or 1) UNSIGNED  'Set greater than 0 if this composition can be played' -->
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
            var catalog_number = $(this).attr("id");
            $.ajax({
                url:"fetch_compositions.php",
                method:"POST",
                data:{catalog_number:catalog_number},
                dataType:"json",
                success:function(data){
                    $('#catalog_number').val(data.catalog_number);
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
            var catalog_number = $(this).attr("id");
            $.ajax({
                url:"delete_records.php",
                method:"POST",
                data:{
                    table_name: "compositions",
                    table_key_name: "catalog_number",
                    table_key:catalog_number},
                dataType:"json",
                success:function(data){
                    $('#composition_detail').html(data);
                    $('#dataModal').modal('show');
                }
           });
        });
        $('#insert_form').on("submit", function(event){
            event.preventDefault();
            if($('#name').val() == "")
            {
                alert("Title is required");
            }
            else if($('#catalog_number').val() == '')
            {
                alert("Catalog number is required");
            }
            else if($('#composer').val() == '')
            {
                alert("Composer is required");
            }
            else
            {
                $.ajax({
                    url:"insert_compositions.php",
                    method:"POST",
                    data:$('#insert_form').serialize(),
                    beforeSend:function(){
                        $('#insert').val("Inserting");
                    },
                    success:function(data){
                        $('#insert_form')[0].reset();
                        $('#add_data_Modal').modal('hide');
                        $('#composition_table').html(data);
                    }
                });
            }
        });
        $(document).on('click', '.view_data', function(){
            var catalog_number = $(this).attr("id");
            if(catalog_number != '')
            {
                $.ajax({
                    url:"select_compositions.php",
                    method:"POST",
                    data:{catalog_number:catalog_number},
                    success:function(data){
                        $('#composition_detail').html(data);
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
