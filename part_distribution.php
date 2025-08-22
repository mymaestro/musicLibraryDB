<?php
define('PAGE_TITLE', 'Part Distribution for Concert Series');
define('PAGE_NAME', 'Part Distribution');
require_once(__DIR__ . "/includes/header.php");
$u_admin = FALSE;
$u_librarian = FALSE;
$u_user = FALSE;
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $u_admin = (strpos(htmlspecialchars($_SESSION['roles']), 'administrator') !== FALSE ? TRUE : FALSE);
    $u_librarian = (strpos(htmlspecialchars($_SESSION['roles']), 'librarian') !== FALSE ? TRUE : FALSE);
    $u_user = (strpos(htmlspecialchars($_SESSION['roles']), 'user') !== FALSE ? TRUE : FALSE);
}
require_once(__DIR__ . "/includes/config.php");
require_once(__DIR__ . "/includes/navbar.php");
require_once(__DIR__ . "/includes/functions.php");
ferror_log("Running part_distribution.php");

// Check if user has permission
if (!$u_librarian && !$u_admin) {
    echo '<main role="main" class="container"><div class="alert alert-danger">Access denied.</div></main>';
    require_once(__DIR__ . "/includes/footer.php");
    exit;
}

ferror_log("RUNNING part_distribution.php");

// Get database connection
$f_link = f_sqlConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Get all enabled playgrams
$sql = "SELECT id_playgram, name, description FROM playgrams WHERE enabled = 1 ORDER BY name";
$playgrams_result = mysqli_query($f_link, $sql);
$playgrams = [];
while($row = mysqli_fetch_assoc($playgrams_result)) {
    $playgrams[] = $row;
}

// Get all sections
$sql = "SELECT id_section, name, description FROM sections WHERE enabled = 1 ORDER BY name";
$sections_result = mysqli_query($f_link, $sql);
$sections = [];
while($row = mysqli_fetch_assoc($sections_result)) {
    $sections[] = $row;
}

mysqli_close($f_link);
?>

<main role="main" class="container-fluid">
    <div class="container">
        <div class="row pb-3 pt-5 border-bottom">
            <div class="col">
                <h1><i class="fas fa-file-archive"></i> <?php echo ORGNAME; ?> part distribution for Concert Series</h1>
                <p class="lead">Generate ZIP files containing PDF parts organized by section for concert distribution</p>
            </div>
        </div>

        <!-- Playgram Selection -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-list"></i> Select concert program (Playgram)</h5>
                    </div>
                    <div class="card-body">
                        <form id="playgram-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="playgram_select" class="form-label">Choose Playgram:</label>
                                    <select class="form-select" id="playgram_select" name="playgram_id" required>
                                        <option value="">-- Select a Concert Program --</option>
                                        <?php foreach($playgrams as $playgram): ?>
                                        <option value="<?php echo $playgram['id_playgram']; ?>">
                                            <?php echo htmlspecialchars($playgram['name']); ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <button type="button" id="load_playgram" class="btn btn-primary me-2">
                                        <i class="fas fa-search"></i> Load program details
                                    </button>
                                    <button type="button" id="generate_all" class="btn btn-success" disabled>
                                        <i class="fas fa-file-archive"></i> Generate all section ZIPs
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Playgram Details -->
        <div class="row mt-4" id="playgram_details" style="display: none;">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-music"></i> Program Compositions</h5>
                    </div>
                    <div class="card-body">
                        <div id="compositions_list">
                            <!-- Will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sections and Parts Distribution -->
        <div class="row mt-4" id="sections_distribution" style="display: none;">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-users"></i> Parts distribution by section</h5>
                        <small class="text-muted">Generate ZIP files for each section containing renamed PDF parts</small>
                    </div>
                    <div class="card-body">
                        <div class="row" id="sections_grid">
                            <!-- Will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress and Results -->
        <div class="row mt-4" id="generation_progress" style="display: none;">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-spinner"></i> Generation progress</h5>
                    </div>
                    <div class="card-body">
                        <div class="progress mb-3">
                            <div class="progress-bar" role="progressbar" style="width: 0%" id="progress_bar">0%</div>
                        </div>
                        <div id="progress_log">
                            <!-- Progress messages will appear here -->
                        </div>
                        <div id="download_links" style="display: none;">
                            <h6>Generated ZIP Files:</h6>
                            <ul id="zip_files_list">
                                <!-- Download links will appear here -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Help and Instructions -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-info">
                    <div class="card-header bg-info text-white">
                        <h6><i class="fas fa-info-circle"></i> How Part Distribution Works</h6>
                    </div>
                    <div class="card-body">
                        <ol>
                            <li><strong>Select a Playgram:</strong> Choose the concert program containing the compositions you want to distribute.</li>
                            <li><strong>Review compositions:</strong> The system will show all compositions in the playgram and their available parts.</li>
                            <li><strong>Generate ZIP files:</strong> For each section (Woodwinds, Brass, Percussion, etc.), a ZIP file will be created containing:</li>
                            <ul>
                                <li>All PDF parts for that section across all compositions in the playgram</li>
                                <li>Files renamed as: <code>[Order] - [Composition Name] - [Part Name].pdf</code></li>
                                <li>Example: <code>01 - March Grandioso - Flute 1.pdf</code></li>
                            </ul>
                            <li><strong>Download and distribute:</strong> Section leaders can download their ZIP file and distribute individual PDFs to musicians.</li>
                        </ol>
                        <div class="alert alert-warning mt-3">
                            <strong>Note:</strong> Only parts with PDF files (image_path) will be included. Missing PDFs will be noted in the generation log.
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<?php require_once(__DIR__ . "/includes/footer.php"); ?>

