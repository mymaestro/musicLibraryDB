<?php
// extract_pdf_metadata.php
// Usage: php extract_pdf_metadata.php /path/to/file.pdf

require_once(__DIR__ . '/../PHPdfer/PHPdfer.php');

if ($argc < 2) {
    fwrite(STDERR, "Usage: php extract_pdf_metadata.php /path/to/file.pdf\n");
    exit(1);
}

$pdf_path = $argv[1];
if (!file_exists($pdf_path)) {
    fwrite(STDERR, "File not found: $pdf_path\n");
    exit(1);
}

$pdf = new PHPdfer($pdf_path);
$data = $pdf->getData(); // Returns raw PDFtk dump_data output

// Parse the metadata fields
$metadata = [];
foreach (explode("\n", $data) as $line) {
    if (preg_match('/^InfoKey: (.+)$/', $line, $m)) {
        $key = $m[1];
        $metadata[$key] = '';
        $last_key = $key;
    } elseif (preg_match('/^InfoValue: (.*)$/', $line, $m) && isset($last_key)) {
        $metadata[$last_key] = $m[1];
    }
}

// Print metadata as key: value
foreach ($metadata as $key => $value) {
    echo "$key: $value\n";
}
