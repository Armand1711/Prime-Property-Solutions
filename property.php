<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Details - Property Rental</title>
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
            max-width: 1200px;
            margin: 0 auto;
        }
        .property {
            background-color: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        .property img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 0.5rem;
        }
        .property h3 {
            font-size: 2rem;
            color: #003366;
            margin: 1rem 0;
        }
        .property p {
            color: #666;
            margin: 0;
            font-size: 1.2rem;
        }
        .property button {
            background-color: #0066cc;
            color: #fff;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .property button:hover {
            background-color: #004c99;
        }
        .comment {
            background-color: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .comment p {
            margin: 0;
            font-size: 1.2rem;
        }
        form {
            margin-top: 1.5rem;
            padding: 1.5rem;
            background-color: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        form label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }
        form textarea {
            width: 100%;
            height: 100px;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            font-size: 1rem;
            margin-bottom: 1rem;
        }
        form select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            font-size: 1rem;
            margin-bottom: 1rem;
        }
        form button {
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
        <h1>Property Details</h1>
        <?php include 'includes/navigation.php'; ?>
    </header>
    <main>
        <?php
        include 'includes/db.php';

        $id = intval($_GET['id']);
        $sql = "SELECT * FROM properties WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo '<div class="property">';
            echo '<img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['title']) . '">';
            echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
            echo '<p>' . htmlspecialchars($row['description']) . '</p>';
            echo '<p><strong>$' . htmlspecialchars($row['price']) . '</strong></p>';
            echo '<p>' . htmlspecialchars($row['location']) . '</p>';
            echo '</div>';
        } else {
            echo 'Property not found.';
        }

        // Add to Favorites button
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $sql = "SELECT * FROM favorites WHERE user_id = $user_id AND property_id = $id";
            $result = $conn->query($sql);

            if ($result->num_rows == 0) {
                echo '<form action="add_to_favorites.php" method="post">';
                echo '<input type="hidden" name="property_id" value="' . $id . '">';
                echo '<button type="submit">Add to Favorites</button>';
                echo '</form>';
            } else {
                echo '<p>This property is already in your favorites.</p>';
            }
        }

        // Display comments
        $sql = "SELECT c.comment, c.rating, u.username FROM comments c JOIN users u ON c.user_id = u.id WHERE c.property_id = $id";
        $result = $conn->query($sql);

        echo '<h3>Comments</h3>';
        if ($result->num_rows > 0) {
            while ($comment = $result->fetch_assoc()) {
                echo '<div class="comment">';
                echo '<p><strong>' . htmlspecialchars($comment['username']) . ':</strong> ' . htmlspecialchars($comment['comment']) . ' (Rating: ' . intval($comment['rating']) . '/5)</p>';
                echo '</div>';
            }
        } else {
            echo 'No comments yet.';
        }

        // Add comment form
        if (isset($_SESSION['user_id'])) {
            echo '<h3>Add a Comment</h3>';
            echo '<form action="add_comment.php" method="post">';
            echo '<input type="hidden" name="property_id" value="' . $id . '">';
            echo '<label for="comment">Comment:</label>';
            echo '<textarea id="comment" name="comment" required></textarea>';
            echo '<label for="rating">Rating:</label>';
            echo '<select id="rating" name="rating" required>';
            echo '<option value="1">1</option>';
            echo '<option value="2">2</option>';
            echo '<option value="3">3</option>';
            echo '<option value="4">4</option>';
            echo '<option value="5">5</option>';
            echo '</select>';
            echo '<button type="submit">Submit</button>';
            echo '</form>';
        }
        ?>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Property Rental</p>
    </footer>
</body>
</html>
