<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/db.php';

$user_id = $_SESSION['user_id'];
$title = $_POST['title'];
$description = $_POST['description'];
$price = $_POST['price'];
$location = $_POST['location'];

$image = $_FILES['image']['name'];
$target_dir = "images/";
$target_file = $target_dir . basename($image);
move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

$sql = "INSERT INTO properties (user_id, title, description, price, location, image) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isssss", $user_id, $title, $description, $price, $location, $target_file);

if ($stmt->execute()) {
    header("Location: profile.php");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
