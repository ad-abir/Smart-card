<?php

require_once __DIR__ . '/../services/session.php';
startSession(); // Ensure session is started

require_once __DIR__ . '/../services/auth_check.php';
requireLogin();

// Include the view
include __DIR__ . '/../views/update_profile.php';
?>