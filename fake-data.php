<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Fake data</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">
</head>

<body>
<H1>fake stuff</h1>
<?php
// Get the faker
require_once 'faker/autoload.php';

$faker = Faker\Factory::create();

$fullname = $faker -> name;
$email = str_replace(" ",".", $fullname) . '@' . "hcltech.com";

$oFullname = $faker -> name;
$oEmail = str_replace(" ",".", $oFullname) . '@' . "hcltech.com";
// $text1 = $faker -> text;
// $text2 = $faker -> text;
// Let's get some fake data!
echo "<p>Developer name:</br>" . $fullname;
echo "</p><p>Developer Email:</br>" . $email;
echo "</p><p>Owner name:</br>" . $oFullname;
echo "</p><p>Owner Email:</br>" . $oEmail;
echo "</p><p>Address:</br>" . $faker -> address;
echo "</p><p>Description:</br>" .  $faker -> text;
echo "</p><p>Text:</br>" .  $faker -> text;
echo "</p><p>Text:</br>" .  $faker -> text;
echo "</p><p>Text:</br>" .  $faker -> text;
echo "</p>"
?>

            <!-- id:                 Unique ID, auto-increments -->
            <!-- timestamp:          Row created, auto-generated -->
            <!-- ip:                 Address of the client browser that entered the form -->
            <!-- title:              Title of the class -->
            <!-- course_code:        Class code -->
            <!-- course_type:        Commercial/Internal Classroom/Self-paced/Standalone Lab/Workshop -->
            <!-- delivery_method:    Instructor-led, self-paced, online -->
            <!-- description:        Course description -->
            <!-- audience:           Description of the intended audience -->
            <!-- objectives:         Text of course objectives (what you learn) -->
            <!-- outline:            Text of the class outline -->
            <!-- commercial_url:     URL to the publication of the class -->
            <!-- course_created:     Date of course creation -->
            <!-- course_completed:   Actual date of course completion -->
            <!-- course_updated:     Date of last course update -->
            <!-- course_planned:     Planned date of course completion -->
            <!-- developer_name:     Name of the courseware developer -->
            <!-- developer_address:  E-mail address of the courseware developer -->
            <!-- owner_name:         Name of the class owner -->
            <!-- owner_address:      E-mail address of the class owner -->
            <!-- platforms:          Which platform does the classroom run? (Windows/Linux/web) -->
            <!-- prerequisites:      Skills or classes required -->
            <!-- product_categories: Choose product categories   -->
            <!-- product_names:      Names of product(s) covered by the class -->
            <!-- course_duration:    Duration of the class in days -->
            <!-- machine_image_ids:  AWS machine image ID(s) -->
            <!-- tags:               Tags -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>
        window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery.min.js"><\/script>')
    </script>
    <script src="assets/js/vendor/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>