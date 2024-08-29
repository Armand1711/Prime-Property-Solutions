<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'includes/db.php';

$property_id = $_POST['property_id'];
$comment = $_POST['comment'];
$rating = $_POST['rating'];
$user_id = $_SESSION['user_id'];

$sql = "INSERT INTO comments (property_id, user_id, comment, rating) VALUES ('$property_id', '$user_id', '$comment', '$rating')";

if ($conn->query($sql) === TRUE) {
    header('Location: property.php?id=' . $property_id);
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
