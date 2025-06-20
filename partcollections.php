<?php
  define('PAGE_TITLE', 'List part collections');
  define('PAGE_NAME', 'Part collections');
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
  ferror_log("RUNNING partcollections.php");
?>
<main role="main">
    <div class="container">
    <h1><?php echo ORGNAME . ' ' . PAGE_NAME ?></h1>
<?php if($u_librarian) : ?>
    <div align="right">
        <p>Add instruments to parts
        <button type="button" name="add" id="add" data-bs-toggle="modal" data-bs-target="#add_data_Modal" class="btn btn-warning">Add</button>
        </p>
    </div><!-- right -->
<?php endif; ?>
        <?php
        if(!empty($_POST)) {
            echo '<h4>You selected</h4>';
            echo '<table>';
            // loop over checked checkboxes
            foreach($_POST as $key => $value) {
                echo '<tr><td>'. $key . '</td>';
                echo "    <td>". $value . "</td></tr>";
            }
            if(!empty($_POST['parttypes'])){
                echo "<p>Part types selected:</p>";
                echo "<ol>";
                foreach($_POST['parttypes'] as $selected) {
                    echo "<li>" . $selected . "</li>";
                }
                echo "</ol>";
            }
            echo '</table>';
         }?>
        <div id="part_collection_table">
        <?php
        echo '        <div class="panel panel-default">
        <div class="table-repsonsive">
            <table class="table table-hover">
                <caption class="title">Available part type collections</caption>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Part name</th>
                    <th>Instrument</th>
                    <th>Collection</br>name</th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>';
        $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        //        --- Part collections information
        $sql = "SELECT k.catalog_number_key catalog_number,
                   c.name composition_title,
                   k.id_part_type_key part_type_key,
                   y.name part_type_name,
                   k.id_instrument_key instrument_key,
                   COUNT(k.id_instrument_key) instrument_count,
                   i.name instrument_name,
                   k.name collection_name,
                   k.description description
        FROM       part_collections k
        LEFT JOIN  compositions c ON c.catalog_number = k.catalog_number_key
        LEFT JOIN  part_types y ON y.id_part_type = k.id_part_type_key
        LEFT JOIN  instruments i ON i.id_instrument = k.id_instrument_key
        GROUP BY   k.catalog_number_key, k.id_part_type_key, k.id_instrument_key 
        ORDER BY   composition_title, y.collation, i.collation;";
        $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
        ferror_log("Running SQL: ". $sql);
        while ($rowList = mysqli_fetch_array($res)) {
            $catalog_number = $rowList['catalog_number'];
            $composition_title = $rowList['composition_title'];
            $part_type_key = $rowList['part_type_key'];
            $part_type_name = $rowList['part_type_name'];
            $collection_name = $rowList['collection_name'];
            $instrument_key = $rowList['instrument_key'];
            $instrument_name = $rowList['instrument_name'];
            if ($rowList['instrument_count'] > 1) {
                $instrument_name = $rowList['instrument_count'] . ' * ' . $instrument_name;
            }
            $description = $rowList['description'];
            echo '<tr>
                    <td>'.$catalog_number.'</td>
                    <td>'.$composition_title.'</td>
                    <td>'.$part_type_name.'</td>
                    <td>'.$instrument_name.'</td>
                    <td>'.$collection_name .'</td>
                    <td>'.$description.'</td>';
            if ($u_librarian) { echo '
                        <td><input type="button" name="delete" value="Delete" id="'.$catalog_number.':'.$part_type_key.':'.$instrument_key.'" class="btn btn-danger btn-sm delete_data" /></td>
                        <td><input type="button" name="edit" value="Edit" id="'.$catalog_number.':'.$part_type_key.':'.$instrument_key.'" class="btn btn-primary btn-sm edit_data" /></td>'; }
            echo '
                        <td><input type="button" name="view" value="View" id="'.$catalog_number.':'.$part_type_key.':'.$instrument_key.'" class="btn btn-secondary btn-sm view_data" /></td>
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
        // ferror_log("returned: " . $sql);
        ?>
        </div><!-- part_collection_table -->
        <div id="dataModal" class="modal"><!-- view data -->
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Part type collection details</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div><!-- modal-header -->
                    <div class="modal-body" id="part_collection_detail">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div><!-- modal-footer -->
                </div><!-- modal-content -->
            </div><!-- modal-dialog -->
        </div><!-- dataModal view data -->
        <div id="deleteModal" class="modal" tabindex="-1" role="dialog"><!-- delete data -->
            <div class="modal-dialog" role="document">
                <div class="modal-content rounded-4 shadow">
                    <div class="modal-body p-4 text-center">
                        <h5 class="mb-0">Delete this part collection?</h5>
                        <p id="part_collection2delete">You can cancel now.</p>
                    </div>
                    <div class="modal-footer flex-nowrap p-0">
                        <button type="button" class="btn btn-lg btn-link text-decoration-none rounded-0 border-right" id="confirm-delete" data-bs-dismiss="modal"><strong>Yes, delete</strong></button>
                        <button type="button" class="btn btn-lg btn-link text-decoration-none rounded-0" data-bs-dismiss="modal">No thanks</button>
                    </div><!-- modal-footer -->
                </div><!-- modal-content -->
            </div><!-- modal-dialog -->
        </div><!-- deleteModal -->
        <div id="add_data_Modal" class="modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Part type collection information</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div><!-- modal-header -->
                    <div class="modal-body">
                        <form action="includes/insert_partcollections.php" method="post" id="insert_form">
                            <input type="hidden" name="is_part_collection" id="is_part_collection" value="0" />
                            <div class="row bg-white">
                                <div class="col-md-3">
                                    <label for="name" class="col-form-label">Part type collection unique name</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Percussion 44"/>
                                </div>
                            </div>
                            <div class="row bg-light">
                                <div class="col-md-12">
                                    <label for="description" class="col-form-label">Description</label><br />
                                    <textarea class="form-control" id="description" name="description" rows="2"></textarea>
                                </div>
                            </div>
                            <div class="row bg-white">
                                <div class="col-md-3">
                                    <label for="id_part" class="col-form-label">Part (from parts table)*</label>
                                </div>
                                <div class="col-md-9">
                                    <!-- Read compositions, parts, part types from each table -->
                                    <?php
                                    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                                    $sql = "SELECT  p.catalog_number,
                                                    c.name title,
                                                    p.id_part_type,
                                                    y.name part_type
                                            FROM    parts p
                                            JOIN    compositions c
                                            ON      p.catalog_number = c.catalog_number
                                            JOIN    part_types y
                                            ON      y.id_part_type = p.id_part_type
                                            ORDER BY catalog_number, y.collation;";
                                    ferror_log("Running " . $sql);
                                    $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
                                    $opt = "<select class='form-select form-control' aria-label='Select parts' id='id_part' name='id_part'>\n";
                                    while ($rowList = mysqli_fetch_array($res)) {
                                        $catalog_number_key = $rowList['catalog_number'];
                                        $title = $rowList['title'];
                                        $id_part_type = $rowList['id_part_type'];
                                        $part_type = $rowList['part_type'];
                                        $opt .= "                                   <option value='" . $catalog_number_key . ":". $id_part_type . "'>" . $catalog_number_key .': '. $title . " - " . $part_type . "</option>\n";
                                    }
                                    $opt .= "                           </select>\n";
                                    mysqli_close($f_link);
                                    echo $opt;
                                    //error_log("returned: " . $sql);
                                    ?>
                                </div>
                            </div>
                            <div class="row bg-light">
                                <div class="col-md-3">
                                    <label for="link" class="col-form-label">Instruments that are in this collection*</label>
                                </div>
                                <div class="col-md-9">
                                    <!-- Get all the instruments from instruments table -->
                                    <?php
                                    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                                    $sql = "SELECT id_instrument, name FROM instruments WHERE enabled = 1 ORDER BY collation;";
                                    //error_log("Running " . $sql);
                                    $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
                                    $opt = "<select class='form-select form-control' aria-label='Select part type' id='id_instrument_key' name='id_instrument_key[]' size='17' multiple>";
                                    while ($rowList = mysqli_fetch_array($res)) {
                                        $id_instrument = $rowList['id_instrument'];
                                        $instrument = $rowList['name'];
                                        $opt .= "                                   <option value='" . $id_instrument . "'>" . $instrument . "</option>\n";
                                    }
                                    $opt .= "                          </select>\n";
                                    mysqli_close($f_link);
                                    echo $opt;
                                    //error_log("returned: " . $sql);
                                    ?>
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
        </div><!-- add_data_modal -->
        <div id="edit_data_Modal" class="modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit part type collection</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div><!-- modal-header -->
                    <div class="modal-body">
                        <form method="post" id="edit_form">
                            <input type="hidden" name="catalog_number_key_hold2" id="catalog_number_key_hold2" value="0" />
                            <input type="hidden" name="id_part_type_key_hold2" id="id_part_type_key_hold2" value="0" />
                            <input type="hidden" name="id_instrument_key_hold2" id="id_instrument_key_hold2" value="0" />
                            <div class="row bg-white">
                                <div class="col-md-3">
                                    <label for="name2" class="col-form-label">Part type collection name</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" id="name2" name="name2" placeholder="Percussion 44"/>
                                </div>
                            </div>
                            <div class="row bg-light">
                                <div class="col-md-12">
                                    <label for="description2" class="col-form-label">Description</label><br />
                                    <textarea class="form-control" id="description2" name="description2" rows="2"></textarea>
                                </div>
                            </div>
                            <div class="row bg-white">
                                <div class="col-md-3">
                                    <label for="catalog_number_key2" class="col-form-label">Catalog number*</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="catalog_number_key2" name="catalog_number_key2" placeholder="C123" required/>
                                </div>
                            </div>
                            <div class="row bg-light">
                                <div class="col-md-3">
                                    <label for="id_part_type_key2" class="col-form-label">Part type of the collection</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="id_part_type_key2" name="id_part_type_key2" placeholder="1" required/>
                                </div>
                            </div>
                            <div class="row bg-white">
                                <div class="col-md-3">
                                    <label for="id_instrument_key2" class="col-form-label">This instrument in the collection</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="id_instrument_key2" name="id_instrument_key2" placeholder="1" required/>
                                </div>
                            </div>
                        </div><!-- modal-body -->
                    <div class="modal-footer">  
                            <input type="hidden" name="update2" id="update2" value="0" />
                            <input type="submit" name="insert2" id="insert2" value="Update" class="btn btn-success" />
                        </form>  
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>  
                    </div><!-- modal-footer -->
                </div><!-- modal-content -->
            </div><!-- modal-dialog -->
        </div><!-- edit_data_modal -->
    </div><!-- container -->
</main>
<?php require_once("includes/footer.php");?>
<!-- jquery function to add/update database records -->
<script>
// Load instruments data into a JSON array for frequent use
<?php
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$sql = "SELECT `id_instrument`, `name` FROM instruments WHERE `enabled` = 1 ORDER BY collation;";
ferror_log("Running " . $sql);
$res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
$jsondata = "var instrumentdata = {";
while($rowList = mysqli_fetch_array($res)) {
    $id_instrument = $rowList['id_instrument'];
    $instrument_name = $rowList['name'];
    $jsondata .= '"'.$id_instrument.'": "'.$instrument_name.'",';
}
$jsondata = rtrim($jsondata, ',');
$jsondata .= '}'.PHP_EOL;
mysqli_close($f_link);
echo $jsondata;
ferror_log("returned: " . $sql);
?>
$(document).ready(function(){
    $('#add').click(function(){
        $('#insert').val("Insert");
        $('#update').val("add");
        $('#insert_form')[0].reset();
    });
    $(document).on('click', '.edit_data', function(){
        var part_collection_id = $(this).attr('id');
        var catalog_number_key = part_collection_id.split(':')[0];
        var id_part_type_key = part_collection_id.split(':')[1];
        var id_instrument_key = part_collection_id.split(':')[2];
        $.ajax({
            url:"includes/fetch_partcollections.php",
            method:"POST",
            data:{
                catalog_number_key: catalog_number_key,
                id_part_type_key: id_part_type_key,
                id_instrument_key: id_instrument_key
            },
            dataType:"json",
            success:function(data){
                $('#catalog_number_key2').val(data.catalog_number_key);
                $('#catalog_number_key_hold2').val(data.catalog_number_key);
                $('#id_part_type_key2').val(data.id_part_type_key);
                $('#id_part_type_key_hold2').val(data.id_part_type_key);
                $('#id_instrument_key2').val(data.id_instrument_key);
                $('#id_instrument_key_hold2').val(data.id_instrument_key);
                $('#name2').val(data.name);
                $('#description2').val(data.description);
                $('#insert2').val("Update");
                $('#update2').val("update");
                $('#edit_data_Modal').modal('show');
            }
        });
    });
    $(document).on('click', '.delete_data', function(){ // button that brings up modal
        var is_part_collection = $(this).attr("id");
        $('#deleteModal').modal('show');
        $('#confirm-delete').data('id', is_part_collection);
        $('#part_collection2delete').text(is_part_collection);
    });
    $('#confirm-delete').click(function(){
        // The confirm delete button
        var part_collection_id = $(this).data('id');
        var catalog_number_key = part_collection_id.split(':')[0];
        var id_part_type_key = part_collection_id.split(':')[1];
        var id_instrument_key = part_collection_id.split(':')[2];
        $.ajax({
            url:"includes/delete_partcollections.php",
            method:"POST",
            data:{
                catalog_number_key: catalog_number_key,
                id_part_type_key: id_part_type_key,
                id_instrument_key: id_instrument_key
            },
            success:function(data){
                $('#insert_form')[0].reset();
                $('#part_collection_table').html(data);
            }
        });
    });
    $('#edit_form').on("submit", function(event){
        event.preventDefault();
        var catalog_number_key =  $('#catalog_number_key2').val();
        var catalog_number_key_hold =  $('#catalog_number_key_hold2').val();
        
        var id_part_type_key = $('#id_part_type_key2').val();
        var id_part_type_key_hold = $('#id_part_type_key_hold2').val();

        var id_instrument_key = $('#id_instrument_key2').val();
        var id_instrument_key_hold = $('#id_instrument_key_hold2').val();

        var name = $('#name2').val();
        var description = $('#description2').val();
        var update = $('#update2').val();
        var insert = $('#insert2').val();
        $.ajax({
            url:"includes/insert_partcollections.php",
            method:"POST",
            data:{
                catalog_number_key: catalog_number_key,
                id_part_type_key: id_part_type_key,
                id_instrument_key: id_instrument_key,
                catalog_number_key_hold: catalog_number_key_hold,
                id_part_type_key_hold: id_part_type_key_hold,
                id_instrument_key_hold: id_instrument_key_hold,
                name: name,
                description: description,
                update: update
            },
            beforeSend:function(){
                $('#insert2').val("Updating");
            },
            success:function(data){
                $('#edit_form')[0].reset();
                $('#part_collection_table').html(data);
                $('#edit_data_Modal').modal('hide');
            }
        });
    });
    $('#insert_form').on("submit", function(event){
        event.preventDefault();
        var id_partcollection = $('#id_part').val();
        var catalog_number_key = id_partcollection.split(':')[0];
        var id_part_type_key = id_partcollection.split(':')[1];
        // id_part_type is multiple select - returns object
        var id_instrument_key = $('#id_instrument_key').val();
        var name = $('#name').val();
        var description = $('#description').val();
        var update = $('#update').val();
        $.ajax({
            url:"includes/insert_partcollections.php",
            method:"POST",
            data:{
                catalog_number_key: catalog_number_key,
                id_part_type_key: id_part_type_key,
                id_instrument_key: id_instrument_key,
                name: name,
                description: description,
                update: update
            },
            beforeSend:function(){
                $('#insert').val("Inserting");
            },
            success:function(data){
                $('#insert_form')[0].reset();
                $('#add_data_Modal').modal('hide');
                $('#part_collection_table').html(data);
            }
        });
    });
    $(document).on('click', '.view_data', function(){
        var part_collection_id = $(this).attr('id');
        var catalog_number_key = part_collection_id.split(':')[0];
        var id_part_type_key = part_collection_id.split(':')[1];
        var id_instrument_key = part_collection_id.split(':')[2];
        $.ajax({
            url:"includes/select_partcollections.php",
            method:"POST",
            data:{
                catalog_number_key: catalog_number_key,
                id_part_type_key: id_part_type_key,
                id_instrument_key: id_instrument_key
            },
            success:function(data){
                $('#part_collection_detail').html(data);
                $('#dataModal').modal('show');
            }
        });
    });
});
</script>
</body>
</html>
