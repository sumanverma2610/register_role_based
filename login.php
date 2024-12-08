<?php
session_start(); // Start session
include('config.php'); // Include database connection
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    // Query to check if user exists
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $val = mysqli_query($conn, $sql);

    if (mysqli_num_rows($val)) {
        $row = mysqli_fetch_assoc($val);

        // Store user info in session
        $_SESSION['email'] = $row['email'];
        $_SESSION['user_id'] = $row['uid'];
        $_SESSION['role'] = $row['role'];

        // Redirect based on role
        if ($row['role'] === 'admin') {
            header("Location: admin_dashboard.php");
        } elseif ($row['role'] === 'user') {
            header("Location: user_dashboard.php");
        }
        exit();
    } else {
        echo "<span style='color: red;'>Invalid Email or Password!</span>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login Form</h2>
    <form action="" method="POST"> <!-- Form posts to the same script -->
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <label for="role">Role:</label><br>
        <select id="role" name="role" required>
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select><br><br>
        
        <button type="submit" name="login">Login</button>
    </form>
</body>
</html>



       