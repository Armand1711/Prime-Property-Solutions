<?php
session_start();
include 'includes/db.php'; // Include your database connection

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = $conn->real_escape_string($_POST['price']);
    $location = $conn->real_escape_string($_POST['location']);
    
    // Insert the new listing into the properties table
    $sql = "INSERT INTO properties (user_id, title, description, price, location) VALUES ('$user_id', '$title', '$description', '$price', '$location')";
    
    if ($conn->query($sql) === TRUE) {
        $property_id = $conn->insert_id; // Get the ID of the newly inserted property
        
        // Handle the multiple images upload, limit to 20 files
        $targetDir = "uploads/";

        // Check if the upload directory exists, if not, create it
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $totalFiles = count($_FILES['images']['name']);
        $allowedFiles = min($totalFiles, 20);  // Limit to 20 files

        for ($key = 0; $key < $allowedFiles; $key++) {
            $tmp_name = $_FILES['images']['tmp_name'][$key];
            $imageName = basename($_FILES['images']['name'][$key]);
            $targetFilePath = $targetDir . $imageName;
            
            // Validate the image type
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
            if (in_array(strtolower($fileType), $allowedTypes)) {
                // Upload the file to the server
                if (move_uploaded_file($tmp_name, $targetFilePath)) {
                    // Insert the image path into the property_images table
                    $sqlImage = "INSERT INTO property_images (property_id, image_path) VALUES ('$property_id', '$targetFilePath')";
                    $conn->query($sqlImage);
                } else {
                    echo "Error uploading image: $imageName<br>";
                }
            } else {
                echo "Invalid file type for image: $imageName<br>";
            }
        }

        // After processing, clear the buffer and redirect
        ob_clean();
        header('Location: listings.php');
        exit();
    } else {
        echo 'Error: ' . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Listing - Property Rental</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
            color: #333;
        }
        header {
            background-color: #003366;
            color: #fff;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header h1 {
            font-size: 2.5rem;
            margin: 0;
        }
        main {
            padding: 2rem;
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }
        form {
            display: flex;
            flex-direction: column;
        }
        form label {
            margin-top: 1rem;
            font-weight: bold;
        }
        form input, form textarea, form select {
            margin-top: 0.5rem;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            font-size: 1rem;
            width: 100%;
        }
        form textarea {
            resize: vertical;
            height: 150px;
        }
        form button {
            margin-top: 1.5rem;
            background-color: #0066cc;
            color: #fff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 1.1rem;
            transition: background-color 0.3s;
        }
        form button:hover {
            background-color: #004c99;
        }
        small {
            margin-top: 0.5rem;
            color: #666;
        }
        footer {
            text-align: center;
            padding: 1.5rem;
            background-color: #003366;
            color: #fff;
            margin-top: 2rem;
            border-top: 1px solid #ddd;
        }
        footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>Add a New Listing</h1>
        <?php include 'includes/navigation.php'; ?>
    </header>
    <main>
        <form action="add_listing.php" method="post" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" required>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>

            <!-- Limited to 20 image uploads -->
            <label for="images">Images (up to 20):</label>
            <input type="file" id="images" name="images[]" accept="image/*" multiple required>
            <small>You can select up to 20 images.</small>

            <button type="submit">Add Listing</button>
        </form>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Property Rental</p>
    </footer>
</body>
</html>
