<?php
/*
#############################################################################
# Licensed Materials - Property of ACWE*
# (C) Copyright Austin Civic Wind Ensemble 2021 All rights reserved.
#############################################################################
*/
    require_once('config.php');
    require_once('functions.php');

    /* Submit forms from only the same domain */
    $domain = $_SERVER['HTTP_HOST'];
    $uri = parse_url($_SERVER['HTTP_REFERER']);
    $d_domain = substr($domain, strpos($domain, "."), strlen($domain));
    $r_domain = substr($uri['host'], strpos($uri['host'], "."), strlen($uri['host']));

    if ( $d_domain == $r_domain ) {
        /* open database */
        $link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        /* Clean &_POST array */
        $_POST = f_clean($link, $_POST);

        /* main variables to process */
        $table = $_POST['formID'];
        
        /* variables for redirect */
        $redirect = $_POST['redirect_to'];
        $referred = $_SERVER['HTTP_REFERER'];
        $query = parse_url($referred, PHP_URL_QUERY);
        $referred = str_replace(array('?', $query), '', $referred);

        /* Remove formID and redirect_to */
        unset($_POST['formID']);
        unset($_POST['redirect_to']);
        $keys = implode(", ", (array_keys($_POST)));
        $values = implode("', '", (array_values($_POST)));

        ferror_log("Entering data into table: ". $table);
        ferror_log("Table keys: ". $keys);
        ferror_log("Table values: ". $values);
       
        /* extra data fields */
        $x_fields = 'timestamp, ip';
        $x_values = time() . "', '" . f_getIP();

        /* check if table exists */
        if (!f_tableExists($link, $table, DB_NAME)) {
            $sql = "CREATE TABLE $table (
            ID int NOT NULL AUTO_INCREMENT,
            PRIMARY KEY(ID),
            timestamp int NOT NULL,
            ip int NOT NULL
            )";

            $result = mysqli_query($link, $sql);
            if (!$result) {
                die('Invalid query: ' . mysqli_error($link));
            }
        }

        /* check if fields in table exist */
        foreach ($_POST as $key => $value) {
            $column = mysqli_real_escape_string($link, $key);
            $alter = f_fieldExists($link, $table, $column, $column_attr = "VARCHAR( 255 )");
            if (!$alter) {
                echo 'Unable to add column: ' . $column . ' ';
            }
        }

        /* Insert values */
        $sql="INSERT INTO $table ($keys, $x_fields) VALUES ('$values', '$x_values');";
        if (!mysqli_query($link, $sql)) {
            die('Error: ' . mysqli_error($link));
        }
        mysqli_close($link);

        /* Redirect to the success page */
        if ( !empty ( $redirect )) {
            header("Location: $redirect?msg=1");
        } else {
            header("Location: $referred?msg=1");
        }
    } else {
        die("You are not allowed to submit data on this form at $domain from $r_domain.");
    }
?>
