<?php  
 //fetch_playgrams.php
require_once('config.php');
require_once('functions.php');
ferror_log("Running fetch_playgrams.php");

if(isset($_POST["user_role"])) {
    $u_librarian = (($_POST["user_role"] == 'librarian') !== FALSE ? TRUE : FALSE);
} else {
    $u_librarian = FALSE;
}

$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if(isset($_POST["id_playgram"])) {
    ferror_log("playgrams with id=". $_POST["id_playgram"]);
    $id_playgram = mysqli_real_escape_string($f_link, $_POST["id_playgram"]);
    $sql = "SELECT * FROM playgrams WHERE id_playgram = ".$id_playgram.";";
    ferror_log("SQL: ". $sql);
    $res = mysqli_query($f_link, $sql);
    $rowList = mysqli_fetch_array($res);
    $playgram_data = json_encode($rowList);
    ferror_log("===> Playgram data JSON: ".$playgram_data);

    $sql = "SELECT * FROM playgram_items where id_playgram = ".$id_playgram.";"; // Compositions for this playgram


/* NEED TO DO A JOIN WITH COMPOSITIONS TO GET name, composer, arranger in the same outputted field.

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
*/

    ferror_log("PGITEMS SQL " . $sql);
    $playgram_items = array();
    $res = mysqli_query($f_link, $sql);
    while($rowList = mysqli_fetch_array($res)) {
        $playgram_items[] = $rowList;
    }

    $playgram_compositions = json_encode($playgram_items);
    ferror_log("PLAYGRAM_ITEMS ".$playgram_compositions);
    // spitting out JSON object of the playgram and its compositions
    $return = json_encode('{"playgram":'.$playgram_data.',"compositions":'.$playgram_compositions . "}");
    ferror_log("JSON: " . $return);
    echo $return;
} else {
    echo '            <div class="panel panel-default">
           <div class="table-repsonsive">
                <table class="table table-hover">
                <caption class="title">Available program play lists (playgrams)</caption>
                <thead>
                <tr>
                    <th style="width: 50px;"></th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Enabled</th>
                </tr>
                </thead>
                <tbody>';
    $sql = "SELECT * FROM playgrams;";
    $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
    while ($rowList = mysqli_fetch_array($res)) {
        $id_playgram = $rowList['id_playgram'];
        $name = $rowList['name'];
        $description = $rowList['description'];
        $enabled = $rowList['enabled'];
        echo '<tr data-id="'.$id_playgram.'" >
                    <td><input type="radio" name="record_select" value="'.$id_playgram.'" class="form-check-input select-radio"></td>
                    <td><a href="#" class="view_data" name="view" id="'.$id_playgram.'" >'.$name.'</a></td>
                    <td>'.$description.'</td>
                    <td>'. (($enabled == 1) ? "Yes": "No" ). '</td>
                </tr>';
    }
    echo '
                </tbody>
                </table>
            </div><!-- table-responsive -->
        </div><!-- panel -->
       ';
}
mysqli_close($f_link);
?>
