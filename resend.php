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

function sendemail_verify($name, $email, $verify_token) {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPAuth   = true;
    
    $mail->Host       = $_ENV['MAIL_HOST'];
    $mail->Username   = $_ENV['MAIL_USERNAME'];
    $mail->Password   = $_ENV['MAIL_PASSWORD'];
    
    $mail->SMTPSecure = "tls";
    $mail->Port       = 587;
    
    $mail->setFrom($_ENV['MAIL_FROM_ADDRESS'], $name);
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Email Verification';

    $email_template = "
    <div style='
        font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        max-width: 600px;
        margin: 0 auto;
        padding: 40px 20px;
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e9f2 100%);
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    '>
        <div style='
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        '>
            <h2 style='
                color: #1a1a1a;
                font-size: 24px;
                font-weight: 600;
                margin-bottom: 24px;
                line-height: 1.3;
            '>New Verification Code</h2>
            
            <p style='
                color: #4a4a4a;
                font-size: 16px;
                line-height: 1.6;
                margin-bottom: 24px;
            '>Here is your new verification code. This code will expire in 2 minutes:</p>
            
            <div style='
                background: #f8f9fa;
                border: 2px dashed #dee2e6;
                border-radius: 6px;
                padding: 16px;
                margin: 24px 0;
                text-align: center;
            '>
                <p style='
                    color: #1a1a1a;
                    font-size: 28px;
                    font-weight: 700;
                    letter-spacing: 2px;
                    margin: 0;
                '>{$verify_token}</p>
            </div>
            
            <p style='
                color: #4a4a4a;
                font-size: 14px;
                line-height: 1.6;
                margin-bottom: 24px;
            '>If you did not request this code, please ignore this email.</p>

            <div style='
                border-top: 1px solid #e9ecef;
                margin-top: 30px;
                padding-top: 20px;
                text-align: center;
                color: #6c757d;
                font-size: 13px;
            '>
                <p style='margin: 0;'>&copy; 2025 Smart Card. All rights reserved.</p>
                <p style='margin: 8px 0 0;'>This is an automated message, please do not reply.</p>
            </div>
        </div>
    </div>
    ";

    $mail->Body = $email_template;
    try {
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if(isset($_POST['resend']) && isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    
    // Generate new code and expiration
    $new_verify_token = rand(100000, 999999);
    $token_expires_at = date('Y-m-d H:i:s', strtotime('+2 minutes'));
    
    // Update token
    $update_query = "UPDATE user SET verify_token='$new_verify_token', token_expires_at='$token_expires_at' WHERE email='$email'";
    $update_query_run = mysqli_query($con, $update_query);
    
    if($update_query_run) {
        // Get user's name
        $name_query = "SELECT name FROM user WHERE email='$email'";
        $name_result = mysqli_query($con, $name_query);
        $user = mysqli_fetch_assoc($name_result);
        
        if(sendemail_verify($user['name'], $email, $new_verify_token)) {
            echo json_encode(['status' => 'success', 'message' => 'New verification code sent']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send email']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update verification code']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>