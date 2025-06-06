<?php

session_start();
require 'config.php';
include('dbcon.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require dirname(__DIR__) . '/vendor/autoload.php';

function sendemail_verify($name, $email, $verify_token) {
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    // $mail->SMTPDebug = 2;

    $mail->isSMTP();                                          //Send using SMTP
    $mail->SMTPAuth   = true;                                 //Enable SMTP authentication
    
    $mail->Host       = MAIL_HOST;
    $mail->Username   = MAIL_USERNAME;
    $mail->Password   = MAIL_PASSWORD;
    
    $mail->SMTPSecure = "tls";
    $mail->Port       = MAIL_PORT;
    
    $mail->setFrom(MAIL_FROM_ADDRESS, $name);
    $mail->addAddress($email);

    $mail->isHTML(true);                                  //Set email format to HTML
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
            <img src='data:image/png;base64,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' 
            alt='Smart Card Logo' style='max-width: 50px; margin-bottom: 20px;'>
            
            <h2 style='
                color: #1a1a1a;
                font-size: 24px;
                font-weight: 600;
                margin-bottom: 24px;
                line-height: 1.3;
            '>Welcome to Smart Card</h2>
            
            <p style='
                color: #4a4a4a;
                font-size: 16px;
                line-height: 1.6;
                margin-bottom: 24px;
            '>Thank you <strong>{$name}</strong> for creating your Smart Card account. To ensure the security of your account, please verify your email address using the verification code below:</p>
            
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
            '>This code will expire in 2 minutes. If you didn't create a Smart Card account, please disregard this email.</p>
            
            <div style='
                margin-top: 30px;
                padding-top: 20px;
                text-align: center;
                color: #6c757d;
                font-size: 8px;
            '>
                <p style='margin: 0;'>If you did not request this, please ignore this email.</p>
            </div>

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
    echo 'Message has been sent';
}

if(isset($_POST['register_btn'])) {
    $name = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $verify_token = rand(100000, 999999);

    date_default_timezone_set('Asia/Dhaka'); // Example: 'Asia/Dhaka' or 'UTC'

    // Add expiration time (2 minutes from now)
    $token_expires_at = date('Y-m-d H:i:s', strtotime('+2 minutes'));
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    //Email exist or not
    $check_email_query = "SELECT email FROM user WHERE email='$email' LIMIT 1";
    $check_email_query_run = mysqli_query($con, $check_email_query);

    if(mysqli_num_rows($check_email_query_run) > 0){
        $_SESSION['status'] = "Email already exist";
        header("Location: /");
    }
    else {
        //Insert data with hashed password and expiration time
        $query = "INSERT INTO user (`name`, `email`, `password`, `verify_token`, `token_expires_at`) VALUES ('$name', '$email', '$hashed_password', '$verify_token', '$token_expires_at')";
        $query_run = mysqli_query($con, $query);


        if($query_run) {
            sendemail_verify("$name", "$email", "$verify_token");

            $_SESSION['status'] = "Registration Successful";
            $_SESSION['email'] = $email;
            header("Location: /email_verification");
        }
        else {
            $_SESSION['status'] = "Registration Failed";
            header("Location: /");
        }
    }
}

?>