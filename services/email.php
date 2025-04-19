<?php
session_start();
include('dbcon.php');
// require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

function sendemail_verify($name, $email, $verify_token) {
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->SMTPDebug  = 0; // Set to 2 for debugging
        $mail->SMTPAuth   = true;
        
        $mail->Host       = $_ENV['MAIL_HOST'];
        $mail->Username   = $_ENV['MAIL_USERNAME'];
        $mail->Password   = $_ENV['MAIL_PASSWORD'];
        
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        
        // Recipients
        $mail->setFrom($_ENV['MAIL_FROM_ADDRESS'], 'Smart Card');
        $mail->addAddress($email);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Verification Code';
        
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
                '>Password Reset Verification Code</h2>
                
                <p style='
                    color: #4a4a4a;
                    font-size: 16px;
                    line-height: 1.6;
                    margin-bottom: 24px;
                '>Hello {$name}, here is your verification code to reset your password. This code will expire in 2 minutes:</p>
                
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
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        // Log error for debugging
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

header('Content-Type: application/json');

// Check if form is submitted
if(isset($_POST['email'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    
    // First check if email exists in regis_users table
    $check_regis_query = "SELECT * FROM regis_users WHERE email='$email'";
    $check_regis_result = mysqli_query($con, $check_regis_query);
    
    if(mysqli_num_rows($check_regis_result) > 0) {
        // Email exists in regis_users, now check user table
        $check_user_query = "SELECT * FROM user WHERE email='$email'";
        $check_user_result = mysqli_query($con, $check_user_query);
        
        if(mysqli_num_rows($check_user_result) > 0) {
            // Email exists in user table, proceed with OTP
            $user_data = mysqli_fetch_assoc($check_user_result);
            $name = $user_data['name'];
            
            // Generate verification code
            $verify_token = rand(100000, 999999);
            
            // Set expiration time (2 minutes from now)
            date_default_timezone_set('Asia/Dhaka'); // Adjust timezone as needed
            $token_expires_at = date('Y-m-d H:i:s', strtotime('+2 minutes'));
            
            // Update user table with new verification token
            $update_query = "UPDATE user SET verify_token='$verify_token', token_expires_at='$token_expires_at' WHERE email='$email'";
            $update_result = mysqli_query($con, $update_query);
            
            if($update_result) {
                // Save email in session for later use
                $_SESSION['email'] = $email;
                $_SESSION['reset_password'] = true;
                
                // Send verification email
                if(sendemail_verify($name, $email, $verify_token)) {
                    echo json_encode(['status' => 'success', 'message' => 'Verification code sent to your email']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to send verification email. Please check your email configuration.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update verification code: ' . mysqli_error($con)]);
            }
        } else {
            // Email exists in regis_users but not in user table
            echo json_encode(['status' => 'error', 'message' => 'User account not fully set up. Please contact support.']);
        }
    } else {
        // Email does not exist in regis_users
        echo json_encode(['status' => 'error', 'message' => 'Email is not registered']);
    }
} else {
    // Direct access without form submission
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>