<script>
$(document).ready(function() {
    let currentPlaygramId = null;
    let playgramData = null;

    // Load playgram details when selected
    $('#load_playgram').on('click', function() {
        const playgramId = $('#playgram_select').val();
        if (!playgramId) {
            alert('Please select a playgram first.');
            return;
        }

        currentPlaygramId = playgramId;
        
        $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Loading...');

        $.ajax({
            url: 'includes/fetch_playgram_distribution.php',
            method: 'POST',
            data: {
                action: 'load_playgram',
                playgram_id: playgramId
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    playgramData = response.data;
                    displayPlaygramDetails(response.data);
                    displaySectionsDistribution(response.data);
                    $('#generate_all').prop('disabled', false);
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
                alert('Error loading playgram data. Please try again.');
            },
            complete: function() {
                $('#load_playgram').prop('disabled', false).html('<i class="fas fa-search"></i> Load Program Details');
            }
        });
    });

    // Generate all section ZIP files
    $('#generate_all').on('click', function() {
        if (!currentPlaygramId || !playgramData) {
            alert('Please load a playgram first.');
            return;
        }

        $(this).prop('disabled', true);
        $('#generation_progress').show();
        $('#progress_bar').css('width', '0%').text('0%');
        $('#progress_log').html('<p class="text-info"><i class="fas fa-spinner fa-spin"></i> Starting generation process...</p>');
        $('#download_links').hide();

        $.ajax({
            url: 'includes/fetch_playgram_distribution.php',
            method: 'POST',
            data: {
                action: 'generate_zips',
                playgram_id: currentPlaygramId
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#progress_bar').css('width', '100%').text('100%');
                    $('#progress_log').append('<p class="text-success"><i class="fas fa-check"></i> Generation completed successfully!</p>');
                    
                    // Display download links
                    let linksHtml = '';
                    response.data.zip_files.forEach(function(zipFile) {
                        linksHtml += '<li><a href="' + zipFile.url + '" class="btn btn-outline-primary btn-sm me-2 mb-2" download>' +
                                   '<i class="fas fa-download"></i> ' + zipFile.section_name + ' (' + zipFile.part_count + ' parts)</a></li>';
                    });
                    $('#zip_files_list').html(linksHtml);
                    $('#download_links').show();

                    // Show generation log
                    if (response.data.log && response.data.log.length > 0) {
                        $('#progress_log').append('<div class="mt-3"><h6>Generation Details:</h6><ul class="text-muted small">');
                        response.data.log.forEach(function(logEntry) {
                            $('#progress_log').append('<li>' + logEntry + '</li>');
                        });
                        $('#progress_log').append('</ul></div>');
                    }
                } else {
                    $('#progress_log').append('<p class="text-danger"><i class="fas fa-exclamation-triangle"></i> Error: ' + response.message + '</p>');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
                $('#progress_log').append('<p class="text-danger"><i class="fas fa-exclamation-triangle"></i> Error generating ZIP files. Please try again.</p>');
            },
            complete: function() {
                $('#generate_all').prop('disabled', false);
            }
        });
    });

    function displayPlaygramDetails(data) {
        let html = '<div class="table-responsive"><table class="table table-striped">';
        html += '<thead><tr><th>Order</th><th>Composition</th><th>Composer</th><th>Available Parts</th><th>Missing PDFs</th></tr></thead><tbody>';
        
        data.compositions.forEach(function(comp) {
            html += '<tr>';
            html += '<td><span class="badge bg-primary">' + comp.comp_order + '</span></td>';
            html += '<td><strong>' + comp.composition_name + '</strong></td>';
            html += '<td>' + (comp.composer || 'Unknown') + '</td>';
            html += '<td><span class="badge bg-success">' + comp.parts_with_pdf + '</span></td>';
            html += '<td>' + (comp.parts_without_pdf > 0 ? '<span class="badge bg-warning">' + comp.parts_without_pdf + '</span>' : '-') + '</td>';
            html += '</tr>';
        });
        
        html += '</tbody></table></div>';
        $('#compositions_list').html(html);
        $('#playgram_details').show();
    }

    function displaySectionsDistribution(data) {
        let html = '';
        
        data.sections.forEach(function(section) {
            html += '<div class="col-md-6 col-lg-4 mb-3">';
            html += '<div class="card border-info">';
            html += '<div class="card-header bg-light">';
            html += '<h6 class="mb-0"><i class="fas fa-users"></i> ' + section.section_name + '</h6>';
            html += '</div>';
            html += '<div class="card-body">';
            html += '<p class="card-text"><strong>' + section.total_parts + '</strong> parts across all compositions</p>';
            if (section.parts_with_pdf > 0) {
                html += '<p class="text-success small"><i class="fas fa-file-pdf"></i> ' + section.parts_with_pdf + ' parts have PDF files</p>';
            }
            if (section.parts_without_pdf > 0) {
                html += '<p class="text-warning small"><i class="fas fa-exclamation-triangle"></i> ' + section.parts_without_pdf + ' parts missing PDFs</p>';
            }
            html += '<button type="button" class="btn btn-outline-info btn-sm generate-section" data-section-id="' + section.id_section + '">';
            html += '<i class="fas fa-file-archive"></i> Generate ZIP</button>';
            html += '</div></div></div>';
        });
        
        $('#sections_grid').html(html);
        $('#sections_distribution').show();
    }

    // Handle individual section ZIP generation
    $(document).on('click', '.generate-section', function() {
        const sectionId = $(this).data('section-id');
        const button = $(this);
        
        button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Generating...');
        
        $.ajax({
            url: 'includes/fetch_playgram_distribution.php',
            method: 'POST',
            data: {
                action: 'generate_section_zip',
                playgram_id: currentPlaygramId,
                section_id: sectionId
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Create download link
                    const link = $('<a>').attr({
                        href: response.data.zip_url,
                        download: response.data.filename,
                        class: 'btn btn-success btn-sm'
                    }).html('<i class="fas fa-download"></i> Download ZIP');
                    
                    button.replaceWith(link);
                } else {
                    alert('Error: ' + response.message);
                    button.prop('disabled', false).html('<i class="fas fa-file-archive"></i> Generate ZIP');
                }
            },
            error: function() {
                alert('Error generating ZIP file. Please try again.');
                button.prop('disabled', false).html('<i class="fas fa-file-archive"></i> Generate ZIP');
            }
        });
    });
});
</script>

</body>
</html>
