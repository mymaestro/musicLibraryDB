<?php  
 //fetch_compositions.php
require_once('config.php');
require_once('functions.php');
ferror_log("Running fetch_compositions.php");

if(isset($_POST["user_role"])) {
    $u_librarian = (($_POST["user_role"] == 'librarian') !== FALSE ? TRUE : FALSE);
} else {
    $u_librarian = FALSE;
}

$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if(isset($_POST["catalog_number"])) {
    ferror_log("catalog id=". $_POST["catalog_number"]);
    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM compositions WHERE catalog_number = '".$_POST["catalog_number"]."'";
    ferror_log("SQL: ". $sql);
    $res = mysqli_query($f_link, $sql);
    $rowList = mysqli_fetch_array($res);
    echo json_encode($rowList);
} else {
    if (isset($_POST["submitButton"])) {
        ferror_log("SEARCH_BUTTON:".$_POST["submitButton"]);
    }
    if(isset($_POST["search"])) {
        ferror_log("SEARCH: ". $_POST["search"]);
    }
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
                    <th data-tablesort-type="number">Grade <i class="fa fa-sort" aria-hidden="true"></i></th>
                    <th data-tablesort-type="string">Genre <i class="fa fa-sort" aria-hidden="true"></i></th>
                    <th data-tablesort-type="string">Ensemble <i class="fa fa-sort" aria-hidden="true"></i></th>
                    <th data-tablesort-type="string">Enabled <i class="fa fa-sort" aria-hidden="true"></i></th>
                    <th data-tablesort-type="number">Parts <i class="fa fa-sort" aria-hidden="true"></i></th>
                </tr>
                </thead>
                <tbody>';
    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (isset($_POST["submitButton"])) {
        ferror_log("POST search=".$_POST["search"]);
        $jcode = array("[","]");
        $pcode = array("(",")");
        $extra_search = "";
        if(!empty($_POST["search"])){
            $search = mysqli_real_escape_string($f_link, $_POST['search']);
            $extra_search .= " MATCH(c.name, c.description, c.composer, c.arranger, c.comments)
            AGAINST( '".$search."' IN NATURAL LANGUAGE MODE)";
        }
        if(!empty($_POST["ensemble"])){
            $result = str_replace($jcode, $pcode, mysqli_real_escape_string($f_link, $_POST['ensemble']));
            $result = str_replace('\"', "'", $result);
            ferror_log("ENSEMBLE: ". $result);
            if (!empty($extra_search)) { $extra_search .= " AND ";}
            $extra_search .= " ensemble in ".$result;
        } else ferror_log("No ensemble");
        if(!empty($_POST["genre"])){
            $result = str_replace($jcode, $pcode, mysqli_real_escape_string($f_link, $_POST['genre']));
            $result = str_replace('\"', "'", $result);
            if (!empty($extra_search)) { $extra_search .= " AND ";}
            ferror_log("GENRE: ". $result);
            $extra_search .= " AND genre in ".$result;
        } else ferror_log("No genre");
        ferror_log("Search: ".$extra_search);
        foreach ($_POST as $key => $value)
            ferror_log($key.'='.$value);
        if (!empty($extra_search)) {
            $extra_search = " WHERE " . $extra_search;
        }
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
                ". $extra_search ."
                GROUP BY c.catalog_number
                ORDER BY c.catalog_number;";
                /*
                MATCH(c.name, c.description, c.composer, c.arranger, c.comments)
                AGAINST( '".$search."' IN NATURAL LANGUAGE MODE)
                                AND ensemble IN ('TC','CC') */
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
                ORDER BY c.catalog_number;";
    }
    ferror_log("RUNNING SQL = " .$sql);
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
                    <td>'.$ensemble.'</td>
                    <td><div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="typeEnabled" disabled '. (($enabled == 1) ? "checked" : "") .'>
                    </div></td>';
            if ( $partscount > 0 ) {
                echo '
                            <td><button type="button" name="parts_data" id="'.$catalog_number.'" class="btn btn-info btn-sm parts_data">'. $partscount.' parts</button></td>';
                } else {
                echo '
                            <td class="text-muted">0 parts</td>';
                }
                echo '
                <td><input type="button" name="view" value="Details" id="'.$catalog_number.'" class="btn btn-secondary btn-sm view_data" /></td>';
            if ($u_librarian) { echo '
                <td><form method="post" id="instr_data_'.$catalog_number.'" action="composition_instrumentation.php"><input type="hidden" name="catalog_number" value="'.$catalog_number.'" />
                <input type="submit" name="compositions" value="Instrumentation" id="'.$catalog_number.'" class="btn btn-warning btn-sm instr_data" /></form></td>
                <td><input type="button" name="delete" value="Delete" id="'.$catalog_number.'" class="btn btn-danger btn-sm delete_data" /></td>
                <td><input type="button" name="edit" value="Edit" id="'.$catalog_number.'" class="btn btn-primary btn-sm edit_data" /></td>';
                }
        echo '
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

}
?>