<?php

include '../class/backupdb.class.php';

try {
    $databaseDumper = Shuttle_Dumper::create(array(
        'host' => 'localhost',
        'username' => 'root',
        'password' => 'root',
        'db_name' => 'site',
    ));

    $databaseDumper->dump('database/database.sql');

    echo 'Finished.';
} catch(Shuttle_Exception $e) {
    echo "Couldn't dump database: " . $e->getMessage();
}