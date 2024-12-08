<?php
include('config.php');
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password']; // Corrected this line
    $role = $_POST['role'];

    // Encrypt the entered password with md5
    $encrypted_password = md5($password);

    // Query to find the user
    $sql = "SELECT * FROM users WHERE email = '$email' AND role = '$role' AND password = '$encrypted_password'  ";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
print_r($user);
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['name'] = $user['name'];

        // Redirect based on role
        if ($user['role'] === 'admin') {
            header('Location: admin_dashboard.php');
        } elseif ($user['role'] === 'user') {
            header('Location: user_dashboard.php');
        }
        exit();
    } else {
        echo "<script>
                alert('Email, password, or role is incorrect. Please try again.');
                window.location.href = 'login.php';
              </script>";
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Login</h3>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
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

                        <!-- Role -->
                        <div class="mb-3">
                            <label for="role" class="form-label">Select Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
