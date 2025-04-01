<?php
session_start();
include('dbcon.php');

header('Content-Type: application/json');

if(!isset($_SESSION['email']) || !isset($_SESSION['reset_password']) || !isset($_SESSION['code_verified'])) {
    echo json_encode(['status' => 'error', 'message' => 'Session expired. Please restart the password reset process.']);
    exit();
}

if(isset($_POST['new_password'])) {
    $email = $_SESSION['email'];
    $new_password = mysqli_real_escape_string($con, $_POST['new_password']);
    
    // Hash the password
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
    
    // Update the password in the user table and reset token fields
    $update_query = "UPDATE user SET password='$hashed_password', verify_token=NULL, token_expires_at=NULL WHERE email='$email'";
    $update_result = mysqli_query($con, $update_query);
    
    // Update the password in the regis_users table
    $update_regis_query = "UPDATE regis_users SET password='$hashed_password' WHERE email='$email'";
    $update_regis_result = mysqli_query($con, $update_regis_query);
    
    if($update_result && $update_regis_result) {
        // Clear the session data related to password reset
        unset($_SESSION['email']);
        unset($_SESSION['reset_password']);
        unset($_SESSION['code_verified']);
        
        echo json_encode(['status' => 'success', 'message' => 'Password reset successful. Redirecting to login...']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to reset password: ' . mysqli_error($con)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>