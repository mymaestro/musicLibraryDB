<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<!-- Warren Gill ACWE
#############################################################################
# Licensed Materials - Property of ACWE*
# (C) Copyright Austin Civic Wind Ensemble 2022, 2025 All rights reserved.
#############################################################################
-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Music library system">
    <meta name="author" content="Warren Gill">
    <link rel="icon" href="favicon.ico">

    <title><?php echo PAGE_TITLE ?></title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    
    <!-- Font Awesome for icons -->
    <!-- https://use.fontawesome.com/releases/v5.0.8/css/all.css" -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    
    <!-- Prevent navbar overlay -->
    <style>
    body {
        padding-top: 60px;
    }
    @media (max-width: 979px) {
        body {
            padding-top: 0px;
        }
    }
    #btn-back-to-top {
        position: fixed;
        bottom: 20px;
        right: 20px;
        display: none;
    }
    </style>
<?php if (PAGE_NAME == 'Parts') : ?>
   <!-- this is the PARTS page 
        eventually you will be able to upload PDF parts here -->
<?php elseif (PAGE_NAME == 'Recordings') : ?>
    <!-- this is the RECORDINGS page
        eventually you will be able to upload MP3 recordings here -->
<?php endif; ?>

</head>
<body>
