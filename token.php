<?php
session_start();
include('dbcon.php');

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Check connection
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    
    // Fetch data from user table
    $sql = "SELECT id, name, password, verify_token, token_expires_at FROM user WHERE Email = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch user data
        $row = $result->fetch_assoc();
        $id = $row["id"];
        $name = $row["name"];
        $pass = $row["password"];
        $verify_token = $row["verify_token"];
        $token_expires_at = $row["token_expires_at"];

        date_default_timezone_set('Asia/Dhaka');

        // Check if token has expired
        if (time() > strtotime($token_expires_at)) {
            $_SESSION['error'] = "Verification code has expired. Please request a new code.";
            header("Location: /email_verification");
            exit();
        } else {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['verification_code'])) {
                    $verification_code = trim($_POST['verification_code']);

                    if ($verification_code == $verify_token) {
                        // Update user's verification status
                        $update_query = "UPDATE user SET is_verified = 1, verify_token = NULL, token_expires_at = NULL WHERE email = ?";
                        $update_stmt = $con->prepare($update_query);
                        $update_stmt->bind_param("s", $email);

                        // Insert into regis_users
                        $insert_query = "INSERT INTO regis_users (`id`, `name`, `email`, `password`) VALUES (?, ?, ?, ?)";
                        $insert_stmt = $con->prepare($insert_query);
                        $insert_stmt->bind_param("isss", $id, $name, $email, $pass);
                        $insert_result = $insert_stmt->execute();

                        if ($update_stmt->execute() && $insert_result) { // Check both operations
                            // Clear verification-related session variables
                            unset($_SESSION['email']);
                            unset($_SESSION['verify_token']);
                            unset($_SESSION['token_expires_at']);

                            $_SESSION['success'] = "Email verified successfully!";
                            header("Location: /signin");
                            exit();
                        } else {
                            $_SESSION['error'] = "Error updating verification status or inserting into regis_users.";
                            header("Location: /email_verification");
                            exit();
                        }
                    } else {
                        $_SESSION['error'] = "Invalid verification code. Please try again.";
                        header("Location: /email_verification");
                        exit();
                    }
                }
            }
        }
    } else {
        $_SESSION['error'] = "User not found.";
        header("Location: /email_verification");
        exit();
    }
} else {
    $_SESSION['error'] = "Session email not set.";
    header("Location: /email_verification");
    exit();
}

// Close statements and connection
$stmt->close();
if (isset($update_stmt)) $update_stmt->close();
if (isset($insert_stmt)) $insert_stmt->close();
$con->close();
?>