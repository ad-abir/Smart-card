<?php
session_start();
include('dbcon.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Step 1: Fetch verify_token and token_expires_at for the given email
    $sql = "SELECT email, password FROM regis_users WHERE Email = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch user data
        $row = $result->fetch_assoc();
        $tab_email = $row["email"];
        $tab_pass = $row["password"];

        // Verify the entered password with the hashed password from the database
        if (password_verify($password, $tab_pass) && $email === $tab_email) {
            echo "Login successful!";
            // Redirect or start session after successful login
            $_SESSION['user_email'] = $db_email;
            header("Location: /dashboard");
            exit();
        } else {
            echo "Invalid email or password.";
        }

        
    }
}

// // Only process if the form is submitted
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // Get and sanitize user inputs
//     $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
//     $password = $_POST['password']; // We don't sanitize passwords as it might alter the value

//     // Validate inputs
//     $errors = [];
    
//     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//         $errors[] = "Invalid email format";
//     }
    
//     if (empty($password)) {
//         $errors[] = "Password is required";
//     }
    
//     // If there are validation errors
//     if (!empty($errors)) {
//         $_SESSION['errors'] = $errors;
//         header("Location: /signin");
//         exit();
//     }
    
//     // No validation errors, proceed with authentication
//     try {
//         // Check connection
//         if ($con->connect_error) {
//             throw new Exception("Database connection failed: " . $con->connect_error);
//         }
        
//         // First check if the user exists in regis_users (verified users)
//         $sql = "SELECT * FROM regis_users WHERE email = ?";
//         $stmt = $con->prepare($sql);
//         $stmt->bind_param("s", $email);
//         $stmt->execute();
//         $result = $stmt->get_result();
        
//         if ($result->num_rows > 0) {
//             // User found in regis_users table
//             $user = $result->fetch_assoc();
            
//             // Verify password
//             // Note: This assumes passwords are stored using password_hash()
//             // If passwords are stored in plaintext or using a different hashing method, 
//             // this comparison needs to be adjusted accordingly
//             if ($password === $user['password']) {
//                 // Password is correct (using direct comparison for plaintext passwords)
//                 // Set session variables
//                 $_SESSION['user_id'] = $user['id'];
//                 $_SESSION['user_name'] = $user['name'];
//                 $_SESSION['user_email'] = $user['email'];
//                 $_SESSION['logged_in'] = true;
                
//                 // Redirect to dashboard or home page
//                 header("Location: /dashboard");
//                 exit();
//             } else {
//                 // Password is incorrect
//                 $_SESSION['error'] = "Invalid email or password";
//                 header("Location: /signin");
//                 exit();
//             }
//         } else {
//             // User not found in regis_users, check if they're in the user table but not verified
//             $sql = "SELECT * FROM user WHERE email = ? AND is_verified = 0";
//             $stmt = $con->prepare($sql);
//             $stmt->bind_param("s", $email);
//             $stmt->execute();
//             $result = $stmt->get_result();
            
//             if ($result->num_rows > 0) {
//                 // User exists but is not verified
//                 $_SESSION['error'] = "Please verify your email before signing in";
//                 $_SESSION['email'] = $email; // Store email for verification page
//                 header("Location: /email_verification");
//                 exit();
//             } else {
//                 // User does not exist
//                 $_SESSION['error'] = "Invalid email or password";
//                 header("Location: /signin");
//                 exit();
//             }
//         }
//     } catch (Exception $e) {
//         // Log the error
//         error_log("Sign-in error: " . $e->getMessage());
        
//         // Generic error message for security
//         $_SESSION['error'] = "An error occurred. Please try again later.";
//         header("Location: /signin");
//         exit();
//     }
// } else {
//     // If someone tries to access this file directly without POST data
//     header("Location: /signin");
//     exit();
// }
?>