<?php
//fetch_playgram_items.php
// This script fetches the playgram items for a given concert ID and returns them as HTML
// It expects a POST request with 'id_concert' parameter
require_once('config.php');
require_once('functions.php');

if (isset($_POST['id_concert'])) {
    $id_concert = intval($_POST['id_concert']);
    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Get the playgram for this concert
    $sql = "SELECT id_playgram FROM concerts WHERE id_concert = $id_concert LIMIT 1";
    $res = mysqli_query($f_link, $sql);
    $row = mysqli_fetch_assoc($res);
    $id_playgram = $row ? intval($row['id_playgram']) : 0;

    $options = "";
    if ($id_playgram) {
        // Get catalog_numbers from playgram_items for this playgram
        $sql = "SELECT pi.catalog_number, c.name, c.composer, c.arranger
                FROM playgram_items pi
                JOIN compositions c ON pi.catalog_number = c.catalog_number
                WHERE pi.id_playgram = $id_playgram
                ORDER BY c.name";
        $res = mysqli_query($f_link, $sql);
        while ($row = mysqli_fetch_assoc($res)) {
            $comp_catno = htmlspecialchars($row['catalog_number']);
            $comp_name = htmlspecialchars($row['name']);
            $comp_composer = htmlspecialchars($row['composer']);
            $comp_arranger = htmlspecialchars($row['arranger']);
            $comp_display = $comp_name . " - " . $comp_catno;
            if ($comp_composer || $comp_arranger) $comp_display .= ' (';
            if ($comp_composer && $comp_arranger) $comp_display .= $comp_composer . ", arr. " . $comp_arranger . ")";
            if (!$comp_composer && $comp_arranger) $comp_display .= "arr. " . $comp_arranger . ")";
            if ($comp_composer && !$comp_arranger) $comp_display .= $comp_composer . ")";
            $options .= "<option value='$comp_catno'>$comp_display</option>";
        }
    }
    echo $options;
    mysqli_close($f_link);
}
?>