<?php
session_start();
include 'includes/db.php';

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['property_id']) || !is_numeric($_POST['property_id']) ||
        !isset($_POST['buyer_name']) || !isset($_POST['buyer_email']) || !isset($_POST['buyer_phone'])) {
        echo "Invalid data.";
        exit();
    }

    $property_id = intval($_POST['property_id']);
    $buyer_name = $conn->real_escape_string($_POST['buyer_name']);
    $buyer_email = $conn->real_escape_string($_POST['buyer_email']);
    $buyer_phone = $conn->real_escape_string($_POST['buyer_phone']);

    // Check if property exists
    $sql = "SELECT * FROM properties WHERE id = $property_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        echo "Property not found.";
        exit();
    }

    // Insert purchase into the database
    $sql = "INSERT INTO purchases (property_id, buyer_name, buyer_email, buyer_phone) 
            VALUES ($property_id, '$buyer_name', '$buyer_email', '$buyer_phone')";

    if ($conn->query($sql) === TRUE) {
        echo "Purchase successful. Thank you for your purchase!";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
?>
