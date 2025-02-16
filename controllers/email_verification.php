<?php
session_start();
// require 'router.php';

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];  // Retrieve the email from the session
    // echo "Your email is: " . $email;
} else {
    // echo "Email not set!";
}

// require 'router.php';
// require 'functions.php';

// dd($_SERVER);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Verification Panel</title>
        <link rel="stylesheet" href="assets/styles/email_verification.css">

        <script src="assets/js/fetch_email.js"></script>
        <script src="assets/js/fetch.js"></script>
        <script src="assets/js/resend.js" defer></script>
    </head>
    <body>
        <div class="container">
            <h1>Email Verification</h1>
            <p class="email-display">Verifying email for: <span class="email-text"><?= $email ?></span></p>
            
            <!-- <form id="verificationForm" onsubmit="return false;"> -->
            <form id="verificationForm" action="token.php" method="POST">
              <div class="form-group">
                <label for="verificationCode">Enter Verification Code</label>
                <input 
                  type="text"
                  id="verificationCode"
                  name="verification_code"
                  placeholder="Enter the code sent to your email"
                  maxlength="6"
                  autocomplete="off"
                >
                <p class="error-message">Invalid verification code. Please try again.</p>
              </div>
              
              <button type="submit">Verify</button>
              <a href="#" class="resend-link">Resend verification code</a>
            </form>
        </div>
    </body>
</html>