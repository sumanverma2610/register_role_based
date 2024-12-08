 <?php
 session_start();
 include('config.php');

if(isset($_POST['submit'])){
    $name =$_POST['name'];
    $email =$_POST['email'];
    $password = md5($_POST['password']);
    $role = $_POST['role'];
   
    $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
    $query = mysqli_query($conn, $sql);
    if ($query == 'true') {
        echo "Registration successful!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
if ($query) {
    $_SESSION['email'] = $email;
    $_SESSION['name'] = $name;
    $_SESSION['role'] = $role;
    $user_id = mysqli_insert_id($conn);
    $_SESSION['id'] = $id;
  $_SESSION['status'] = "success";
    header('Location: login.php');
    exit();
  }
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
                    <form action="login.php" method="POST">
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
