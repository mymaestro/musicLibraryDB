<?php
require_once('includes/config.php');
require_once('includes/functions.php');
error_log("Running select.php with id=". $_POST["course_id"]);
if (isset($_POST["course_id"])) {
    $output = "";
    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM classes WHERE id = '".$_POST["course_id"]."'";
    $res = mysqli_query($f_link, $sql);
    $output .= '
    <div class="table-responsive">
        <table class="table">';
    while($rowList = mysqli_fetch_array($res)) {
        $output .= '
            <tr>
                <td>';
        switch($rowList["product_categories"]) {
            case "Automation":
                $output .= '<button type="button" class="btn btn-primary">Automation</button>';
                break;
            case "DevOps":
                $output .= '<button type="button" class="btn btn-warning">DevOps</button>';
                break;
            case "Data":
                $output .= '<button type="button" class="btn btn-success">Data</button>';
                break;
            case "SecureDevOps":
                $output .= '<button type="button" class="btn btn-info">Secure DevOps</button>';
                break;
            default:
                $output .= '<button type="button" class="btn btn-dark">Unknown</button>';
        }
        $output .= '</td>
                <td><h4 class="text-info">'.$rowList["course_code"].'</h4> <b>'.$rowList["title"].'</b></td>
            </tr>
            <tr>
                <td><label>Audience</label></td>
                <td>'.$rowList["audience"].'</td>
            </tr>
            <tr>
                <td><label>Objectives</label></td>
                <td>'.$rowList["objectives"].'</td>
            </tr>
            <tr>
                <td><label>Outline</label></td>
                <td>'.$rowList["outline"].'</td>
            </tr>
            <tr>
                <td><label>Course type</label></td>
                <td>'.$rowList["course_type"].'</td>
            </tr>
            <tr>
                <td><label>Delivery method</label></td>
                <td>'.$rowList["delivery_method"].'</td>
            </tr>
            <tr>
                <td><label>Description</label></td>
                <td>'.$rowList["description"].'</td>
            </tr>
            <tr>
                <td><label>Commercial URL</label></td>
                <td><p class="text-primary">'. $rowList["commercial_url"].'</p></td>
            </tr>
            <tr>
                <td><label>Date created</label></td>
                <td>'.$rowList["course_created"].'</td>
            </tr>
            <tr>
                <td><label>Date completed</label></td>
                <td>'.$rowList["course_completed"].'</td>
            </tr>
            <tr>
                <td><label>Date updated</label></td>
                <td>'. $rowList["course_updated"].'</td>
            </tr>
            <tr>
                <td><label>Date planned</label></td>
                <td>'.$rowList["course_planned"].'</td>
            </tr>
            <tr>
                <td><label>Developer name</label></td>
                <td>'.$rowList["developer_name"].'</td>
            </tr>
            <tr>
                <td><label>Developer address</label></td>
                <td><p class="text-primary">'.$rowList["developer_address"].'</p></td>
            </tr>
            <tr>
                <td><label>Owner name</label></td>
                <td>'.$rowList["owner_name"].'</td>
            </tr>
            <tr>
                <td><label>Owner address</label></td>
                <td><p class="text-primary">'. $rowList["owner_address"].'</p></td>
            </tr>
            <tr>
                <td><label>Platforms</label></td>
                <td>'. $rowList["platforms"].'</td>
            </tr>
            <tr>
                <td><label>Prerequisites</label></td>
                <td>'.$rowList["prerequisites"].'</td>
            </tr>
            <tr>
                <td><label>Product names</label></td>
                <td>'.$rowList["product_names"].'</td>
            </tr>
            <tr>
                <td><label>Course duration</label></td>
                <td>'. $rowList["course_duration"].' days</td>
            </tr>
            <tr>
                <td><label>AWS machine image IDs</label></td>
                <td>'. $rowList["machine_image_ids"].'</td>
            </tr>
            <tr>
                <td><label>Tags</label></td>
                <td>'. $rowList["tags"].'</td>
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