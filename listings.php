<?php
session_start();
include 'includes/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listings - Property Rental</title>
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
        .container {
            margin-top: 2rem;
        }
        .listings-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        .listing-card {
            background-color: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .listing-card:hover {
            transform: translateY(-5px);
        }
        .listing-card a {
            color: inherit;
            text-decoration: none;
        }
        .listing-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
        }
        .listing-card-body {
            padding: 1.5rem;
        }
        .listing-card-body h2 {
            font-size: 1.6rem;
            color: #003366;
            margin: 0 0 1rem;
        }
        .listing-card-body p {
            color: #666;
            margin: 0;
            font-size: 1.2rem;
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
        <h1>Available Listings</h1>
        <?php include 'includes/navigation.php'; ?>
    </header>
    <main>
        <div class="container">
            <div class="listings-container">
                <?php
                // Fetch listings from the database
                $sql = "SELECT * FROM properties";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Fetch the first image for the thumbnail
                        $property_id = $row['id'];
                        $image_sql = "SELECT image_path FROM property_images WHERE property_id = '$property_id' LIMIT 1";
                        $image_result = $conn->query($image_sql);
                        $image = $image_result->fetch_assoc();
                        $thumbnail = $image ? $image['image_path'] : 'default_thumbnail.jpg';

                        echo '<div class="listing-card">';
                        echo '<a href="listing_detail.php?id=' . $row['id'] . '">';
                        echo '<img src="' . htmlspecialchars($thumbnail) . '" alt="Listing Image">';
                        echo '<div class="listing-card-body">';
                        echo '<h2>' . htmlspecialchars($row['title']) . '</h2>';
                        echo '<p>Price: $' . number_format($row['price'], 2) . '</p>';
                        echo '<p>Location: ' . htmlspecialchars($row['location']) . '</p>';
                        echo '</div></a>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No listings available.</p>';
                }

                $conn->close();
                ?>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Property Rental</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
