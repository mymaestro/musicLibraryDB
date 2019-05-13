<?php
require_once 'includes/config.php';
// Get the faker
require_once 'faker/autoload.php';
require_once 'includes/functions.php';

$trial_Run = TRUE;

$faker = Faker\Factory::create();

$link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

/*
  Things that are the same each time
*/
// course_type: Commercial/Internal Classroom/Self-paced/Standalone Lab/Workshop
//    examples "Internal classroom", "Commercial Standalong Lab", "Internal workshop"
//$course_type = "Commerical Self-paced";
$course_type = "Internal classroom"; 
// delivery_method: Instructor-led, self-paced, online
$delivery_method = "Instructor-led";
// commercial_url:     URL to the publication of the class
$commercial_url = $faker -> url();
$course_created = "2018-01-01";
$course_completed = "2018-02-28";
$course_updated = "2018-01-01";
$course_planned = "2018-02-28";
$product_categories = "DevOps";
$platforms = "Windows";
$product_names = "HCL P&P product 3";
$machine_image_ids = "aws9876652";
$tags = "smart learners welcome";

/*
  Things that change every time
*/

// id: Unique ID, auto-increments
// timestamp: Row created, auto-generated
$timestamp = time();
    echo "Timestamp: $timestamp\n";
// ip: Address of the client browser that entered the form
$ip = 70113;
    echo "IP: $ip";
// title: Title of the class
$title = "HCL " . $faker -> catchPhrase;
    echo "Title: $title \n" ;
// course_code: Class code
$course_code = $faker -> shuffle('HWARITC');
$course_code = $course_code . $faker -> shuffle('012345'); 
    echo "Course code: $course_code \n";
// course_type: Commercial/Internal Classroom/Self-paced/Standalone Lab/Workshop
    echo "Course type: $course_type \n";                            
// delivery_method: Instructor-led, self-paced, online
    echo "Delivery method: $delivery_method \n";
// description: Course description
$description = str_replace( "'", "", $faker -> realText($faker -> numberBetween(147,159)) );
    echo "Description: $description\n";
// audience: Description of the intended audience     
$audience = str_replace( "'", "", $faker -> realText($faker -> numberBetween(47,59)) );
$audience = "This class is for... " . $audience;
    echo "Audience: $audience\n" ;
 //  objectives:Text of course objectives (what you learn)
$objectives = str_replace( "'", "", $faker -> realText($faker -> numberBetween(147,159)));
    echo "Objectives: $objectives\n";
// outline: Text of the class outline
$outline = str_replace( "'", "", $faker ->realText($faker -> numberBetween(147,159)));
    echo "Outline: $outline\n";
// commercial_url:     URL to the publication of the class
    echo "URL: $commercial_url\n";
// course_created:     Date of course creation
    echo "Course created: $course_created\n";
// course_completed:   Actual date of course completion
    echo "Course completed: $course_completed\n";
// course_updated:     Date of last course update
    echo "Course updated: $course_updated\n";
// course_planned:     Planned date of course completion
    echo "Course planned: $course_planned\n";
// developer_name:     Name of the courseware developer
$developer_name = $faker -> name;
    echo "Developer: $developer_name\n";
// developer_address:  E-mail address of the courseware developer
$developer_address = str_replace(" ",".", $developer_name) . '@' . "hcltech.com";
    echo "Developer address: $developer_address\n";
// owner_name:         Name of the class owner
$owner_name = $faker -> name;
    echo "Owner: $owner_name\n";
// owner_address:      E-mail address of the class owner
$owner_address = str_replace(" ",".", $owner_name) . '@' . "hcltech.com";
    echo "Owner address: $owner_address\n";
// platforms:          Which platform does the classroom run? (Windows/Linux/web)
    echo "Platforms: $platforms\n";
// prerequisites:      Skills or classes required
$prerequisites = str_replace( "'", "", $faker -> realText($faker -> numberBetween(47,59)));
    echo "Prerequisites: $prerequisites\n";
// product_categories: Choose product categories  
    echo "Portfolio: $product_categories\n";
// product_names:      Names of product(s) covered by the class
    echo "Products: $product_names\n";
// course_duration:    Duration of the class in days
$course_duration = 2;
    echo "Duration: $course_duration Days\n";
// machine_image_ids:  AWS machine image ID(s)
    echo "AMI: $machine_image_ids\n";
// tags:               Tags
    echo "Tags: $tags\n";

$sql = 'INSERT INTO classes (timestamp, ip, title, course_code, course_type, delivery_method, description, audience, objectives, outline, commercial_url, course_created, course_completed, course_updated, course_planned, developer_name, developer_address, owner_name, owner_address, platforms, prerequisites, product_categories, product_names, course_duration, machine_image_ids, tags) VALUES ( ';
$sql_values = "$timestamp, $ip, " . '"' .
mysqli_real_escape_string($link, $title) . '", "' .
$course_code . '", "' .
$course_type . '", "' .
$delivery_method . '", "' .
mysqli_real_escape_string($link, $description) . '", "' .
mysqli_real_escape_string($link, $audience) . '", "' .
mysqli_real_escape_string($link, $objectives) . '", "' .
mysqli_real_escape_string($link, $outline) . '", "' .
$commercial_url . '", "' .
$course_created . '", "' .
$course_completed . '", "' .
$course_updated . '", "' .
$course_planned . '", "' .
$developer_name . '", "' .
$developer_address . '", "' .
$owner_name . '", "' .
$owner_address . '", "' .
$platforms . '", "' .
mysqli_real_escape_string($link, $prerequisites) . '", "' .
$product_categories . '", "' .
mysqli_real_escape_string($link, $product_names) . '", ' .
$course_duration . ', "' .
$machine_image_ids . '", "' .
$tags . '" );';
echo "-----------------\n";
echo "SQL string\n";
echo "-----------------\n";
echo "$sql $sql_values\n";
$sql = $sql . $sql_values;

if (!$trial_Run) {
    if (!mysqli_query($link, $sql)) {
        die('Error: ' . mysqli_error());
    }
    mysqli_close($link);
}
?>