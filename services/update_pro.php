<?php

// echo "Hello Abhishek!";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'dbcon.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $profile_photo = NULL;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/profile_photos/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        $file_name = 'profile_' . $user_id . '_' . time() . '.' . $file_ext;
        $file_path = $upload_dir . $file_name;
        
        $allowed_types = ['image/png', 'image/jpeg', 'image/jpg'];
        $max_size = 25 * 1024 * 1024;
        
        if (!in_array($_FILES['photo']['type'], $allowed_types)) {
            $_SESSION['update_error'] = "Invalid file type. Only JPG, JPEG, and PNG are allowed.";
            header("Location: update.php");
            exit();
        }
        
        if ($_FILES['photo']['size'] > $max_size) {
            $_SESSION['update_error'] = "File size exceeds 25MB limit.";
            header("Location: update.php");
            exit();
        }
        
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $file_path)) {
            $profile_photo = $file_name;
        } else {
            $_SESSION['update_error'] = "Error uploading file.";
            header("Location: update.php");
            exit();
        }
    }

    $fields = [
        'full_name' => mysqli_real_escape_string($con, $_POST['fullName']),
        'job_title' => !empty($_POST['jobTitle']) ? mysqli_real_escape_string($con, $_POST['jobTitle']) : NULL,
        'bio' => !empty($_POST['bio']) ? mysqli_real_escape_string($con, $_POST['bio']) : NULL,
        'company_name' => !empty($_POST['companyName']) ? mysqli_real_escape_string($con, $_POST['companyName']) : NULL,
        'phone' => mysqli_real_escape_string($con, $_POST['phone']),
        'whatsapp' => !empty($_POST['whatsapp']) ? mysqli_real_escape_string($con, $_POST['whatsapp']) : NULL,
        'email' => mysqli_real_escape_string($con, $_POST['email']),
        'home_address' => mysqli_real_escape_string($con, $_POST['homeAddress']),
        'home_map_link' => !empty($_POST['homeMapLink']) ? mysqli_real_escape_string($con, $_POST['homeMapLink']) : NULL,
        'office_address' => !empty($_POST['officeAddress']) ? mysqli_real_escape_string($con, $_POST['officeAddress']) : NULL,
        'office_map_link' => !empty($_POST['officeMapLink']) ? mysqli_real_escape_string($con, $_POST['officeMapLink']) : NULL,
        'office_website' => !empty($_POST['officeWebsite']) ? mysqli_real_escape_string($con, $_POST['officeWebsite']) : NULL,
        'personal_website' => !empty($_POST['personalWebsite']) ? mysqli_real_escape_string($con, $_POST['personalWebsite']) : NULL,
        'linkedin' => !empty($_POST['linkedin']) ? mysqli_real_escape_string($con, $_POST['linkedin']) : NULL,
        'github' => !empty($_POST['github']) ? mysqli_real_escape_string($con, $_POST['github']) : NULL,
        'instagram' => !empty($_POST['instagram']) ? mysqli_real_escape_string($con, $_POST['instagram']) : NULL,
        'facebook' => !empty($_POST['facebook']) ? mysqli_real_escape_string($con, $_POST['facebook']) : NULL,
        'snapchat' => !empty($_POST['snapchat']) ? mysqli_real_escape_string($con, $_POST['snapchat']) : NULL,
        'youtube' => !empty($_POST['youtube']) ? mysqli_real_escape_string($con, $_POST['youtube']) : NULL,
        'portfolio' => !empty($_POST['portfolio']) ? mysqli_real_escape_string($con, $_POST['portfolio']) : NULL,
    ];

    if ($profile_photo !== NULL) {
        $fields['profile_photo'] = $profile_photo;
    }

    $check_query = "SELECT id FROM user_info WHERE id = '$user_id'";
    $result = mysqli_query($con, $check_query);
    
    $current_time = date('Y-m-d H:i:s');
    
    if (mysqli_num_rows($result) > 0) {
        $update_parts = [];
        foreach ($fields as $key => $value) {
            $update_parts[] = "$key = " . ($value === NULL ? "NULL" : "'$value'");
        }
        $update_parts[] = "updated_at = '$current_time'";
        
        $query = "UPDATE user_info SET " . implode(", ", $update_parts) . " WHERE id = '$user_id'";
    } else {
        $fields['id'] = $user_id;
        $fields['created_at'] = $current_time;
        $fields['updated_at'] = $current_time;
        
        $columns = implode(", ", array_keys($fields));
        $values = implode(", ", array_map(function($value) {
            return $value === NULL ? "NULL" : "'$value'";
        }, array_values($fields)));
        
        $query = "INSERT INTO user_info ($columns) VALUES ($values)";
    }

    if (mysqli_query($con, $query)) {
       $_SESSION['update_success'] = "Profile updated successfully!";
       header("Location: /dashboard");
       exit();
    } else {
       $_SESSION['update_error'] = "Error updating profile: " . mysqli_error($con);
       header("Location: /update");
       exit();
    }
    exit();
}

mysqli_close($con);
?>