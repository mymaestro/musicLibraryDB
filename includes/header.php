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
    <!-- Favorite icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <title><?php echo PAGE_TITLE ?></title>

    <!-- Bootswatch Yeti https://bootswatch.com/yeti/ -->
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.7/dist/yeti/bootstrap.min.css" rel="stylesheet">

    <!-- Uncomment to use Bootstrap core CSS instead of Bootswatch theme
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    -->

    <!-- Font Awesome for icons -->
    <!-- https://use.fontawesome.com/releases/v5.0.8/css/all.css" -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">

    <!-- Prevent navbar overlay -->
    <style>
    html, body {
        padding-top: 30px;
        height: 100%;
        margin: 0;
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
    body {
      display: flex;
      flex-direction: column;
    }
    </style>

<?php if (PAGE_NAME == 'Parts') : ?>
   <!-- this is the PARTS page 
        eventually you will be able to upload PDF parts here -->
    <style>
    header .navbar {
      height: 56px;
    }

    main {
      flex: 1;
      display: flex;
      overflow: hidden;
      margin-top: 18px; /* same height as navbar */
    }

    aside.left-panel {
      width: 280px;
      border-right: 1px solid #ccc;
      background: #f8f9fa;
      display: flex;
      flex-direction: column;
    }

    .left-menu-scroll,
    .table-wrapper {
      height: calc(100vh - 324px ); /* 196px - 88px - 40px header height (32) + title + footer height, each row is 33px */
      overflow-y: auto;
      flex-grow: 1;
    }

    section.right-panel {
      flex: 1;
      display: flex;
      flex-direction: column;
      overflow: hidden;
      padding: 1rem;
    }

    .table-toolbar {
      position: sticky;
      top: 0;
      background: #fff;
      z-index: 2;
      padding-bottom: 0.5rem;
    }

    .table-wrapper {
      flex: 1;
      overflow-y: auto;
    }

    .table thead th {
      position: sticky;
      top: 0;
      background-color: #f8f9fa;
      z-index: 1;
    }

    footer {
      flex-shrink: 0;
    }
  </style>
<?php elseif (PAGE_NAME == 'concerts') : ?>
    <!-- this is the CONCERTS page -->
    <style>
    header .navbar {
      height: 56px;
    }

    main {
      flex: 1;
      display: flex;
      overflow: hidden;
      margin-top: 18px; /* same height as navbar */
    }

    .concerts_table {
      height: calc(100vh - 124px ); /* 196px - 88px - 40px header height (32) + title + footer height, each row is 33px */
      overflow-y: auto;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
    }

    footer {
      flex-shrink: 0;
    }
    </style>

<?php elseif (PAGE_NAME == 'Part types') : ?>
    <!-- this is the PART TYPES page  -->
    <style>
    header .navbar {
      height: 56px;
    }

    main {
      flex: 1;
      display: flex;
      overflow: hidden;
      margin-top: 18px; /* same height as navbar */
    }

    .part_type_table {
      height: calc(100vh - 124px ); /* 196px - 88px - 40px header height (32) + title + footer height, each row is 33px */
      overflow-y: auto;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
    }

    footer {
      flex-shrink: 0;
    }
    </style>

<?php elseif (PAGE_NAME == 'Recordings') : ?>
    <!-- this is the RECORDINGS page
        eventually you will be able to upload MP3 recordings here -->
<?php endif; ?>

</head>
<body class="d-flex flex-column h-100">
