<?php
define('PAGE_TITLE', 'Music Library Dashboard');
define('PAGE_NAME', 'Dashboard');
require_once("includes/header.php");
$u_admin = FALSE;
$u_librarian = FALSE;
$u_user = FALSE;
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $u_admin = (strpos(htmlspecialchars($_SESSION['roles']), 'administrator') !== FALSE ? TRUE : FALSE);
    $u_librarian = (strpos(htmlspecialchars($_SESSION['roles']), 'librarian') !== FALSE ? TRUE : FALSE);
    $u_user = (strpos(htmlspecialchars($_SESSION['roles']), 'user') !== FALSE ? TRUE : FALSE);
}
require_once('includes/config.php');
require_once("includes/navbar.php");
require_once('includes/functions.php');

ferror_log("RUNNING dashboard.php");

// Get database connection
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Get summary statistics
$stats = array();

// Compositions statistics
$sql = "SELECT 
    COUNT(*) as total_compositions,
    COUNT(CASE WHEN enabled = 1 THEN 1 END) as enabled_compositions,
    AVG(grade) as avg_grade,
    COUNT(CASE WHEN last_performance_date IS NOT NULL THEN 1 END) as performed_compositions
FROM compositions";
$res = mysqli_query($f_link, $sql);
$stats['compositions'] = mysqli_fetch_assoc($res);

// Parts statistics
$sql = "SELECT 
    COUNT(*) as total_parts,
    COUNT(DISTINCT catalog_number) as compositions_with_parts,
    AVG(page_count) as avg_page_count,
    SUM(originals_count) as total_originals,
    SUM(copies_count) as total_copies
FROM parts";
$res = mysqli_query($f_link, $sql);
$stats['parts'] = mysqli_fetch_assoc($res);

// Recordings statistics
$sql = "SELECT 
    COUNT(*) as total_recordings,
    COUNT(DISTINCT catalog_number) as recorded_compositions,
    COUNT(DISTINCT id_concert) as recording_sessions
FROM recordings WHERE 1=1";
$res = mysqli_query($f_link, $sql);
if ($res) {
    $stats['recordings'] = mysqli_fetch_assoc($res);
} else {
    $stats['recordings'] = array('total_recordings' => 0, 'recorded_compositions' => 0, 'recording_sessions' => 0);
}

// Concerts statistics  
$sql = "SELECT 
    COUNT(*) as total_concerts,
    COUNT(DISTINCT DATE(performance_date)) as concert_dates
FROM concerts WHERE 1=1";
$res = mysqli_query($f_link, $sql);
if ($res) {
    $stats['concerts'] = mysqli_fetch_assoc($res);
} else {
    $stats['concerts'] = array('total_concerts' => 0, 'concert_dates' => 0);
}

// Ensembles, Genres, Part Types statistics
$sql = "SELECT COUNT(*) as total FROM ensembles WHERE enabled = 1";
$res = mysqli_query($f_link, $sql);
$stats['ensembles'] = mysqli_fetch_assoc($res)['total'];

$sql = "SELECT COUNT(*) as total FROM genres WHERE enabled = 1";
$res = mysqli_query($f_link, $sql);
$stats['genres'] = mysqli_fetch_assoc($res)['total'];

$sql = "SELECT COUNT(*) as total FROM part_types WHERE enabled = 1";
$res = mysqli_query($f_link, $sql);
$stats['part_types'] = mysqli_fetch_assoc($res)['total'];

$sql = "SELECT COUNT(*) as total FROM instruments WHERE enabled = 1";
$res = mysqli_query($f_link, $sql);
$stats['instruments'] = mysqli_fetch_assoc($res)['total'];

// Get recent activity
$sql = "SELECT 
    c.catalog_number,
    c.name,
    c.composer,
    c.last_update,
    'composition' as type
FROM compositions c
ORDER BY c.last_update DESC
LIMIT 5";
$recent_activity = array();
$res = mysqli_query($f_link, $sql);
while ($row = mysqli_fetch_assoc($res)) {
    $recent_activity[] = $row;
}

// Get compositions by genre
$sql = "SELECT 
    g.name as genre_name,
    COUNT(c.catalog_number) as count
FROM genres g
LEFT JOIN compositions c ON g.id_genre = c.genre AND c.enabled = 1
WHERE g.enabled = 1
GROUP BY g.id_genre, g.name
ORDER BY count DESC
LIMIT 10";
$genre_stats = array();
$res = mysqli_query($f_link, $sql);
while ($row = mysqli_fetch_assoc($res)) {
    $genre_stats[] = $row;
}

