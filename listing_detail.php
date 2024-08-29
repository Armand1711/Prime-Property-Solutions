<?php
session_start();
include 'includes/db.php';

// Check if 'id' parameter is set and valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "No listing specified or invalid ID.";
    exit();
}

$property_id = intval($_GET['id']);

// Fetch the property details and rating from the database
$sql = "SELECT properties.*, users.username, AVG(ratings.rating) as average_rating 
        FROM properties 
        JOIN users ON properties.user_id = users.id
        LEFT JOIN ratings ON properties.id = ratings.property_id 
        WHERE properties.id = $property_id 
        GROUP BY properties.id";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error executing query: " . $conn->error;
    exit();
}

if ($result->num_rows == 0) {
    echo "Listing not found.";
    exit();
}

$listing = $result->fetch_assoc();

// Fetch images for the listing
$sqlImages = "SELECT image_path FROM property_images WHERE property_id = $property_id";
$resultImages = $conn->query($sqlImages);

if ($resultImages === false) {
    echo "Error executing query: " . $conn->error;
    exit();
}

$images = [];
while ($row = $resultImages->fetch_assoc()) {
    $images[] = $row['image_path'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($listing['title']); ?> - Property Details</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f5f5;
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
        .container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 0.5rem;
            margin-top: 2rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }
        .listing-detail h2 {
            font-size: 1.8rem;
            color: #003366;
            margin-top: 1.5rem;
        }
        .listing-detail p {
            color: #666;
            font-size: 1.4rem;
        }
        .carousel-inner img {
            width: 100%;
            height: auto;
            border-radius: 0.5rem;
        }
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: #003366;
            border-radius: 50%;
        }
        .carousel-control-prev-icon:hover,
        .carousel-control-next-icon:hover {
            background-color: #002244;
        }
        .footer {
            text-align: center;
            padding: 1.5rem;
            background-color: #003366;
            color: #fff;
            margin-top: 2rem;
            border-top: 1px solid #ddd;
        }
        .footer p {
            margin: 0;
        }
        form {
            margin-top: 2rem;
        }
        form label,
        form select,
        form button {
            margin-right: 1rem;
            font-size: 1.2rem;
        }
        form button {
            background-color: #003366;
            color: #fff;
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: 0.3rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        form button:hover {
            background-color: #002244;
        }
        .offer-button {
            background-color: #28a745;
            color: #fff;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 1.2rem;
            transition: background-color 0.3s;
        }
        .offer-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <header>
        <h1><?php echo htmlspecialchars($listing['title']); ?></h1>
        <?php include 'includes/navigation.php'; ?>
    </header>
    <main>
        <div class="container">
            <div class="listing-detail">
                <h2>Description</h2>
                <p><?php echo isset($listing['description']) ? nl2br(htmlspecialchars($listing['description'])) : 'No description available.'; ?></p>

                <h2>Price</h2>
                <p>R<?php echo isset($listing['price']) ? htmlspecialchars(number_format($listing['price'], 2)) : '0.00'; ?></p>

                <h2>Location</h2>
                <p><?php echo isset($listing['location']) ? htmlspecialchars($listing['location']) : 'No location available.'; ?></p>

                <h2>Posted By</h2>
                <p><?php echo isset($listing['username']) ? htmlspecialchars($listing['username']) : 'Unknown'; ?></p>

                <h2>Average Rating</h2>
                <p><?php echo isset($listing['average_rating']) ? number_format($listing['average_rating'], 1) . '/5' : 'No ratings yet.'; ?></p>

                <h2>Images</h2>
                <?php if (!empty($images)): ?>
                    <div id="carouselExampleControls" class="carousel slide">
                        <div class="carousel-inner">
                            <?php foreach ($images as $index => $image): ?>
                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                    <img src="<?php echo htmlspecialchars($image); ?>" class="d-block w-100" alt="Property Image">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                <?php else: ?>
                    <p>No images available for this listing.</p>
                <?php endif; ?>

                <h2>Rate this Property</h2>
                <form action="rate_property.php" method="post">
                    <input type="hidden" name="property_id" value="<?php echo $property_id; ?>">
                    <label for="rating">Rating (out of 5):</label>
                    <select name="rating" id="rating" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    <button type="submit">Submit Rating</button>
                </form>

                <!-- Offer on Property Button -->
                <form action="buy_property.php" method="post">
                    <input type="hidden" name="property_id" value="<?php echo $property_id; ?>">
                    <button type="submit" class="offer-button">Offer on Property</button>
                </form>
            </div>
        </div>
    </main>
    <footer class="footer">
        <p>&copy; <?php echo date("Y"); ?> Prime Property Solutions</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
