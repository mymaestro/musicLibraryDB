<?php  
 //fetch_collections.php
require_once('config.php');
require_once('functions.php');
if(isset($_POST["catalog_number_key"])) {
    ferror_log("Running fetch_partcollections.php with id=". $_POST["catalog_number_key"]);
    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Get the specific collection details
    $sql = "SELECT pc.*, 
                   c.name as composition_title,
                   pt.name as part_type_name,
                   i.name as instrument_name
              FROM part_collections pc
              LEFT JOIN compositions c ON c.catalog_number = pc.catalog_number_key
              LEFT JOIN part_types pt ON pt.id_part_type = pc.id_part_type_key
              LEFT JOIN instruments i ON i.id_instrument = pc.id_instrument_key
             WHERE pc.catalog_number_key = '".$_POST["catalog_number_key"]."'
               AND pc.id_part_type_key = '".$_POST["id_part_type_key"]."'
               AND pc.id_instrument_key = '".$_POST["id_instrument_key"]."'";

    ferror_log("SQL: ". $sql);
    $res = mysqli_query($f_link, $sql);
    $rowList = mysqli_fetch_array($res);
    
    if ($rowList) {
        // Also get all other instruments in this same part collection
        $sql_related = "SELECT pc.*, i.name as instrument_name
                       FROM part_collections pc
                       LEFT JOIN instruments i ON i.id_instrument = pc.id_instrument_key
                       WHERE pc.catalog_number_key = '".$_POST["catalog_number_key"]."'
                         AND pc.id_part_type_key = '".$_POST["id_part_type_key"]."'
                       ORDER BY i.collation";
        
        $res_related = mysqli_query($f_link, $sql_related);
        $related_instruments = [];
        while ($related_row = mysqli_fetch_array($res_related)) {
            $related_instruments[] = $related_row;
        }
        
        $rowList['related_instruments'] = $related_instruments;
        $rowList['instrument_count'] = count($related_instruments);
    }
    
    echo json_encode($rowList);
    mysqli_close($f_link);
}
?>
