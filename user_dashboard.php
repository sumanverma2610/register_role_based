<?php
include('config.php');
session_start();
// print_r($_SESSION);
// Check if the user is logged in and has the "user" role
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'user') {
    header('Location: login.php'); // Redirect to login if not authorized
    exit();
}

// Query to fetch all users with the role of "user"
$sql = "SELECT id, name, email FROM users WHERE role = 'user'";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">User Dashboard</h1>
    <p class="text-center">Welcome, <?php echo $_SESSION['name']; ?>!</p>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">User List</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['name']}</td>
                                    <td>{$row['email']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr>
                                <td colspan='3' class='text-center'>No users found.</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
