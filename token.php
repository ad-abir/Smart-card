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
                        // Define placeholder values for required fields
                        $phone = "Not provided"; // Placeholder for phone
                        $home_address = "Not provided"; // Placeholder for home_address

                        // Update user's verification status
                        $update_query = "UPDATE user SET is_verified = 1, verify_token = NULL, token_expires_at = NULL WHERE email = ?";
                        $update_stmt = $con->prepare($update_query);
                        $update_stmt->bind_param("s", $email);

                        // Insert into regis_users
                        $insert_regis_query = "INSERT INTO regis_users (`id`, `name`, `email`, `password`) VALUES (?, ?, ?, ?)";
                        $insert_regis_stmt = $con->prepare($insert_regis_query);
                        $insert_regis_stmt->bind_param("isss", $id, $name, $email, $pass);

                        // Insert into user_info with all required fields
                        $insert_info_query = "INSERT INTO user_info (`id`, `full_name`, `phone`, `email`, `home_address`) VALUES (?, ?, ?, ?, ?)";
                        $insert_info_stmt = $con->prepare($insert_info_query);
                        $insert_info_stmt->bind_param("issss", $id, $name, $phone, $email, $home_address);

                        // Execute all statements and check success
                        $update_result = $update_stmt->execute();
                        $insert_regis_result = $insert_regis_stmt->execute();
                        $insert_info_result = $insert_info_stmt->execute();

                        if ($update_result && $insert_regis_result && $insert_info_result) {
                            // Clear verification-related session variables
                            unset($_SESSION['email']);
                            unset($_SESSION['verify_token']);
                            unset($_SESSION['token_expires_at']);

                            $_SESSION['success'] = "Email verified successfully!";
                            header("Location: /signin");
                            exit();
                        } else {
                            $_SESSION['error'] = "Error updating verification status or inserting into tables.";
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
if (isset($insert_regis_stmt)) $insert_regis_stmt->close();
if (isset($insert_info_stmt)) $insert_info_stmt->close();
$con->close();
?>