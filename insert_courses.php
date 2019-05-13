<?php
 //insert_courses.php
require_once('includes/config.php');
require_once('includes/functions.php');
error_log("Running insert_courses.php with id=". $_POST["course_id"]);
$link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!empty($_POST)) {
    $output = '';
    $message = '';
    // timestamp:          Row created, auto-generated
    $timestamp = time();
    // title:              Title of the class
    $title = mysqli_real_escape_string($link, $_POST['title']);
    // audience:           Description of the intended audience
    $audience = mysqli_real_escape_string($link, $_POST['audience']);
    // objectives:         Text of course objectives (what you learn)
    $objectives = mysqli_real_escape_string($link, $_POST['objectives']);
    // outline:            Text of the class outline
    $outline = mysqli_real_escape_string($link, $_POST['outline']);
    // ip:                 Address of the client browser that entered the form
    $ip = f_getIP();
    // course_code:        Class code
    $course_code = mysqli_real_escape_string($link, $_POST['course_code']);
    // course_type:        Commercial/Internal Classroom/Self-paced/Standalone Lab/Workshop
    if (!empty($_POST['course_type'])) {
        foreach($_POST['course_type'] as $selected) {
            $course_type .= "$selected, ";
        }
        $course_type = rtrim($course_type, ", ");
    } else {
        $course_type = '';
    }
    // delivery_method:    Instructor-led, self-paced, online 
    $delivery_method = mysqli_real_escape_string($link, $_POST['delivery_method']);
    // description:        Course description
    $description = mysqli_real_escape_string($link, $_POST['description']);
    // commercial_url:     URL to the publication of the class
    $commercial_url = mysqli_real_escape_string($link, $_POST['commercial_url']);
    // course_created:     Date of course creation
    $course_created = mysqli_real_escape_string($link, $_POST['course_created']);
    // course_completed:   Actual date of course completion
    $course_completed = mysqli_real_escape_string($link, $_POST['course_completed']);
    // course_updated:     Date of last course update
    $course_updated = mysqli_real_escape_string($link, $_POST['course_updated']);
    // course_planned:     Planned date of course completion
    $course_planned = mysqli_real_escape_string($link, $_POST['course_planned']);
    // developer_name:     Name of the courseware developer
    $developer_name = mysqli_real_escape_string($link, $_POST['developer_name']);
    // developer_address:  E-mail address of the courseware developer
    $developer_address = mysqli_real_escape_string($link, $_POST['developer_address']);
    // owner_name:         Name of the class owner
    $owner_name = mysqli_real_escape_string($link, $_POST['owner_name']);
    // owner_address:      E-mail address of the class owner
    $owner_address = mysqli_real_escape_string($link, $_POST['owner_address']);
    // platforms:          Which platform does the classroom run? (Windows/Linux/web)
    $platforms = mysqli_real_escape_string($link, $_POST['platforms']);
    // prerequisites:      Skills or classes required
    $prerequisites = mysqli_real_escape_string($link, $_POST['prerequisites']);
    // product_categories: Choose product categories  
    $product_categories = mysqli_real_escape_string($link, $_POST['product_categories']);
    // product_names:      Names of product(s) covered by the class
    $product_names = mysqli_real_escape_string($link, $_POST['product_names']);
   // course_duration:    Duration of the class in days
    $course_duration = mysqli_real_escape_string($link, $_POST['course_duration']);
    // machine_image_ids:  AWS machine image ID(s)
    $machine_image_ids = mysqli_real_escape_string($link, $_POST['machine_image_ids']);
    // tags:               Tags
    $tags = mysqli_real_escape_string($link, $_POST['tags']);

    if($_POST["course_id"] != '') {
        $sql = "
        UPDATE classes 
        SET title ='$title',
        timestamp = '$timestamp',
        audience = '$audience',
        objectives = '$objectives',
        outline = '$outline',
        ip = '$ip',
        course_code = '$course_code',
        course_type = '$course_type',
        delivery_method = '$delivery_method',
        description = '$description',
        commercial_url = '$commercial_url',
        course_created = '$course_created',
        course_completed = '$course_completed',
        course_updated = '$course_updated',
        course_planned = '$course_planned',
        developer_name = '$developer_name',
        developer_address = '$developer_address',
        owner_name = '$owner_name',
        owner_address = '$owner_address',
        platforms = '$platforms',
        prerequisites = '$prerequisites',
        product_categories = '$product_categories',
        product_names = '$product_names',
        course_duration = '$course_duration',
        machine_image_ids = '$machine_image_ids',
        tags = '$tags'
        WHERE id='".$_POST["course_id"]."'";
        $message = 'Data Updated';
    } else {
        $sql = "
        INSERT INTO classes(title, timestamp, audience, objectives, outline, ip, course_code, course_type, delivery_method, description, commercial_url, course_created, course_completed, course_updated, course_planned, developer_name, developer_address, owner_name, owner_address, platforms, prerequisites, product_categories, product_names, course_duration, machine_image_ids, tags)
        VALUES('$title', '$timestamp', '$audience', '$objectives', '$outline', '$ip', '$course_code', '$course_type', '$delivery_method', '$description', '$commercial_url', '$course_created', '$course_completed', '$course_updated', '$course_planned', '$developer_name', '$developer_address', '$owner_name', '$owner_address', '$platforms', '$prerequisites', '$product_categories', '$product_names', '$course_duration', '$machine_image_ids', '$tags');
        ";
        $message = 'Data Inserted';
    }
    if(mysqli_query($link, $sql)) {
        $output .= '<label class="text-success">' . $message . '</label>';
        $select_query = "SELECT * FROM classes ORDER BY timestamp DESC LIMIT 1";
        $res = mysqli_query($link, $select_query);
        $output .= '
            <table class="table">
                <tr>
                    <th width="5%">&nbsp;</th>
                    <th width="65%">Course Title</th>
                    <th width="15%">Edit</th>
                    <th width="15%">View</th>
                </tr>
           ';
        while($row = mysqli_fetch_array($res)) {
            $output .= '
                <tr>
                    <td>
                ';
            switch($row["product_categories"]) {
                case "Automation":
                    $output .= '<button type="button" class="btn btn-primary btn-sm">Automation</button>';
                    break;
                case "DevOps":
                    $output .= '<button type="button" class="btn btn-warning btn-sm">DevOps</button>';
                    break;
                case "Data":
                    $output .= '<button type="button" class="btn btn-success btn-sm">Data</button>';
                    break;
                case "SecureDevOps":
                    $output .= '<button type="button" class="btn btn-info btn-sm">Secure DevOps</button>';
                    break;
                default:
                    $output .= '<button type="button" class="btn btn-dark btn-sm">Unknown</button>';
            }
            $output .= '</td>
                    <td>' . $row["title"] . '</td>
                    <td><input type="button" name="edit" value="Edit" id="'.$row["id"] .'" class="btn btn-primary btn-sm edit_data" /></td>
                    <td><input type="button" name="view" value="View" id="' . $row["id"] . '" class="btn btn-secondary btn-sm view_data" /></td>
                </tr>
            ';
        }
        $output .= '</table>';
        $referred = $_SERVER['HTTP_REFERER'];
        $query = parse_url($referred, PHP_URL_QUERY);
        $referred = str_replace(array('?', $query), '', $referred);
        echo '<p><a href="'.$referred.'">Return</a></p>';
        echo $output;
    } else {
        $message = "Failed";
        $error_message = mysqli_error($link);
        $output .= '<p class="text-danger">' . $message . '. Error: ' . $error_message . '</p>
           ';
        echo '<p><a href="'.$referred.'">Return</a></p>';
        echo $output;
        error_log("Error: " . $error_message);
    }
 }
 ?>