// Get compositions by ensemble
$sql = "SELECT 
    e.name as ensemble_name,
    COUNT(c.catalog_number) as count
FROM ensembles e
LEFT JOIN compositions c ON e.id_ensemble = c.ensemble AND c.enabled = 1
WHERE e.enabled = 1
GROUP BY e.id_ensemble, e.name
ORDER BY count DESC
LIMIT 10";
$ensemble_stats = array();
$res = mysqli_query($f_link, $sql);
while ($row = mysqli_fetch_assoc($res)) {
    $ensemble_stats[] = $row;
}

// Get performance statistics by genre
$sql = "SELECT 
    g.name as genre_name,
    COUNT(DISTINCT r.id_recording) as recordings_count,
    COUNT(DISTINCT CONCAT(ci.id_concert, '-', pi.catalog_number)) as concert_performances,
    (COUNT(DISTINCT r.id_recording) + COUNT(DISTINCT CONCAT(ci.id_concert, '-', pi.catalog_number))) as total_performances
FROM genres g
LEFT JOIN compositions c ON g.id_genre = c.genre AND c.enabled = 1
LEFT JOIN recordings r ON c.catalog_number = r.catalog_number
LEFT JOIN playgram_items pi ON c.catalog_number = pi.catalog_number
LEFT JOIN playgrams p ON pi.id_playgram = p.id_playgram
LEFT JOIN concerts ci ON p.id_playgram = ci.id_playgram
WHERE g.enabled = 1
GROUP BY g.id_genre, g.name
HAVING total_performances > 0
ORDER BY total_performances DESC
LIMIT 10";
$performance_stats = array();
$res = mysqli_query($f_link, $sql);
while ($row = mysqli_fetch_assoc($res)) {
    $performance_stats[] = $row;
}

mysqli_close($f_link);
?>

