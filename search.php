<?php
define('PAGE_TITLE', 'Search the music library');
define('PAGE_NAME', 'search');
require_once("includes/header.php");

// User permissions
$u_admin = FALSE;
$u_librarian = FALSE;
$u_user = FALSE;
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $u_admin = (strpos(htmlspecialchars($_SESSION['roles']), 'administrator') !== FALSE ? TRUE : FALSE);
    $u_librarian = (strpos(htmlspecialchars($_SESSION['roles']), 'librarian') !== FALSE ? TRUE : FALSE);
    $u_user = (strpos(htmlspecialchars($_SESSION['roles']), 'user') !== FALSE ? TRUE : FALSE);
}
require_once("includes/config.php");
require_once("includes/navbar.php");
require_once("includes/functions.php");
ferror_log("RUNNING search.php");
?>

<main role="main" class="container-fluid">
    <div class="container">
        <div class="row pb-3 pt-5 border-bottom">
            <div class="col">
                <h1><i class="fas fa-search"></i> Search the music library</h1>
                <p class="lead">Find compositions using advanced search filters</p>
            </div>
        </div>

        <!-- Search Form -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-filter"></i> Search filters</h5>
                    </div>
                    <div class="card-body">
                        <!-- Search Bar -->
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="search_text" class="form-label">Search text</label>
                                <input type="text" class="form-control" id="search_text" 
                                       placeholder="Search by title, composer, arranger, or catalog number...">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">&nbsp;</label>
                                <div>
                                    <button type="button" class="btn btn-primary" id="search_btn">
                                        <i class="fas fa-search"></i> Search
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" id="clear_btn">
                                        <i class="fas fa-times"></i> Clear
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Row 1 -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="genre_filter" class="form-label">Genre</label>
                                <select class="form-select" id="genre_filter">
                                    <option value="">All genres</option>
                                    <?php
                                    $f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                                    $sql = "SELECT id_genre, name FROM genres WHERE enabled = 1 ORDER BY name";
                                    $res = mysqli_query($f_link, $sql);
                                    while ($row = mysqli_fetch_array($res)) {
                                        echo '<option value="' . $row['id_genre'] . '">' . htmlspecialchars($row['name']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="ensemble_filter" class="form-label">Ensemble</label>
                                <select class="form-select" id="ensemble_filter">
                                    <option value="">All ensembles</option>
                                    <?php
                                    $sql = "SELECT id_ensemble, name FROM ensembles WHERE enabled = 1 ORDER BY name";
                                    $res = mysqli_query($f_link, $sql);
                                    while ($row = mysqli_fetch_array($res)) {
                                        echo '<option value="' . $row['id_ensemble'] . '">' . htmlspecialchars($row['name']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="grade_filter" class="form-label">Grade level</label>
                                <select class="form-select" id="grade_filter">
                                    <option value="">All grades</option>
                                    <option value="1">Grade 1</option>
                                    <option value="2">Grade 2</option>
                                    <option value="3">Grade 3</option>
                                    <option value="4">Grade 4</option>
                                    <option value="5">Grade 5</option>
                                    <option value="6">Grade 6</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="duration_filter" class="form-label">Duration</label>
                                <select class="form-select" id="duration_filter">
                                    <option value="">Any duration</option>
                                    <option value="short">Short (0-3 min)</option>
                                    <option value="medium">Medium (3-8 min)</option>
                                    <option value="long">Long (8+ min)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5><i class="fas fa-list"></i> Search results</h5>
                        <span class="badge bg-secondary" id="results_count">Click search to see results</span>
                    </div>
                    <div class="card-body">
                        <div id="results_container">
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-search fa-3x mb-3"></i>
                                <p>Use the search filters above to find compositions</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Library Navigation -->
        <div class="row mt-5">
            <div class="col-12">
                <h3>Browse library sections</h3>
            </div>
        </div>
        
        <div class="row g-3">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-music fa-2x text-primary mb-2"></i>
                        <h6>Compositions</h6>
                        <a href="compositions.php" class="btn btn-sm btn-primary">Browse</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-puzzle-piece fa-2x text-success mb-2"></i>
                        <h6>Parts</h6>
                        <a href="parts.php" class="btn btn-sm btn-success">Browse</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-list-ol fa-2x text-info mb-2"></i>
                        <h6>Playgrams</h6>
                        <a href="playgrams.php" class="btn btn-sm btn-info">Browse</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-microphone fa-2x text-warning mb-2"></i>
                        <h6>Recordings</h6>
                        <a href="recordings.php" class="btn btn-sm btn-warning">Browse</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<?php 
mysqli_close($f_link);
require_once("includes/footer.php"); 
?>

<script>
$(document).ready(function() {
    // Search button click
    $('#search_btn').click(function() {
        performSearch();
    });
    
    // Clear button click
    $('#clear_btn').click(function() {
        $('#search_text').val('');
        $('#genre_filter').val('');
        $('#ensemble_filter').val('');
        $('#grade_filter').val('');
        $('#duration_filter').val('');
        $('#results_container').html(`
            <div class="text-center text-muted py-4">
                <i class="fas fa-search fa-3x mb-3"></i>
                <p>Use the search filters above to find compositions</p>
            </div>
        `);
        $('#results_count').text('Click search to see results');
    });
    
    // Enter key in search box
    $('#search_text').keypress(function(e) {
        if (e.which == 13) {
            performSearch();
        }
    });
    
    function performSearch() {
        const searchData = {
            search: $('#search_text').val(),
            genre: $('#genre_filter').val(),
            ensemble: $('#ensemble_filter').val(),
            grade: $('#grade_filter').val(),
            duration: $('#duration_filter').val()
        };
        
        // Show loading
        $('#results_container').html(`
            <div class="text-center py-4">
                <i class="fas fa-spinner fa-spin fa-2x mb-3"></i>
                <p>Searching...</p>
            </div>
        `);
        
        // Perform AJAX search
        $.ajax({
            url: 'includes/search_compositions.php',
            method: 'POST',
            data: searchData,
            dataType: 'json',
            success: function(response) {
                displayResults(response);
            },
            error: function() {
                $('#results_container').html(`
                    <div class="text-center text-danger py-4">
                        <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                        <p>Error performing search. Please try again.</p>
                    </div>
                `);
            }
        });
    }
    
    function displayResults(data) {
        if (data.length === 0) {
            $('#results_container').html(`
                <div class="text-center text-muted py-4">
                    <i class="fas fa-search fa-2x mb-3"></i>
                    <p>No compositions found matching your criteria</p>
                </div>
            `);
            $('#results_count').text('0 compositions found');
            return;
        }
        
        let html = `
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Title</th>
                            <th>Composer</th>
                            <th>Genre</th>
                            <th>Grade</th>
                            <th>Duration</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
        `;
        
        data.forEach(function(comp) {
            const duration = comp.duration ? Math.round(comp.duration / 60) + 'm' : 'Unknown';
            const grade = comp.grade || 'N/A';
            
            html += `
                <tr>
                    <td>
                        <strong>${comp.name}</strong><br>
                        <small class="text-muted">${comp.catalog_number}</small>
                    </td>
                    <td>
                        ${comp.composer || 'Unknown'}
                        ${comp.arranger ? '<br><small class="text-muted">arr. ' + comp.arranger + '</small>' : ''}
                    </td>
                    <td><span class="badge bg-light text-dark">${comp.genre_name || 'Unknown'}</span></td>
                    <td><span class="badge bg-primary">${grade}</span></td>
                    <td>${duration}</td>
                    <td>
                        <a href="compositions.php?catalog=${comp.catalog_number}" class="btn btn-sm btn-outline-primary" target="_blank">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="parts.php?catalog=${comp.catalog_number}" class="btn btn-sm btn-outline-success" target="_blank">
                            <i class="fas fa-puzzle-piece"></i> Parts
                        </a>
                    </td>
                </tr>
            `;
        });
        
        html += `
                    </tbody>
                </table>
            </div>
        `;
        
        $('#results_container').html(html);
        $('#results_count').text(`${data.length} composition${data.length !== 1 ? 's' : ''} found`);
    }
});
</script>

</body>
</html>