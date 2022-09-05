<?php
require_once('config.php');
require_once('functions.php');
error_log("Running select_composition_parts.php with id=". $_POST["catalog_number"]);
if (isset($_POST["catalog_number"])) {
    $output = "";
    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT p.catalog_number,
                   c.name title,
                   c.composer composer,
                   t.name name,
                   p.description description,
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
    $output = '<div class="modal-header">';
    $res = mysqli_query($f_link, $sql);
    $rowNum = 0;
    while($rowList = mysqli_fetch_array($res)) {
        $rowNum++;
        $pages = (($rowList["page_count"] == 1) ? "page" : "pages");
        $originals = $rowList["originals_count"];
        if($rowNum == 1){
            $output .= '
            <h3 class="modal-title">Parts for <span class="text-primary">'.$rowList["catalog_number"].'</span> - <span class="text-info">'.$rowList["title"].'</span> <span class="text-muted">('.$rowList["composer"].')</span></h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div><!-- modal-header -->
            <div class="modal-body">
            <div class="table-responsive">
            <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th>Part</th>
                    <th>Originals</th>
                    <th>Copies</th>
                    <th>Pages</th>
                    <th>Paper</th>
                    <th>Description</th>
               </tr>
            </thead>
            <tbody>';            
        }
        $output .= '
            <tr '. (($originals == 0) ? ' class="table-danger"' : '') . '>
                <td>'.$rowList["name"].'</td>
                <td>'.$originals.'</td>
                <td>'.$rowList["copies_count"].'</td>
                <td>'.$rowList["page_count"]. '</td>
                <td>'.$rowList["paper_size"].'</td>
                <td>'.$rowList["description"].'</td>
            </tr>
            ';
    }
    $output .= '
            </tbody>
        </table>
    </div><!-- table-responsive -->
    </div><!-- modal body -->
<div class="modal-footer">
<form action="parts.php" method="POST">
    <input type="hidden" name="catalog_number" value="'.$_POST["catalog_number"].'"/>
    <input type="submit" name="parts_button" value="Edit parts" class="btn btn-info">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</form>
</div><!-- modal-footer -->

    ';
    echo $output;
}
?>