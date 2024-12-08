<?php
include('config.php');
$id = $_GET['id'];
$sql = "DELETE FROM users WHERE id = $id";
if (mysqli_query($conn, $sql)) {
    echo "<script>alert('User deleted successfully!'); window.location.href = 'admin_dashboard.php';</script>";
} else {
    echo "<script>alert('Error deleting user.'); window.location.href = 'admin_dashboard.php';</script>";
}
?>
