<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'includes/db.php';

$property_id = intval($_POST['property_id']);
$comment = $_POST['comment'];
$rating = intval($_POST['rating']);
$user_id = $_SESSION['user_id'];

// Sanitize inputs
$property_id = $conn->real_escape_string($property_id);
$comment = $conn->real_escape_string($comment);
$rating = $conn->real_escape_string($rating);
$user_id = $conn->real_escape_string($user_id);

// Validate inputs
if ($rating < 1 || $rating > 5) {
    echo "Invalid rating.";
    exit();
}

// Insert the comment and rating into the database
$sql = "INSERT INTO comments (property_id, user_id, comment, rating) VALUES ('$property_id', '$user_id', '$comment', '$rating')";

if ($conn->query($sql) === TRUE) {
    header('Location: property.php?id=' . $property_id);
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
