<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'includes/db.php';

$property_id = intval($_POST['property_id']);
$user_id = $_SESSION['user_id'];

// Check if the property belongs to the user
$sqlCheck = "SELECT user_id FROM properties WHERE id = $property_id";
$resultCheck = $conn->query($sqlCheck);

if ($resultCheck->num_rows > 0) {
    $owner = $resultCheck->fetch_assoc();
    if ($owner['user_id'] == $user_id) {
        // First delete comments related to the property
        $sqlDeleteComments = "DELETE FROM comments WHERE property_id = $property_id";
        $conn->query($sqlDeleteComments);

        // Optionally, delete associated images
        $sqlDeleteImages = "DELETE FROM property_images WHERE property_id = $property_id";
        $conn->query($sqlDeleteImages);

        // Now delete the property
        $sqlDelete = "DELETE FROM properties WHERE id = $property_id";
        if ($conn->query($sqlDelete) === TRUE) {
            header('Location: profile.php');
        } else {
            echo "Error deleting property: " . $conn->error;
        }
    } else {
        echo "You do not have permission to delete this property.";
    }
} else {
    echo "Property not found.";
}

$conn->close();
?>
