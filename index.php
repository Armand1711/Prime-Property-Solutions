<?php
session_start();
include 'includes/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Prime Property Solutions</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
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
            margin: 0;
            font-size: 2.5rem;
        }
        main {
            padding: 2rem;
        }
        .about-section, .agents-section {
            background-color: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .about-section h2, .agents-section h2 {
            color: #003366;
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        .about-section p, .agents-section p {
            font-size: 1.2rem;
            line-height: 1.6;
            margin-bottom: 1rem;
        }
        .about-section img, .agents-section img {
            display: block;
            max-width: 100%;
            border-radius: 0.5rem;
            margin: 1rem auto;
        }
        footer {
            background-color: #003366;
            color: #fff;
            padding: 1rem;
            text-align: center;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">Prime Property Solutions</div>
        <?php include 'includes/navigation.php'; ?>
    </header>
    <main>
        <section class="about-section">
            <h2>About Prime Property Solutions</h2>
            <p>Welcome to Prime Property Solutions, your premier partner in finding the ideal property. Whether you're searching for a new home or a lucrative investment opportunity, we offer a curated selection of listings to match your needs.</p>
            <p>At Prime Property Solutions, our mission is to deliver outstanding service and valuable insights throughout your real estate journey. Our knowledgeable team is dedicated to providing you with the most up-to-date and relevant property information.</p>
            <p>Explore our offerings to find a diverse range of properties, from charming apartments to luxurious estates. We are committed to transparency, reliability, and ensuring your satisfaction.</p>
            <img src="images/about_us.jpg" alt="About Us">
        </section>

        <section class="agents-section">
            <h2>Meet Our Expert Agents</h2>
            <p>Our team of expert agents is here to assist you in finding your perfect property. With extensive experience in the real estate market and a focus on personalized service, our agents are dedicated to meeting your needs and surpassing your expectations.</p>
            <p>From the initial consultation to the final transaction, our agents provide expert advice and support at every stage. Rely on us for an exceptional experience in purchasing or investing in your new property.</p>
            <img src="images/Agent.jpg" alt="Our Agents">
        </section>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Prime Property Solutions</p>
    </footer>
</body>
</html>

<?php $conn->close(); ?>
