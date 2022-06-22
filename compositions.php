<?php
define('PAGE_TITLE', 'List compositions');
define('PAGE_NAME', 'Compositions');
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
?>
<main role="main" class="container">
<div class="container">
        <h2 align="center"><?php echo ORGNAME ?> Compositions</h2>
<?php if($u_librarian) : ?>
        <div align="right">
            <button type="button" name="add" id="add" data-bs-toggle="modal" data-bs-target="#add_data_Modal" class="btn btn-warning">Add</button>
            <br />
        </div><!-- right -->
<?php endif; ?>
        <div id="search_form">
            <form action="" method="POST">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <button type="submit" name="submitButton" class="btn btn-secondary">Search</button>
                    </div>
                    <div class="col-auto">
                        <input type="text" id="search" name="search" class="form-control" aria-describedby="searchHelp">
                    </div>
                    <div class="col-auto">
                       <span id="searchHelp" class="form-text">
                           Search the name, description, composer, arranger, and comments
                       </span>
                    </div>
                </div>
            </form>
        </div>
        <div id="composition_table">
        <?php
        echo '
            <div class="panel panel-default">
                <div class="table-repsonsive">
                    <table class="table table-hover tablesort" id="cpdatatable">
                    <caption class="title">Available compositions</caption>
                    <thead>
                    <tr>
                        <th data-tablesort-type="string">Catalog number <i class="fa fa-sort" aria-hidden="true"></i></th>
                        <th data-tablesort-type="string">Name <i class="fa fa-sort" aria-hidden="true"></i></th>
                        <th data-tablesort-type="string">Composer <i class="fa fa-sort" aria-hidden="true"></i></th>
                        <th data-tablesort-type="string">Arranger <i class="fa fa-sort" aria-hidden="true"></i></th>
                        <th data-tablesort-type="string">Description <i class="fa fa-sort" aria-hidden="true"></i></th>
                        <th data-tablesort-type="string">Comments <i class="fa fa-sort" aria-hidden="true"></i></th>
                        <th data-tablesort-type="string">Grade <i class="fa fa-sort" aria-hidden="true"></i></th>
                        <th data-tablesort-type="string">Genre <i class="fa fa-sort" aria-hidden="true"></i></th>
                        <th data-tablesort-type="string">Parts <i class="fa fa-sort" aria-hidden="true"></i></th>
                        <th data-tablesort-type="string">Ensemble <i class="fa fa-sort" aria-hidden="true"></i></th>
                        <th data-tablesort-type="string">Enabled <i class="fa fa-sort" aria-hidden="true"></i></th>
                    </tr>
                    </thead>
                    <tbody>';
        $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (isset($_POST["submitButton"])) {
            ferror_log("POST search=".$_POST["search"]);
            $search = mysqli_real_escape_string($f_link, $_POST['search']);
            $sql = "SELECT c.catalog_number,
                           c.name,
                           c.description,
                           c.comments,
                           c.composer,
                           c.arranger,
                           c.grade,
                           g.name genre,
                           COUNT(p.id_part_type) as parts,
                           e.name ensemble,
                           c.enabled
                    FROM   compositions c
                    JOIN   genres g      
                    ON     c.genre = g.id_genre
                    JOIN   ensembles e   
                    ON     c.ensemble = e.id_ensemble
                    LEFT OUTER JOIN parts p 
                    ON  c.catalog_number = p.catalog_number
                    WHERE  MATCH(c.name, c.description, c.composer, c.arranger, c.comments)
                    AGAINST( '".$search."' IN NATURAL LANGUAGE MODE)
                    GROUP BY c.catalog_number
                    ORDER BY c.catalog_number;";
        } else {
            $sql = "SELECT c.catalog_number,
                           c.name,
                           c.description,
                           c.comments,
                           c.composer,
                           c.arranger,
                           g.name genre,
                           COUNT(p.id_part_type) as parts,
                           e.name ensemble,
                           c.grade,
                           c.enabled
                    FROM   compositions c
                    JOIN   genres g
                    ON     c.genre = g.id_genre
                    JOIN   ensembles e
                    ON     c.ensemble = e.id_ensemble
                    LEFT OUTER JOIN parts p
                    ON     c.catalog_number = p.catalog_number
                    GROUP  BY c.catalog_number
                    ORDER BY c.last_update DESC;";
        }

        $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
        while ($rowList = mysqli_fetch_array($res)) {
            $catalog_number = $rowList['catalog_number'];
            $name = $rowList['name'];
            $description = $rowList['description'];
            $comments = $rowList['comments'];
            $composer = $rowList['composer'];
            $arranger = $rowList['arranger'];
            $genre = $rowList['genre'];
            $grade = $rowList['grade'];
            $partscount = $rowList['parts'];
            $ensemble = $rowList['ensemble'];
            $enabled = $rowList['enabled'];
            echo '<tr>
                        <td>'.$catalog_number.'</td>
                        <td>'.$name.'</td>
                        <td>'.$composer.'</td>
                        <td>'.$arranger.'</td>
                        <td>'.$description.'</td>
                        <td>'.$comments.'</td>
                        <td>'.$grade.'</td>
                        <td>'.$genre.'</td>
                        <td>'.$partscount.'</td>
                        <td>'.$ensemble.'</td>
                        <td><div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="typeEnabled" disabled '. (($enabled == 1) ? "checked" : "") .'>
                        </div></td>';
            if ($u_librarian) { echo '
                        <td><form method="post" id="instr_data_'.$catalog_number.'" action="composition_instrumentation.php"><input type="hidden" name="catalog_number" value="'.$catalog_number.'" />
                        <input type="submit" name="compositions" value="Instrumentation" id="'.$catalog_number.'" class="btn btn-warning btn-sm instr_data" /></form></td>
                        <td><input type="button" name="delete" value="Delete" id="'.$catalog_number.'" class="btn btn-danger btn-sm delete_data" /></td>
                        <td><input type="button" name="edit" value="Edit" id="'.$catalog_number.'" class="btn btn-primary btn-sm edit_data" /></td>';
                        }
            echo '
                        <td><input type="button" name="view" value="View" id="'.$catalog_number.'" class="btn btn-secondary btn-sm view_data" /></td>                        
                        <td><input type="button" name="parts_data" value="View instrumentation" id="'.$catalog_number.'" class="btn btn-secondary btn-sm parts_data" /></td>                        
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
    </div><!-- container -->

    <div class="modal" id="view_data_modal"><!-- view data -->
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Composition details</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div><!-- modal-header -->
                <div class="modal-body" id="composition_detail">
                    <!-- filled in by select_compositions.php -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal">Parts</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div><!-- modal-footer -->
            </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- view_data_modal -->
    <div class="modal" id="parts_data_modal"><!-- view parts instrumentation -->
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content" id="instrumentation_detail">
                <!-- filled in by select_composition_parts.php -->
            </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- parts_data_modal -->
    <div id="deleteModal" class="modal" tabindex="-1" role="dialog"><!-- delete data -->
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-body p-4 text-center">
                    <h5 class="mb-0">Delete this composition?</h5>
                    <p id="composition2delete">You can cancel now.</p>
                </div>
                <div class="modal-footer flex-nowrap p-0">
                    <button type="button" class="btn btn-lg btn-link text-decoration-none rounded-0 border-right" id="confirm-delete" data-bs-dismiss="modal"><strong>Yes, delete</strong></button>
                    <button type="button" class="btn btn-lg btn-link text-decoration-none rounded-0" data-bs-dismiss="modal">No thanks</button>
                </div><!-- modal-footer -->
            </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- deleteModal -->
    <div class="modal" id="add_data_Modal"><!-- add_data_Modal -->
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Compositions information</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div><!-- modal-header -->
                <div class="modal-body">
                  <div class="container-fluid">
                    <form class="gx-3 gy-2 align-items-center" method="post" id="insert_form">
                        <div class="row bg-light">
                            <div class="col-md-3">
                                <!-- catalog_number (5 characters) 'The catalog number is a letter and 3-digit number, for example M101' -->
                                <label for="catalog_number" class="col-form-label">Catalog number*</label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="catalog_number" name="catalog_number" placeholder="X" required minlength="2" maxlength="5" size="5"/>
                                <input type="hidden" id="catalog_number_hold" name="catalog_number_hold" value="" />
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                <!-- enabled (0 or 1) UNSIGNED  'Set greater than 0 if this composition can be played' -->
                                <input class="form-check-input" id="enabled" name="enabled" type="checkbox" value="1"></>
                                <label for="enabled" class="form-check-label">Enabled</label>
                            </div>
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
                            <?php
                                $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                                $sql = "SELECT `id_genre`, `name` FROM genres WHERE `enabled` = 1 ORDER BY name;";
                                //error_log("Running " . $sql);
                                $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
                                $opt = "<select class='form-select form-control' aria-label='Select paper size' id='genre' name='genre'>";
                                while($rowList = mysqli_fetch_array($res)) {
                                    $id_genre = $rowList['id_genre'];
                                    $genre_name = $rowList['name'];
                                    $opt .= "<option value='".$id_genre."'>".$genre_name."</option>";
                                }
                                $opt .= "</select>";
                                mysqli_close($f_link);
                                echo $opt;
                                //error_log("returned: " . $sql);
                                ?> 
<!--                                <input type="text" class="form-control" id="genre" name="genre" placeholder="Z" maxlength="4"/> -->
                                <small id="genreHelp" class="form-text text-muted">This will be a selection from the Genres table</small>
                            </div>
                            <div class="col-md-2">
                                <!-- ensemble (4 characters)  'Which ensemble plays this piece ' -->
                                <label for="ensemble" class="col-form-label">Ensemble</label>
                            </div>
                            <div class="col-md-4">
                            <?php
                                $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                                $sql = "SELECT `id_ensemble`, `name` FROM ensembles WHERE `enabled` = 1 ORDER BY name;";
                                //error_log("Running " . $sql);
                                $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
                                $opt = "<select class='form-select form-control' aria-label='Select ensemble' id='ensemble' name='ensemble'>";
                                while($rowList = mysqli_fetch_array($res)) {
                                    $id_ensemble = $rowList['id_ensemble'];
                                    $ensemble_name = $rowList['name'];
                                    $opt .= "<option value='".$id_ensemble."'>".$ensemble_name."</option>";
                                }
                                $opt .= "</select>";
                                mysqli_close($f_link);
                                echo $opt;
                                ?>   
                                <small id="ensembleHelp" class="form-text text-muted">Select from the Ensembles table</small>
                            </div>
                        </div>
                        <div class="row bg-white">
                            <div class="col-md-2">
                                <!-- grade decimal(1,1) UNSIGNED  'Grade of difficulty' -->
                                <label for="grade" class="col-form-label">Grade level (0-7, 0="unknown")</label>
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="grade" class="form-control" value="0" min="0" max="7" step="0.5" id="grade"/>
                                <small id="gradeHelp" class="form-text text-muted">Level of difficulty (1-7, 0 for "unknown")</small>
                            </div>
                            <div class="col-md-2">
                                <!-- paper_size (4 characters)  'Physical size, from the paper_sizes table' -->
                                <label for="paper_size" class="col-form-label">Paper size</label>
                            </div>
                            <div class="col-md-4">
                            <?php
                                $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                                $sql = "SELECT `id_paper_size`, `name` FROM paper_sizes WHERE `enabled` = 1 ORDER BY name;";
                                //error_log("Running " . $sql);
                                $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
                                $opt = "<select class='form-select form-control' aria-label='Select paper size' id='paper_size' name='paper_size'>";
                                while($rowList = mysqli_fetch_array($res)) {
                                    $id_paper_size = $rowList['id_paper_size'];
                                    $paper_size_name = $rowList['name'];
                                    $opt .= "<option value='".$id_paper_size."'>".$paper_size_name."</option>";
                                }
                                $opt .= "</select>";
                                mysqli_close($f_link);
                                echo $opt;
                                //error_log("returned: " . $sql);
                                ?> 
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
                                <!-- duration 'Performance duration in seconds' -->
                                <label for="duration" class="col-form-label">Duration (seconds)</label>
                            </div>
                            <div class="col-sm-1">
                                <input type="number" step="1" class="form-control" id="duration_hours" name="duration_hours" min="0" max="12"/>
                                <small id="durationHourHelp" class="form-text text-muted">Hr</small>
                            </div>
                            <div class="col-sm-1">
                                <input type="number" step="1" class="form-control" id="duration_minutes" name="duration_minutes" min="0" max="59"/>:
                                <small id="durationMinHelp" class="form-text text-muted">Min</small>
                            </div>
                            <div class="col-sm-1">
                                <input type="number" step="1" class="form-control" id="duration_seconds" name="duration_seconds" min="0" max="59"/>:
                                <small id="durationSecHelp" class="form-text text-muted">Sec</small>
                            </div>
                            <div class="col-sm-1">
                                <input type="number" step="1" class="form-control" id="duration" name="duration" min="0" max="99999"/>
                                <small id="durationHelp" class="form-text text-muted">Performance duration, in seconds.</small>
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
                                <!-- performance_notes (4096 characters)  'Performance notes (how to rehearse it, for example)' -->
                                <label for="performance_notes" class="col-form-label">Performance notes</label>
                                <textarea class="form-control" id="performance_notes" name="performance_notes" rows="3" maxlength="4096"></textarea>
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
                            <!-- image_path (255 characters)  'A link to a picture of the score' -->
                            <label for="image_path" class="col-form-label">Image path</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="image_path" name="image_path" placeholder="https://acwe.org/files/scores/piece.pdf" maxlength="255"/>
                                <small id="image_pathHelp" class="form-text text-muted">Where can you find an image of the first page of the score?</small>
                            </div>
                        </div>
                        <div class="row bg-white">
                            <div class="col-md-2">
                            <!-- windrep (255 characters)  'A link to this piece on windrep.org' -->
                            <label for="windrep_link" class="col-form-label">Wind Repertory Project link</label><button id="windrep" class="btn btn-secondary btn-sm">Search</button>
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
</main>
<?php require_once("includes/footer.php"); ?>
<script src="js/auto-tables.js"></script>
<!-- jquery function to add/update database records -->
<script>
$(document).ready(function() {
    $("#gradevalue").html($("#grade").val());;
    $('#windrep').click(function() {
        var searchURL = 'https://www.windrep.org/index.php?search=' + $('#name').val();
        window.open(searchURL);
        return false;
    });
    $('#add').click(function(){
        $('#insert').val("Insert");
        $('#update').val("add");
        $('#insert_form')[0].reset();
    });
    $(document).on('click', '.edit_data', function(){
        var catalog_number = $(this).attr("id");
        $.ajax({
            url:"includes/fetch_compositions.php",
            type:"POST",
            data:{catalog_number:catalog_number},
            dataType:"json",
            success:function(data){
                $('#catalog_number').val(data.catalog_number);
                $('#catalog_number_hold').val(data.catalog_number);
                $('#name').val(data.name);
                $('#description').val(data.description);
                $('#composer').val(data.composer);
                $('#arranger').val(data.arranger);
                $('#editor').val(data.editor);
                $('#publisher').val(data.publisher);
                $('#genre').val(data.genre);
                $('#ensemble').val(data.ensemble);
                $('#grade').val(data.grade);
                $('#last_performance_date').val(data.last_performance_date);
                $('#duration').val(data.duration);

                // Set the hour, minutes, seconds fields
                var d_duration = data.duration;
                var d_hours = ~~(d_duration / 3600);
                var d_minutes = ~~((d_duration % 3600) / 60);
                var d_seconds = ~~d_duration % 60;
                $('#duration_hours').val(d_hours);
                $('#duration_minutes').val(d_minutes);
                $('#duration_seconds').val(d_seconds);

                $('#comments').val(data.comments);
                $('#performance_notes').val(data.performance_notes);
                $('#storage_location').val(data.storage_location);
                $('#date_acquired').val(data.date_acquired);
                $('#cost').val(data.cost);
                $('#listening_example_link').val(data.listening_example_link);
                $('#checked_out').val(data.checked_out);
                $('#paper_size').val(data.paper_size);
                $('#image_path').val(data.image_path);
                $('#windrep_link').val(data.windrep_link);
                $('#last_inventory_date').val(data.last_inventory_date);
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
        // input button name="delete" id="catalog_number" class="delete_data"
        var catalog_number = $(this).attr("id");
        $('#deleteModal').modal('show');
        $('#confirm-delete').data('id', catalog_number);
        $('#ensemble2delete').text(catalog_number);
    });
    $('#confirm-delete').click(function(){
        // The confirm delete button
        var catalog_number = $(this).data('id');
        $.ajax({
            url:"includes/delete_records.php",
            type:"POST",
            data:{
                table_name: "compositions",
                table_key_name: "catalog_number",
                table_key: catalog_number
            },
            success:function(data){
                $('#insert_form')[0].reset();
                $('#composition_table').html(data);
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
                url:"includes/insert_compositions.php",
                type:"POST",
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
                url:"includes/select_compositions.php",
                type:"POST",
                data:{catalog_number:catalog_number},
                success:function(data){
                    $('#composition_detail').html(data);
                    $('#view_data_modal').modal('show');
                }
            });
        }
    });
    $(document).on('click', '.parts_data', function(){
        var catalog_number = $(this).attr("id");
        if(catalog_number != '')
        {
            $.ajax({
                url:"includes/select_composition_parts.php",
                type:"POST",
                data:{catalog_number:catalog_number},
                success:function(data){
                    $('#instrumentation_detail').html(data);
                    $('#parts_data_modal').modal('show');
                }
            });
        }
    });
    $('#duration_hours').on("input", function() {
        $('#duration').val(computeDurationSecs());
    });
    $('#duration_minutes').on("input", function() {
        $('#duration').val(computeDurationSecs());
    });
    $('#duration_seconds').on("input", function() {
        $('#duration').val(computeDurationSecs());
    });
});

function computeDurationSecs() {
    var durationSecs = 0;
    var hours = $('#duration_hours').val();
    var minutes = $('#duration_minutes').val();
    var seconds = $('#duration_seconds').val();
    if(!isNaN(hours) && hours.length !== 0)   durationSecs += parseInt(hours) * 3600;
    if(!isNaN(minutes) && minutes.length !== 0) durationSecs += parseInt(minutes) * 60;
    if(!isNaN(seconds) && seconds.length !== 0) durationSecs += parseInt(seconds);
    return durationSecs;
}
</script>
</body>
</html>