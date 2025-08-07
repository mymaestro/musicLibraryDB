<?php
require_once('config.php');
require_once('functions.php');

// Get search parameters
$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$genre = isset($_POST['genre']) ? intval($_POST['genre']) : 0;
$ensemble = isset($_POST['ensemble']) ? $_POST['ensemble'] : '';
$grade = isset($_POST['grade']) ? floatval($_POST['grade']) : 0;
$duration = isset($_POST['duration']) ? $_POST['duration'] : '';

// Build SQL query
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$sql = "SELECT c.catalog_number, c.name, c.composer, c.arranger, c.duration, c.grade, 
               g.name AS genre_name, c.genre, e.name AS ensemble_name, c.ensemble
        FROM compositions c 
        LEFT JOIN genres g ON c.genre = g.id_genre 
        LEFT JOIN ensembles e ON c.ensemble = e.id_ensemble
        WHERE c.enabled = 1";

// Add search text filter
if (!empty($search)) {
    $search_escaped = mysqli_real_escape_string($f_link, $search);
    $sql .= " AND (c.name LIKE '%$search_escaped%' 
                   OR c.composer LIKE '%$search_escaped%' 
                   OR c.arranger LIKE '%$search_escaped%'
                   OR c.catalog_number LIKE '%$search_escaped%')";
}

// Add genre filter
if ($genre > 0) {
    $sql .= " AND c.genre = " . intval($genre);
}

// Add ensemble filter  
if ($ensemble > 0) {
    $sql .= " AND c.ensemble = '" . mysqli_real_escape_string($f_link, $ensemble) . "'";
}

// Add grade filter
if ($grade > 0) {
    $sql .= " AND c.grade = " . floatval($grade);
}

// Add duration filter
if (!empty($duration)) {
    switch ($duration) {
        case 'short':
            $sql .= " AND c.duration > 0 AND c.duration <= 180"; // 0-3 minutes
            break;
        case 'medium':
            $sql .= " AND c.duration > 180 AND c.duration <= 480"; // 3-8 minutes
            break;
        case 'long':
            $sql .= " AND c.duration > 480"; // 8+ minutes
            break;
    }
}

$sql .= " ORDER BY c.name LIMIT 100"; // Limit results to prevent overwhelming

ferror_log("The search SQL: " . $sql);

$res = mysqli_query($f_link, $sql);
$results = [];

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $results[] = $row;
    }
}

mysqli_close($f_link);

// Return JSON response
header('Content-Type: application/json');
echo json_encode($results);
?>
