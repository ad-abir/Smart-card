<?php
require_once __DIR__ . '/config.php';

try {
    $con = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);

    if (!$con) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
