<?php
  define('PAGE_TITLE', 'List ensembles');
  define('PAGE_NAME', 'Ensembles');
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
?>
    <br />
    <div class="container">
        <img class="d-block mx-auto mb-4" src="images/main-logo.png" alt="" width="132" height="20">
        <h2 align="center">ACWE Ensembles</h2>
<?php if($u_admin) : ?>
        <div align="right">
            <button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-warning">Add</button>
            <br />
        </div><!-- right -->
<?php endif; ?>
        <div id="ensemble_table">
        <div id="accordion">
                <?php
                require_once('includes/config.php');
                require_once('includes/functions.php');
                $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                $sql = "SELECT * FROM ensembles ORDER BY name;";
                $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
                $oldPortfolio = "xyzzy";
                while ($rowList = mysqli_fetch_array($res)) {
                    $rowID = $rowList['id_ensemble'];
                    $title = $rowList['name'];
                    $description = $rowList['description'];
                    $f_link = $rowList['link'];
                    $enabled = $rowList['enabled'];

                    if ( $portfolio != $oldPortfolio ) {
                        if ( $oldPortfolio != "xyzzy" ) {
                            echo '
                                </tbody>
                           </table>
                           </div><!-- table-responsive -->
                        </div><!-- section'.$oldPortfolio.' -->
                    </div><!-- class panel -->';
                        } // End the table, and not the very first one
                        echo '
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="header'. $portfolio .'">
                            <h4 class="panel-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#section'.$portfolio.'" aria-expanded="true" aria-controls="section'.$portfolio.'">'.$portfolio.'</a>
                            </h4>
                        </div><!-- div panel-heading -->
                        <div id="section'.$portfolio.'" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="header'.$portfolio.'">
                            <div class="table-repsonsive">
                            <table class="table table-hover">
                                <caption class="title">Available '.$portfolio .' ensembles</caption>
                                <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Title</th>
                                    <th>Delivery method</th>
                                    <th>Platform(s)</th>
                                    <th>Completed</th>
                                </tr>
                                </thead>
                                <tbody>';
                                $oldPortfolio = $portfolio;
                    }
                    echo '<tr>
                                    <td>'.$ensemble_code.'</td>
                                    <td>'.$title.'</td>
                                    <td>'.$delivery_method.'</td>
                                    <td>'.$platform.'</td>
                                    <td>' . date('F d, Y', strtotime($ensemble_completed)) . '</td>';
                        if ($u_admin) { echo '
                                    <td><input type="button" name="edit" value="Edit" id="'.$rowID.'" class="btn btn-primary btn-sm edit_data" /></td>'; }
                    echo '
                                    <td><input type="button" name="view" value="View" id="'.$rowID.'" class="btn btn-secondary btn-sm view_data" /></td>
                                </tr>
                                ';
                }
                echo '
                                </tbody>
                           </table>
                           </div><!-- table-responsive -->
                        </div><!-- section'.$oldPortfolio.' -->
                    </div><!-- class panel -->
                ';
                mysqli_close($f_link);
                // error_log("returned: " . $sql);
                ?>
            </div><!-- accordion -->
            </div><!-- ensemble_table -->
    </div><!-- container -->

    <div id="dataModal" class="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">ensemble Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div><!-- modal-header -->
                <div class="modal-body" id="ensemble_detail">
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
                    <h4 class="modal-title">ensemble information</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div><!-- modal-header -->
                <div class="modal-body">
                  <div class="container-fluid">
                    <form method="post" id="insert_form">
                        <div class="row bg-light">
                            <div class="col-md-2">
                                <label for="ensemble_code" class="col-form-label">ensemble code*</label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="ensemble_code" name="ensemble_code" placeholder="PP99E" required/>
                            </div>
                            <div class="col-md-2">
                                <label for="title" class="col-form-label">ensemble title*</label>
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control" id="title" name="title" placeholder="HCL PnP Product V9.99 Essentials" required/>
                            </div>
                        </div><hr />
                        <div class="row bg-light">
                            <div class="col-md-2">
                                <label class="col-form-label">Portfolio*</label>
                            </div>
                            <div class="col-md-10">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="product_categories" id="product_categories1" value="Automation" checked>
                                    <label class="form-check-label" for="product_categories1">Automation</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="product_categories" id="product_categories2" value="Data">
                                    <label class="form-check-label" for="product_categories2">Data</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="product_categories" id="product_categories3" value="DevOps">
                                    <label class="form-check-label" for="product_categories3">DevOps</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="product_categories" id="product_categories4" value="SecureDevOps">
                                    <label class="form-check-label" for="product_categories4">Secure DevOps</label>
                                </div>
                            </div>
                        </div><hr />                  
                        <div class="row">
                            <div class="col-md-2">
                                <label for="ensemble_type" class="col-form-label">ensemble type</label>
                            </div>
                            <div class="col-md-10">
                                <table><tr><td width="25%">Commercial:</td><td>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" class="form-check-input" id="ensemble_type1" name="ensemble_type[]" value="Commercial self-paced">
                                        <label for="ensemble_type1" class="form-check-label">self-paced</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" class="form-check-input" id="ensemble_type2" name="ensemble_type[]" value="Commerical standalone lab">
                                        <label for="ensemble_type2" class="form-check-label">standalone lab</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" class="form-check-input" id="ensemble_type3" name="ensemble_type[]" value="Commercial classroom" checked>
                                        <label for="ensemble_type3" class="form-check-label">classroom</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" class="form-check-input" id="ensemble_type4" name="ensemble_type[]" value="Commerical workshop">
                                        <label for="ensemble_type4" class="form-check-label">workshop</label>
                                    </div>
                                    </td></tr><tr><td width="25%">Internal:</td><td>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" class="form-check-input" id="ensemble_type5" name="ensemble_type[]" value="Internal self-paced">
                                        <label for="ensemble_type5" class="form-check-label">self-paced</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" class="form-check-input" id="ensemble_type6" name="ensemble_type[]" value="Internal standalone lab">
                                        <label for="ensemble_type6" class="form-check-label">standalone lab</label>
                                    </div>
                                    <div class="form-chec form-check-inline">
                                        <input type="checkbox" class="form-check-input" id="ensemble_type7" name="ensemble_type[]" value="Internal classroom">
                                        <label for="ensemble_type7" class="form-check-label">classroom</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" class="form-check-input" id="ensemble_type8" name="ensemble_type[]" value="Internal workshop">
                                        <label for="ensemble_type8" class="form-check-label">workshop</label>
                                    </div>
                                    </td></tr></table>
                                    <p class="text-info"><small>Check all that apply.</small></p>
                                </div>
                            </div><!-- row -->
                        <div class="row bg-light">
                            <div class="col-md-2">
                                <label class="col-form-label">Delivery method*</label>
                            </div>
                            <div class="col-md-10">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="delivery_method" id="delivery_method2" value="Instructor-led" checked>
                                    <label class="form-check-label" for="delivery_method1">Instructor-led</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="delivery_method" id="delivery_method2" value="Instructor-led online">
                                    <label class="form-check-label" for="delivery_method2">Instructor-led online</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="delivery_method" id="delivery_method3" value="Self-paced">
                                    <label class="form-check-label" for="delivery_method3">Self-paced</label>
                                </div>
                            </div>
                        </div>
                        <div class="row bg-white">
                            <div class="col-md-12">
                                <label for="description" class="col-form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                <br />
                                <label for="audience" class="col-form-label">Intended audience</label>
                                <textarea class="form-control" id="audience" name="audience" rows="3"></textarea>
                                <br />
                                <label for="objectives" class="col-form-label">Class objectives (what you learn)</label>
                                <textarea class="form-control" id="objectives" name="objectives" rows="3"></textarea>
                                <br />
                                <label for="outline" class="col-form-label">ensemble outline</label>
                                <textarea class="form-control" id="outline" name="outline" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row bg-light">
                            <div class="col-md-2">
                                <label for="commercial_url" class="col-form-label">URL</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="commercial_url" name="commercial_url" placeholder="https://www.hcltech.com/products-and-platforms" /><p class="text-info"><small>Address of the web page describing the ensemble</small></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Dates</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="ensemble_created" class="col-form-label">Created (started)</label>
                                <input type="date" class="form-control" id="ensemble_created" name="ensemble_created" placeholder="2018-01-01" />
                            </div>
                            <div class="col-md-3">
                                <label for="ensemble_completed" class="col-form-label">Completed (finished)</label>
                                <input type="date" class="form-control" id="ensemble_completed" name="ensemble_completed" placeholder="2018-04-01" />
                            </div>
                            <div class="col-md-3">
                                <label for="ensemble_updated" class="col-form-label">Updated</label>
                                <input type="date" class="form-control" id="ensemble_updated" name="ensemble_updated" placeholder="2018-04-01" />
                            </div>
                            <div class="col-md-3">
                                <label for="ensemble_planned" class="col-form-label">Planned</label>
                                <input type="date" class="form-control" id="ensemble_planned" name="ensemble_planned" placeholder="2019-01-01" />
                            </div>
                        </div>
                        <div class="row bg-light">
                            <div class="col-md-2">
                                <label for="developer_name" class="col-form-label">Developer</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="developer_name" name="developer_name" placeholder="Raj Koothrappali" />
                                <p class="text-info"><small>ensembleware developer's name (First, Last)</small></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label for="developer_address" class="col-form-label">e-mail</label>
                            </div>
                            <div class="col-md-10">
                                <input type="email" class="form-control" id="developer_address" name="developer_address" placeholder="Raj.Koothrappali@hcl.in" />
                                <p class="text-info"><small>ensembleware developer's email address</small></p>
                            </div>
                        </div>
                        <div class="row bg-light">
                            <div class="col-md-2">
                                <label for="owner_name" class="col-form-label">Owner</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="owner_name" name="owner_name" placeholder="Raj Koothrappali" />
                                <p class="text-info"><small>ensemble owner's name (First, Last)</small></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label for="developer_address" class="col-form-label">e-mail</label>
                            </div>
                            <div class="col-md-10">
                                <input type="email" class="form-control" id="owner_address" name="owner_address" placeholder="Raj.Koothrappali@hcl.in" />
                                <p class="text-info"><small>ensembleware owner's email address</small></p>
                            </div>
                        </div>
                        <div class="row bg-light">
                            <div class="col-md-2">
                                <label class="col-form-label">Delivery platform</label>
                            </div>
                            <div class="col-md-10">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="platforms" id="platform1" value="Windows" checked>
                                    <label class="form-check-label" for="platform1">Windows</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="platforms" id="platform2" value="Linux">
                                    <label class="form-check-label" for="platform2">Linux</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="platforms" id="platform3" value="Other">
                                    <label class="form-check-label" for="platform3">Other</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="prerequisites" class="col-form-label">Prerequisites for the class</label>
                                <textarea class="form-control" id="prerequisites" name="prerequisites" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="product_names" class="col-form-label">Products covered by this class</label>
                                <textarea class="form-control" id="product_names" name="product_names" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row bg-light">
                            <div class="col-md-4">
                                <label for="ensemble_duration" class="col-form-label">Length of the class in days</label>
                                <input type="text" class="form-control" id="ensemble_duration" name="ensemble_duration" placeholder="1" />
                            </div>
                            <div class="col-md-4">
                                <label for="machine_image_ids" class="col-form-label">AWS image ID</label>
                                <input type="text" class="form-control" id="machine_image_ids" name="machine_image_ids" placeholder="ami-c88af8b2" />
                            </div>
                            <div class="col-md-4">
                                <label for="tags" class="col-form-label">Tags</label>
                                <input type="text" class="form-control" id="tags" name="tags" placeholder="1" />
                            </div>
                        </div>
                        <input type="hidden" name="ensemble_id" id="ensemble_id" />
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
            $('#insert_form')[0].reset();
        });
        $(document).on('click', '.edit_data', function(){
            var ensemble_id = $(this).attr("id");
            $.ajax({
                url:"fetch_ensembles.php",
                method:"POST",
                data:{ensemble_id:ensemble_id},
                dataType:"json",
                success:function(data){
                    $('#timestamp').val(data.timestamp);
                    $('#title').val(data.title);
                    $('#audience').val(data.audience);
                    $('#objectives').val(data.objectives);
                    $('#outline').val(data.outline);
                    $('#ip').val(data.ip);
                    $('#ensemble_code').val(data.ensemble_code);
                    $('#ensemble_type').val(data.ensemble_type);
                    $('#delivery_method').val(data.delivery_method);
                    $('#description').val(data.description);
                    $('#commercial_url').val(data.commercial_url);
                    $('#ensemble_created').val(data.ensemble_created);
                    $('#ensemble_completed').val(data.ensemble_completed);
                    $('#ensemble_updated').val(data.ensemble_updated);
                    $('#ensemble_planned').val(data.ensemble_planned);
                    $('#developer_name').val(data.developer_name);
                    $('#developer_address').val(data.developer_address);
                    $('#owner_name').val(data.owner_name);
                    $('#owner_address').val(data.owner_address);
                    $('#platforms').val(data.platforms);
                    $('#prerequisites').val(data.prerequisites);
                    $('#product_categories').val(data.product_categories);
                    $('#product_names').val(data.product_names);
                    $('#ensemble_duration').val(data.ensemble_duration);
                    $('#machine_image_ids').val(data.machine_image_ids);
                    $('#tags').val(data.tags);
                    $('#ensemble_id').val(data.id);
                    $('#insert').val("Update");
                    $('#add_data_Modal').modal('show');
                }
           });
        });
        $('#insert_form').on("submit", function(event){
            event.preventDefault();
            if($('#title').val() == "")
            {
                alert("Title is required");
            }
            else if($('#ensemble_code').val() == '')
            {
                alert("ensemble Code is required");
            }
            else
            {
                $.ajax({
                    url:"insert_ensembles.php",
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
            var ensemble_id = $(this).attr("id");
            if(ensemble_id != '')
            {
                $.ajax({
                    url:"select_ensembles.php",
                    method:"POST",
                    data:{ensemble_id:ensemble_id},
                    success:function(data){
                        $('#ensemble_detail').html(data);
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
