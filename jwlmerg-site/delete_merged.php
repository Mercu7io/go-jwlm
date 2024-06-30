<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mergedFilePath = $_POST['mergedFilePath'];
    if (file_exists($mergedFilePath)) {
        unlink($mergedFilePath);
        $output = 'Merged file has been deleted.';
    } else {
        $output = 'File not found.';
    }
    header("Location: index.php?output=" . urlencode($output));
    exit;
}
?>
