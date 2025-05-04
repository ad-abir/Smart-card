<?php
session_start(); // Start the session

// Check for and prepare error message from session
$error = null;
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']); // Clear the error after retrieving it
}

// Load the view
require BASE_PATH . '/views/login.php';