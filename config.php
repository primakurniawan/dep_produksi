<?php

/**
 * using mysqli_connect for database connection
 */

$databaseHost = 'localhost';
$databaseName = 'dep_produksi';
$databaseUsername = 'root';
$databasePassword = '';

$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);
