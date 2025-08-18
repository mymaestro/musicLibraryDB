<?php
// find_unreferenced_audio.php
// Utility to list audio and meta files not referenced in the recordings table

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

// Connect to DB
$link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);



// Get all referenced file names from the recordings table
$referenced = [];
$res = mysqli_query($link, "SELECT link FROM recordings WHERE link IS NOT NULL AND link != ''");
while ($row = mysqli_fetch_assoc($res)) {
    $referenced[] = $row['link'];
}
$referencedSet = array_flip($referenced);

$baseDir = __DIR__ . '/files/recordings/';
$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($baseDir));
$audioFiles = [];
$jsonFiles = [];
foreach ($rii as $file) {
    if ($file->isDir()) continue;
    $basename = $file->getFilename();
    $pathname = $file->getPathname();
    if (preg_match('/\.(mp3|ogg|flac)$/i', $basename)) {
        $audioFiles[$basename] = $pathname;
    } elseif (preg_match('/^meta_audio.*\.json$/i', $basename)) {
        $jsonFiles[$basename] = $pathname;
    }
}

// 1. List audio files not referenced in the database
$unrefAudio = [];
foreach ($audioFiles as $basename => $pathname) {
    if (!isset($referencedSet[$basename])) {
        $unrefAudio[] = $pathname;
    }
}

// 2. List JSON files that reference any audio file not in the database
$jsonReferencingUnref = [];
foreach ($jsonFiles as $jsonPath) {
    $json = @file_get_contents($jsonPath);
    if ($json) {
        $data = @json_decode($json, true);
        if (is_array($data)) {
            $referencedInJson = [];
            $possibleFields = ['filename', 'filepath', 'filenamepath', 'file', 'audiofile', 'name'];
            foreach ($possibleFields as $field) {
                if (!empty($data[$field]) && is_string($data[$field])) {
                    $referencedInJson[] = basename($data[$field]);
                }
            }
            $flat = new RecursiveIteratorIterator(new RecursiveArrayIterator($data));
            foreach ($flat as $k => $v) {
                if (is_string($v) && preg_match('/\.(mp3|ogg|flac)$/i', $v)) {
                    $referencedInJson[] = basename($v);
                }
            }
            foreach ($referencedInJson as $audioBase) {
                if ($audioBase && !isset($referencedSet[$audioBase])) {
                    $jsonReferencingUnref[] = $jsonPath;
                    break; // Only need to list each JSON file once
                }
            }
        }
    }
}

if (empty($unrefAudio) && empty($jsonReferencingUnref)) {
    echo "No unreferenced audio files and no JSON files referencing unreferenced audio.\n";
} else {
    if (!empty($unrefAudio)) {
        echo "Audio files not referenced in the database:\n";
        foreach ($unrefAudio as $f) {
            echo $f . "\n";
        }
    }
    if (!empty($jsonReferencingUnref)) {
        echo "\nJSON files referencing audio files not in the database:\n";
        foreach ($jsonReferencingUnref as $f) {
            echo $f . "\n";
        }
    }
}
