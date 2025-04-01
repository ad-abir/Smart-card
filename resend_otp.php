<?php
session_start();
include('dbcon.php');
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Import the email sending function
require_once 'email.php';

header('Content-Type: application/json');

if(!isset($_SESSION['email'])) {
    echo json_encode(['status' => 'error', 'message' => 'Session expired. Please restart the password reset process.']);
    exit();
}

$email = $_SESSION['email'];

// Get user information
$user_query = "SELECT * FROM user WHERE email='$email'";
$user_result = mysqli_query($con, $user_query);

if(mysqli_num_rows($user_result) > 0) {
    $user_data = mysqli_fetch_assoc($user_result);
    $name = $user_data['name'];
    
    // Generate new verification code
    $verify_token = rand(100000, 999999);
    
    // Set expiration time (2 minutes from now)
    date_default_timezone_set('Asia/Dhaka'); // Adjust timezone as needed
    $token_expires_at = date('Y-m-d H:i:s', strtotime('+2 minutes'));
    
    // Update user table with new verification token
    $update_query = "UPDATE user SET verify_token='$verify_token', token_expires_at='$token_expires_at' WHERE email='$email'";
    $update_result = mysqli_query($con, $update_query);
    
    if($update_result) {
        // Send verification email
        if(sendemail_verify($name, $email, $verify_token)) {
            echo json_encode(['status' => 'success', 'message' => 'New verification code sent to your email']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send verification email']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update verification code']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'User not found']);
}
?>