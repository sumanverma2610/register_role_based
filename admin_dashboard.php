<?php
include('config.php');
session_start();

// Check if the user is logged in and has the "admin" role
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php'); // Redirect to login if not authorized
    exit();
}

// Query to fetch all users with the role of "admin"
$sql = "SELECT id, name, email FROM users WHERE role = 'admin'";
$result = mysqli_query($conn, $sql);

// Handle the update form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_user'])) {
    $user_id = $_POST['user_id'];
    $updated_name =  $_POST['name'];
    $updated_email =  $_POST['email'];

    $update_sql = "UPDATE users SET name = '$updated_name', email = '$updated_email' WHERE id = $user_id";
    mysqli_query($conn, $update_sql);
    header("Location: admin_dashboard.php"); // Redirect back to the dashboard after update
    exit();
}

// Handle the add user form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    $new_name = $_POST['name'];
    $new_email = $_POST['email'];

    // Insert the new user into the database
    $add_sql = "INSERT INTO users (name, email, role) VALUES ('$new_name', '$new_email', 'admin')";
    mysqli_query($conn, $add_sql);
    header("Location: admin_dashboard.php"); // Redirect back to the dashboard after adding the user
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Admin Dashboard</h1>
    <p class="text-center">Welcome, <?php echo $_SESSION['name']; ?>!</p>
    <a href="logout.php">Logout</a>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Admin List</h3>
           
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
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
                                    <td>
                                        <button class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#editUserModal' 
                                        onclick=\"editUser('{$row['id']}', '{$row['name']}', '{$row['email']}')\">Edit</button>
                                        <a href='delete_user.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a>
                                     <button class='btn btn-sm btn-success' data-bs-toggle='modal' data-bs-target='#addUserModal'>Add User</button>
        </div>
                                        </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr>
                                <td colspan='4' class='text-center'>No users found.</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="mb-3">
                        <label for="user_name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="user_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="user_email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="user_email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="update_user" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="add_user_name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="add_user_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="add_user_email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="add_user_email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="add_user" class="btn btn-success">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function editUser(id, name, email) {
        document.getElementById('user_id').value = id;
        document.getElementById('user_name').value = name;
        document.getElementById('user_email').value = email;
    }
</script>
</body>
</html>
