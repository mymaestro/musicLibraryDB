<?php
// find_unreferenced_parts.php
// Utility to list PDF files in ORGPRIVATE not referenced in the parts table

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

// Connect to DB
$link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Get all referenced part file names from the parts table
$referenced = [];
$res = mysqli_query($link, "SELECT image_path FROM parts WHERE image_path IS NOT NULL AND image_path != ''");
while ($row = mysqli_fetch_assoc($res)) {
    $referenced[] = $row['image_path'];
}
$referencedSet = array_flip($referenced);

$baseDir = realpath(__DIR__ . '/' . ORGPRIVATE);
if ($baseDir === false) {
    fwrite(STDERR, "Error: Could not resolve parts directory (ORGPRIVATE).\n");
    exit(1);
}

$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($baseDir));
$pdfFiles = [];
foreach ($rii as $file) {
    if ($file->isDir()) continue;
    $basename = $file->getFilename();
    $pathname = $file->getPathname();
    if (preg_match('/\.pdf$/i', $basename)) {
        $pdfFiles[$basename] = $pathname;
    }
}

// List PDF files not referenced in the database
$unrefPDF = [];
foreach ($pdfFiles as $basename => $pathname) {
    if (!isset($referencedSet[$basename])) {
        $unrefPDF[] = $pathname;
    }
}

function shell_escape($filename) {
    return "'" . str_replace("'", "'\\''", $filename) . "'";
}

if (!empty($unrefPDF)) {
    foreach ($unrefPDF as $f) {
        echo shell_escape($f) . "\n";
    }
}
