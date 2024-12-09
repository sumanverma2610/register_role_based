<?php
session_start();
include('config.php');

if (isset($_POST['submit'])) {
    // Collect form data
    $name =  $_POST['name'];
    $email =  $_POST['email'];
    $password = md5($_POST['password']); // Password hashing
    $cpass = md5($_POST['confirm_password']);
    $role = $_POST['role'];

    // File upload handling
    if (isset($_FILES['upload_file']) && $_FILES['upload_file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "upload/"; // Target folder for uploaded files
        

        $fileType = $_FILES['upload_file']['type'];
        $fileName = uniqid('file_', true) . "_" . basename($_FILES['upload_file']['name']);
        $fileTmpName = $_FILES['upload_file']['tmp_name'];
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmpName, $filePath)) {
            // File upload successful
        } else {
            echo "<script>
                    alert('File upload failed!');
                    setTimeout(function() {
                        window.location.href = 'register.php';
                    }, 1500);
                  </script>";
            exit();
        }
    }

    // Password confirmation check
    if ($password !== $cpass) {
        echo "<script>
                alert('Passwords do not match!');
                setTimeout(function() {
                    window.location.href = 'register.php';
                }, 1500);
              </script>";
        exit();
    } else {
        // Insert data into database
        $sql = "INSERT INTO users (name, email, password, role, upload_file) 
                VALUES ('$name', '$email', '$password', '$role', '$filePath')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>
                    alert('Registration successful');
                    setTimeout(function() {
                        window.location.href = 'login.php';
                    }, 1500);
                  </script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
} else {
    echo "Submit Button Not Defined!";
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Registration Form</h3>
                </div>
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
                        </div>
                        
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        
                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                        
                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                        </div>
                        
                        <!-- Role -->
                        <div class="mb-3">
                            <label for="role" class="form-label">Select Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option  name= "role" value="user">User</option>
                                <option name= "role"value="admin">Admin</option>
                            </select>
                        </div>
                        <label for="upload_file" class="form-label">upload file</label>
                        <input type="file" class="form-control" id="upload_file" name="upload_file" required>
                        
                        <!-- Submit Button -->
                        <button type="submit" name="submit"class="btn btn-primary w-100">Register</button>
                        <button type="login" name="login" class="btn btn-primary w-100 mt-2" href ="login.php">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS (Optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