<main role="main" class="container-fluid">
    <div class="container">
        <div class="row pb-3 pt-5 border-bottom">
            <div class="col">
                <h1><i class="fas fa-tachometer-alt"></i> <?php echo ORGNAME ?> Music Library Dashboard</h1>
                <p class="lead">Comprehensive overview of your music library database</p>
            </div>
        </div>

        <!-- Summary Statistics Cards -->
        <div class="row mt-4">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-primary">
                    <div class="card-body text-center">
                        <div class="card-title h5">
                            <i class="fas fa-music text-primary"></i> Compositions
                        </div>
                        <h2 class="display-4 text-primary"><?php echo number_format($stats['compositions']['total_compositions']); ?></h2>
                        <p class="text-muted">
                            <?php echo number_format($stats['compositions']['enabled_compositions']); ?> enabled<br>
                            Avg Grade: <?php echo round($stats['compositions']['avg_grade'], 1); ?><br>
                            <?php echo number_format($stats['compositions']['performed_compositions']); ?> performed
                        </p>
                        <a href="compositions.php" class="btn btn-primary btn-sm">View All</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-success">
                    <div class="card-body text-center">
                        <div class="card-title h5">
                            <i class="fas fa-puzzle-piece text-success"></i> Parts
                        </div>
                        <h2 class="display-4 text-success"><?php echo number_format($stats['parts']['total_parts']); ?></h2>
                        <p class="text-muted">
                            <?php echo number_format($stats['parts']['compositions_with_parts']); ?> compositions<br>
                            Avg Pages: <?php echo round($stats['parts']['avg_page_count'], 1); ?><br>
                            <?php echo number_format($stats['parts']['total_originals'] + $stats['parts']['total_copies']); ?> copies total
                        </p>
                        <a href="parts.php" class="btn btn-success btn-sm">View All</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-info">
                    <div class="card-body text-center">
                        <div class="card-title h5">
                            <i class="fas fa-microphone text-info"></i> Recordings
                        </div>
                        <h2 class="display-4 text-info"><?php echo number_format($stats['recordings']['total_recordings']); ?></h2>
                        <p class="text-muted">
                            <?php echo number_format($stats['recordings']['recorded_compositions']); ?> compositions<br>
                            <?php echo number_format($stats['recordings']['recording_sessions']); ?> sessions
                        </p>
                        <a href="recordings.php" class="btn btn-info btn-sm">View All</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-warning">
                    <div class="card-body text-center">
                        <div class="card-title h5">
                            <i class="fas fa-calendar-alt text-warning"></i> Concerts
                        </div>
                        <h2 class="display-4 text-warning"><?php echo number_format($stats['concerts']['total_concerts']); ?></h2>
                        <p class="text-muted">
                            <?php echo number_format($stats['concerts']['concert_dates']); ?> unique dates
                        </p>
                        <a href="concerts.php" class="btn btn-warning btn-sm">View All</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secondary Statistics -->
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-secondary">
                    <div class="card-body text-center">
                        <div class="card-title h6">
                            <i class="fas fa-users text-secondary"></i> Ensembles
                        </div>
                        <h4 class="text-secondary"><?php echo number_format($stats['ensembles']); ?></h4>
                        <a href="ensembles.php" class="btn btn-secondary btn-sm">Manage</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-secondary">
                    <div class="card-body text-center">
                        <div class="card-title h6">
                            <i class="fas fa-tags text-secondary"></i> Genres
                        </div>
                        <h4 class="text-secondary"><?php echo number_format($stats['genres']); ?></h4>
                        <a href="genres.php" class="btn btn-secondary btn-sm">Manage</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-secondary">
                    <div class="card-body text-center">
                        <div class="card-title h6">
                            <i class="fas fa-list text-secondary"></i> Part Types
                        </div>
                        <h4 class="text-secondary"><?php echo number_format($stats['part_types']); ?></h4>
                        <a href="parttypes.php" class="btn btn-secondary btn-sm">Manage</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-secondary">
                    <div class="card-body text-center">
                        <div class="card-title h6">
                            <i class="fas fa-guitar text-secondary"></i> Instruments
                        </div>
                        <h4 class="text-secondary"><?php echo number_format($stats['instruments']); ?></h4>
                        <a href="instruments.php" class="btn btn-secondary btn-sm">Manage</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Analysis -->
        <div class="row mt-4">
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-chart-pie"></i> Compositions by Genre</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($genre_stats)): ?>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Genre</th>
                                            <th class="text-end">Count</th>
                                            <th>Distribution</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $max_count = max(array_column($genre_stats, 'count'));
                                        foreach ($genre_stats as $genre): 
                                            $percentage = $max_count > 0 ? ($genre['count'] / $max_count) * 100 : 0;
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($genre['genre_name']); ?></td>
                                            <td class="text-end"><?php echo number_format($genre['count']); ?></td>
                                            <td>
                                                <div class="progress" style="height: 10px;">
                                                    <div class="progress-bar bg-primary" role="progressbar" 
                                                         style="width: <?php echo $percentage; ?>%" 
                                                         aria-valuenow="<?php echo $genre['count']; ?>" 
                                                         aria-valuemin="0" aria-valuemax="<?php echo $max_count; ?>"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">No genre data available</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-chart-bar"></i> Compositions by Ensemble</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($ensemble_stats)): ?>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Ensemble</th>
                                            <th class="text-end">Count</th>
                                            <th>Distribution</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $max_count = max(array_column($ensemble_stats, 'count'));
                                        foreach ($ensemble_stats as $ensemble): 
                                            $percentage = $max_count > 0 ? ($ensemble['count'] / $max_count) * 100 : 0;
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($ensemble['ensemble_name']); ?></td>
                                            <td class="text-end"><?php echo number_format($ensemble['count']); ?></td>
                                            <td>
                                                <div class="progress" style="height: 10px;">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                         style="width: <?php echo $percentage; ?>%" 
                                                         aria-valuenow="<?php echo $ensemble['count']; ?>" 
                                                         aria-valuemin="0" aria-valuemax="<?php echo $max_count; ?>"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">No ensemble data available</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Analysis -->
        <div class="row mt-4">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-chart-line"></i> Performance activity by genre</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($performance_stats)): ?>
                            <div class="row">
                                <div class="col-lg-8">
                                    <!-- Bar Chart -->
                                    <div class="chart-container" style="position: relative; height: 400px;">
                                        <canvas id="performanceChart"></canvas>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <!-- Performance Statistics Table -->
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Genre</th>
                                                    <th class="text-center">Recordings</th>
                                                    <th class="text-center">Concerts</th>
                                                    <th class="text-center">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($performance_stats as $stat): ?>
                                                <tr>
                                                    <td><small><?php echo htmlspecialchars($stat['genre_name']); ?></small></td>
                                                    <td class="text-center">
                                                        <span class="badge bg-info"><?php echo $stat['recordings_count']; ?></span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-warning"><?php echo $stat['concert_performances']; ?></span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-success"><?php echo $stat['total_performances']; ?></span>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-3">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle"></i> Shows recordings and concert performances by genre. 
                                            This helps identify which genres are most actively performed.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No performance data available yet.</p>
                                <small>Performance data will appear when recordings or concerts are added to the system.</small>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-clock"></i> Recent activity</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($recent_activity)): ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($recent_activity as $activity): ?>
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><?php echo htmlspecialchars($activity['name']); ?></h6>
                                        <small><?php echo date('M j, Y', strtotime($activity['last_update'])); ?></small>
                                    </div>
                                    <p class="mb-1">
                                        <strong><?php echo htmlspecialchars($activity['catalog_number']); ?></strong>
                                        <?php if ($activity['composer']): ?>
                                        - <?php echo htmlspecialchars($activity['composer']); ?>
                                        <?php endif; ?>
                                    </p>
                                    <small class="text-muted">Updated <?php echo ucfirst($activity['type']); ?></small>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">No recent activity</p>
                        <?php endif; ?>
                        <div class="mt-3">
                            <a href="compositions.php" class="btn btn-outline-primary btn-sm">View All Compositions</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-tools"></i> Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <?php if($u_librarian): ?>
                            <div class="col-md-6">
                                <a href="compositions.php" class="btn btn-primary w-100">
                                    <i class="fas fa-plus"></i> Add Composition
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="parts.php" class="btn btn-success w-100">
                                    <i class="fas fa-file-alt"></i> Manage Parts
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="recordings.php" class="btn btn-info w-100">
                                    <i class="fas fa-microphone"></i> Add Recording
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="concerts.php" class="btn btn-warning w-100">
                                    <i class="fas fa-calendar-plus"></i> Add Concert
                                </a>
                            </div>
                            <?php endif; ?>
                            <div class="col-md-6">
                                <a href="search.php" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-search"></i> Search Library
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="reports.php" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-chart-line"></i> View Reports
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Database Connections Overview -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-sitemap"></i> Database relationships</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-2 mb-3">
                                <div class="border rounded p-3 h-100">
                                    <i class="fas fa-music fa-2x text-primary mb-2"></i>
                                    <h6>Compositions</h6>
                                    <small class="text-muted">Core repertoire</small>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="border rounded p-3 h-100">
                                    <i class="fas fa-puzzle-piece fa-2x text-success mb-2"></i>
                                    <h6>Parts</h6>
                                    <small class="text-muted">Individual instrument parts</small>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="border rounded p-3 h-100">
                                    <i class="fas fa-users fa-2x text-info mb-2"></i>
                                    <h6>Ensembles</h6>
                                    <small class="text-muted">Performing groups</small>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="border rounded p-3 h-100">
                                    <i class="fas fa-microphone fa-2x text-warning mb-2"></i>
                                    <h6>Recordings</h6>
                                    <small class="text-muted">Audio/video captures</small>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="border rounded p-3 h-100">
                                    <i class="fas fa-calendar-alt fa-2x text-danger mb-2"></i>
                                    <h6>Concerts</h6>
                                    <small class="text-muted">Performance events</small>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="border rounded p-3 h-100">
                                    <i class="fas fa-tags fa-2x text-secondary mb-2"></i>
                                    <h6>Metadata</h6>
                                    <small class="text-muted">Genres, instruments, etc.</small>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                All components are interconnected: Compositions contain Parts, are performed by Ensembles at Concerts, 
                                and captured in Recordings, all categorized by Genres and other metadata.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<?php require_once("includes/footer.php");?>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(document).ready(function(){
    // Dashboard loaded
    console.log("Dashboard loaded");
    
    <?php if (!empty($performance_stats)): ?>
    // Performance Chart by Genre
    const performanceCtx = document.getElementById('performanceChart').getContext('2d');
    const performanceChart = new Chart(performanceCtx, {
        type: 'bar',
        data: {
            labels: [
                <?php foreach ($performance_stats as $stat): ?>
                '<?php echo addslashes($stat['genre_name']); ?>',
                <?php endforeach; ?>
            ],
            datasets: [{
                label: 'Recordings',
                data: [
                    <?php foreach ($performance_stats as $stat): ?>
                    <?php echo $stat['recordings_count']; ?>,
                    <?php endforeach; ?>
                ],
                backgroundColor: 'rgba(13, 202, 240, 0.7)',
                borderColor: 'rgba(13, 202, 240, 1)',
                borderWidth: 1
            }, {
                label: 'Concert Performances',
                data: [
                    <?php foreach ($performance_stats as $stat): ?>
                    <?php echo $stat['concert_performances']; ?>,
                    <?php endforeach; ?>
                ],
                backgroundColor: 'rgba(255, 193, 7, 0.7)',
                borderColor: 'rgba(255, 193, 7, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Performance activity by genre',
                    font: {
                        size: 16
                    }
                },
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    },
                    title: {
                        display: true,
                        text: 'Number of performances'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Genre'
                    },
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
    <?php endif; ?>
});
</script>

</body>
</html>
