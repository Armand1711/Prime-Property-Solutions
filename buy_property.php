<?php
session_start();
include 'includes/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Property - Prime Property Solutions</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            background-image: url('images/housefamily.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: rgba(0, 51, 102, 0.8); /* Slightly transparent background */
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
            background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent white background */
            padding: 2rem;
            max-width: 600px;
            margin: 2rem auto;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .container h2 {
            font-size: 1.8rem;
            color: #003366;
            margin-bottom: 1rem;
        }
        form {
            margin-top: 2rem;
        }
        form label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 1.2rem;
        }
        form input, form button {
            padding: 0.5rem;
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }
        form input {
            width: calc(100% - 1rem);
            margin-right: 0;
        }
        form button {
            background-color: #003366;
            color: #fff;
            border: none;
            border-radius: 0.3rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        form button:hover {
            background-color: #002244;
        }
        footer {
            text-align: center;
            padding: 1rem;
            background-color: rgba(0, 51, 102, 0.8);
            color: #fff;
            margin-top: 2rem;
            border-top: 1px solid #ddd;
        }
        footer p {
            margin: 0;
        }
    </style>
    <script>
        function showConfirmation(event) {
            event.preventDefault(); // Prevent the default form submission
            alert("An agent will be in contact with you regarding the purchase of the property.");
            document.getElementById('buy-form').submit(); // Submit the form programmatically
        }
    </script>
</head>
<body>
    <header>
        <h1>Buy Property</h1>
        <?php include 'includes/navigation.php'; ?>
    </header>
    <main>
        <div class="container">
            <h2>Buy Form</h2>
            <form id="buy-form" action="process_buy.php" method="post" onsubmit="showConfirmation(event);">
                <label for="buyer_name">Name:</label>
                <input type="text" id="buyer_name" name="buyer_name" required>
                
                <label for="buyer_email">Email:</label>
                <input type="email" id="buyer_email" name="buyer_email" required>
                
                <label for="buyer_phone">Phone:</label>
                <input type="text" id="buyer_phone" name="buyer_phone" required>
                
                <button type="submit">Buy Property</button>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Prime Property Solutions</p>
    </footer>
</body>
</html>
