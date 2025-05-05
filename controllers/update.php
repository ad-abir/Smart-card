<?php
session_start(); // Ensure session is started
require_once __DIR__ . '/../services/auth_check.php';
requireLogin();

// Include the view
include __DIR__ . '/../views/update_profile.php';
?>