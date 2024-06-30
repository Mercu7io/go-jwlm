<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    if (isset($_POST['lang'])) {
      $lang = $_POST['lang'];
    } else {
        $lang = 'en';
    }
    

    $file1 = $_FILES['file1'];
    $file2 = $_FILES['file2'];
    
    $options= $_POST['options'];
    $mergeopt = json_decode($options, true);
    $keys = array_keys($mergeopt);
   

    $uploadFile1 = $uploadDir . basename($file1['name']);
    $uploadFile2 = $uploadDir . basename($file2['name']);
    $uniqueId = uniqid();
    $mergedFilePath = $uploadDir . 'merged_' . $uniqueId . '.jwlibrary';

    if (move_uploaded_file($file1['tmp_name'], $uploadFile1) && move_uploaded_file($file2['tmp_name'], $uploadFile2)) {
        // Command to merge files
        $command = "./go-jwlm merge " . escapeshellarg($uploadFile1) . " " . escapeshellarg($uploadFile2) . " " . escapeshellarg($mergedFilePath) . " --skipPlaylists --bookmarks " .  $mergeopt['bookmarks'] ." --inputFields " .  $mergeopt['inputFields'] ." --markings " .  $mergeopt['highlight'] ." --notes " .  $mergeopt['notes'] ."";
        
        
        // Execute the command and capture the output
        $output = [];
        $returnVar = 0;
        exec($command, $output, $returnVar);

        // Prepare output message
        $mergeOutput = implode("\n", $output);
        if ($returnVar === 0) {
            $mergeOutput = "Files have been successfully merged.\n" . $mergeOutput ;
        } else {
            $mergeOutput = "Error occurred during file merge.\n" . $mergeOutput;
        }

        // Clean up uploaded files after merging
        unlink($uploadFile1);
        unlink($uploadFile2);

        // Redirect to index.php with results
        header("Location: index.php?lang=". urlencode($lang) ."&output=" . urlencode($mergeOutput) . "&mergedFilePath=" . urlencode($mergedFilePath));
        exit;
    } else {
        $output = 'File upload failed.' ;
        header("Location: index.php?lang=". urlencode($lang) ."&output=" . urlencode($output));
        exit;
    }

}

?>
