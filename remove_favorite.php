<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'includes/db.php';

$property_id = intval($_POST['property_id']);
$user_id = $_SESSION['user_id'];

// Remove the property from favorites
$sql = "DELETE FROM favorites WHERE user_id = $user_id AND property_id = $property_id";

if ($conn->query($sql) === TRUE) {
    header('Location: profile.php');
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
