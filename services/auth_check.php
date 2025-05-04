<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection file
require_once('dbcon.php');

function requireLogin() {
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header("Location: /signin");
        exit();
    }
}

function redirectWithMessage($page, $type, $message) {
    $_SESSION[$type] = $message;
    header("Location: $page");
    exit();
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    // Basic validation
    if (empty($email)) {
        redirectWithMessage('/signin', 'error', 'Email address is required');
    }
    
    if (empty($password)) {
        redirectWithMessage('/signin', 'error', 'Password is required');
    }
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        redirectWithMessage('/signin', 'error', 'Invalid email format');
    }
    
    try {
        // Prepare and execute query using the existing mysqli connection
        $stmt = mysqli_prepare($con, "SELECT id, email, name, password FROM regis_users WHERE email = ?");
        
        if (!$stmt) {
            throw new Exception("Query preparation failed: " . mysqli_error($con));
        }
        
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        
        // Get the result
        $result = mysqli_stmt_get_result($stmt);
        
        if ($result && $user = mysqli_fetch_assoc($result)) {
            // Verify password (assuming passwords are hashed with password_hash())
            if (password_verify($password, $user['password'])) {
                // Login successful - set session variables
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['name'] ?? 'User'; // Fallback if name is null
                
                // Set success message
                redirectWithMessage('/dashboard', 'success', 'Login successful! Welcome back.');
            } else {
                // Password is incorrect
                redirectWithMessage('/signin', 'error', 'Invalid email or password');
            }
        } else {
            // User not found
            redirectWithMessage('/signin', 'error', 'This email is not registered.');
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
    } catch (Exception $e) {
        // Log the error for administrators
        error_log("Login error: " . $e->getMessage());
        
        // Display generic error to user
        redirectWithMessage('/signin', 'error', 'An error occurred during login. Please try again later.');
    }
}
?>