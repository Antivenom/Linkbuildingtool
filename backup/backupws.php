<?php

require_once '../config.php';

// Make sure the script can handle large folders/files
ini_set('max_execution_time', 600);
ini_set('memory_limit','1024M');

// Start the backup!
$backup->website('../', 'website/backup.zip');

echo 'Finished.';