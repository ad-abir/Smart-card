<?php

session_start();
require 'config.php';
include('dbcon.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

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
            <img src='assets/images/credit-card.png' alt='Smart Card Logo' style='max-width: 150px; margin-bottom: 20px;'>
            
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