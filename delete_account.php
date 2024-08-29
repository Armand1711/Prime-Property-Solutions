<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Delete the user account
$sql = "DELETE FROM users WHERE id = $user_id";
if ($conn->query($sql) === TRUE) {
    // Optionally, delete user's properties and favorites
    $conn->query("DELETE FROM properties WHERE user_id = $user_id");
    $conn->query("DELETE FROM favorites WHERE user_id = $user_id");

    // Destroy the session and redirect to the homepage
    session_destroy();
    header("Location: index.php");
    exit();
} else {
    echo "Error deleting account: " . $conn->error;
}
?>
