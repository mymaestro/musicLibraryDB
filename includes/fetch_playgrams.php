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

ferror_log(print_r($_POST,true));

if(isset($_POST["id_playgram"])) {
    ferror_log("Fetch playgrams with id=". $_POST["id_playgram"]);
    $id_playgram = mysqli_real_escape_string($f_link, $_POST["id_playgram"]);
    $sql = "SELECT * FROM playgrams WHERE id_playgram = ".$id_playgram.";";
    ferror_log("SQL: ". $sql);
    $res = mysqli_query($f_link, $sql);
    $rowList = mysqli_fetch_array($res);
    $playgram_data = json_encode($rowList);
    ferror_log("===> Playgram data JSON: ".$playgram_data);

    $sql = "SELECT * FROM playgram_items where id_playgram = ".$id_playgram.";"; // Compositions for this playgram
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
                    <th>Compositions</th>
                    <th>Duration</th>
                    <th>Enabled</th>
                </tr>
                </thead>
                <tbody>';
   
    $sql = "SELECT 
        p.id_playgram AS id_playgram,
        p.name AS playgram_name,
        p.description AS playgram_description,
        COUNT(pi.catalog_number) AS num_compositions,
        SEC_TO_TIME(SUM(c.duration)) AS total_duration,
        p.enabled
    FROM playgrams p
    LEFT JOIN playgram_items pi ON p.id_playgram = pi.id_playgram
    LEFT JOIN compositions c ON pi.catalog_number = c.catalog_number
    GROUP BY
      p.id_playgram, p.name, p.description
    ORDER BY
    p.name;";

    $res = mysqli_query($f_link, $sql) or die('Error: ' . mysqli_error($f_link));
    while ($rowList = mysqli_fetch_array($res)) {
        $id_playgram = $rowList['id_playgram'];
        $name = $rowList['playgram_name'];
        $description = $rowList['playgram_description'];
        $duration = $rowList['total_duration'];
        $pieces = $rowList['num_compositions'];
        $enabled = $rowList['enabled'];
        echo '<tr data-id="'.$id_playgram.'" >
                    <td><input type="radio" name="record_select" value="'.$id_playgram.'" class="form-check-input select-radio"></td>
                    <td><a href="#" class="view_data" name="view" id="'.$id_playgram.'" >'.$name.'</a></td>
                    <td>'.$description.'</td>
                    <td>'.$pieces.'</td>
                    <td>'.$duration.'</td>
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
