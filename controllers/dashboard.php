<?php
session_start(); // Ensure session is started
require_once __DIR__ . '/../services/auth_check.php';
requireLogin();

$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest'; // Fallback to 'Guest' if not set

// Include the view
include __DIR__ . '/../views/landing.php';
?>