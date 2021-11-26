<?php
require_once('config.php');
require_once('functions.php');
error_log("Running select_composition_parts.php with id=". $_POST["catalog_number"]);
if (isset($_POST["catalog_number"])) {
    $output = "";
    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT p.catalog_number,
                   c.name title,
                   t.name name,
                   z.name paper_size,
                   p.page_count,
                   p.originals_count,
                   p.copies_count
            FROM   parts p
            JOIN   compositions c
            ON     p.catalog_number = c.catalog_number
            JOIN   part_types t
            ON     t.id_part_type = p.id_part_type
            JOIN   paper_sizes z
            ON     p.paper_size = z.id_paper_size
            WHERE  p.catalog_number = '".$_POST["catalog_number"]."'
            ORDER BY t.collation;";
    ferror_log("Running SQL: ". $sql);
    $res = mysqli_query($f_link, $sql);
    $rowNum = 0;
    while($rowList = mysqli_fetch_array($res)) {
        $rowNum++;
        $pages = (($rowList["page_count"] == 1) ? "page" : "pages");
        $originals = $rowList["originals_count"];
        if($rowNum == 1){
            $output .= '
            <h4><span class="text-primary">'.$rowList["catalog_number"].'</span> - <span class="text-info">'.$rowList["title"].'</span></h4>
            <div class="table-responsive">
            <table class="table table-hover">
            <thead>
                <tr>
                    <th>Part</th>
                    <th>Originals</th>
                    <th>Copies</th>
                    <th>Paper</th>
               </tr>';            
        }
        $output .= '
            <tr '. (($originals == 0) ? ' class="table-danger"' : '') . '>
                <td>'.$rowList["name"].'</td>
                <td>'.$originals.'</td>
                <td>'.$rowList["copies_count"].'</td>
                <td>'.$rowList["page_count"]. ' ' . $pages .' of '. $rowList["paper_size"].'</td>
            </tr>
            ';
    }
    $output .= '
        </table>
    </div>
    ';
    echo $output;
}
?>