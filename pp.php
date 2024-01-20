<?php
$dir = 'files/';

// Initialize archive object
$zip = new ZipArchive();
$zip_name = time() . ".zip"; // Zip name
$zip->open($zip_name, ZipArchive::CREATE);

// Create recursive directory iterator
/** @var SplFileInfo[] $files */
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::LEAVES_ONLY);

foreach ($files as $name => $file) {
    // Skip directories (they would be added automatically)
    if (!$file->isDir()) {
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($dir) + 1);

        // Add current file to archive
        $zip->addFile($filePath, $relativePath);
    }
}

// Zip archive will be created only after closing object
$zip->close();

//then prompt user to download the zip file
header('Content-Type: application/zip');
header('Content-disposition: attachment; filename=' . $zip_name);
header('Content-Length: ' . filesize($zip_name));
readfile($zip_name);

//cleanup the zip file
unlink($zip_name);

?>