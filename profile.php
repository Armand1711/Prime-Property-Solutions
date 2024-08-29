<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Property Rental</title>
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
            margin-bottom: 2rem;
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .property:hover {
            transform: translateY(-5px);
        }
        .property img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
        }
        .property h3 {
            font-size: 1.6rem;
            color: #003366;
            margin: 1rem 0 0;
            padding: 0 1rem;
        }
        .property p {
            color: #666;
            margin: 0;
            padding: 0 1rem;
            font-size: 1.2rem;
        }
        .property a {
            display: inline-block;
            margin: 1rem;
            color: #fff;
            background-color: #0066cc;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .property a:hover {
            background-color: #004c99;
        }
        .property form {
            display: inline-block;
            margin: 1rem;
        }
        .property button {
            background-color: #cc0000;
            color: #fff;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .property button:hover {
            background-color: #990000;
        }
        .delete-account-btn {
            background-color: #cc0000;
            color: #fff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 2rem;
        }
        .delete-account-btn:hover {
            background-color: #990000;
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
        <h1>User Profile</h1>
        <?php include 'includes/navigation.php'; ?>
    </header>
    <main>
        <?php
        include 'includes/db.php';

        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM users WHERE id = $user_id";
        $result = $conn->query($sql);
        $user = $result->fetch_assoc();
        ?>

        <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h2>
        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>

        <h3>Your Listings</h3>
        <?php
        $sql = "SELECT * FROM properties WHERE user_id = $user_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="property">';
                echo '<img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['title']) . '">';
                echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
                echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                echo '<p><strong>$' . htmlspecialchars($row['price']) . '</strong></p>';
                echo '<p>' . htmlspecialchars($row['location']) . '</p>';
                echo '<a href="property.php?id=' . intval($row['id']) . '">View Details</a>';

                // Form to delete the listing
                echo '<form action="delete_listing.php" method="post">
                        <input type="hidden" name="property_id" value="' . intval($row['id']) . '">
                        <button type="submit">Delete Listing</button>
                      </form>';

                echo '</div>';
            }
        } else {
            echo 'You have not added any listings yet.';
        }
        ?>

        <h3>Your Favorites</h3>
        <?php
        $sql = "SELECT p.* FROM properties p JOIN favorites f ON p.id = f.property_id WHERE f.user_id = $user_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="property">';
                echo '<img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['title']) . '">';
                echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
                echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                echo '<p><strong>$' . htmlspecialchars($row['price']) . '</strong></p>';
                echo '<p>' . htmlspecialchars($row['location']) . '</p>';
                echo '<a href="property.php?id=' . intval($row['id']) . '">View Details</a>';

                // Form to remove the property from favorites
                echo '<form action="remove_favorite.php" method="post">
                        <input type="hidden" name="property_id" value="' . intval($row['id']) . '">
                        <button type="submit">Remove from Favorites</button>
                      </form>';

                echo '</div>';
            }
        } else {
            echo 'You have not added any favorites yet.';
        }
        ?>

        <!-- Delete Account Button -->
        <form action="delete_account.php" method="post" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
            <button type="submit" class="delete-account-btn">Delete Account</button>
        </form>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Property Rental</p>
    </footer>
</body>
</html>
