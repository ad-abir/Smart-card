<?php
session_start();
include('dbcon.php');


if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];  // Retrieve the email from the session
    // echo "Your email is: " . $email;

    // Check connection
    if ($con->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Step 1: Fetch verify_token and token_expires_at for the given email
    $sql = "SELECT verify_token, token_expires_at FROM user WHERE Email = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch user data
        $row = $result->fetch_assoc();
        $verify_token = $row["verify_token"];
        $token_expires_at = $row["token_expires_at"];

        date_default_timezone_set('Asia/Dhaka'); // Example: 'Asia/Dhaka' or 'UTC'

        // Check if token has expired
        if (time() > strtotime($token_expires_at)) {
            // Token has expired
            $_SESSION['error'] = "Verification code has expired. Please request a new code.";
            header("Location: /email_verification");
            exit();
        }
        else {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['verification_code'])) {
                    $verification_code = trim($_POST['verification_code']); // Get the user input

                    // Compare the stored token with the entered verification code
                    if ($verification_code == $verify_token) {
                        // Update user's verification status
                        $update_query = "UPDATE user SET is_verified = 1, verify_token = NULL, token_expires_at = NULL WHERE email = ?";
                        $update_stmt = $con->prepare($update_query);
                        $update_stmt->bind_param("s", $email);
                        
                        if ($update_stmt->execute()) {
                            // Clear verification-related session variables
                            unset($_SESSION['email']);
                            unset($_SESSION['verify_token']);
                            unset($_SESSION['token_expires_at']);

                            // Set success message
                            $_SESSION['success'] = "Email verified successfully!";
                            
                            // Redirect to login or dashboard
                            header("Location: /signin");
                            exit();
                        } else {
                            // Handle update error
                            $_SESSION['error'] = "Error updating verification status.";
                            header("Location: /email_verification");
                            exit();
                        }
                    } else {
                        // Incorrect verification code
                        $_SESSION['error'] = "Invalid verification code. Please try again.";
                        header("Location: /email_verification");
                        exit();
                    }
                }
            }
        }
    }
}
?>