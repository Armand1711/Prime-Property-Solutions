Prime Property Solutions
Prime Property Solutions is a real estate website that allows users to browse available properties, make inquiries, submit offers, register and log in, and save their favorite properties. It provides a user-friendly interface and a seamless experience for anyone looking to buy or sell properties.

Built With
HTML5
CSS3
JavaScript
PHP
MySQL

Screenshots
![Screenshot 2024-08-29 163831](https://github.com/user-attachments/assets/565ca7ae-1897-44c8-bc5c-c9d457527b3d)

![Screenshot 2024-08-29 163809](https://github.com/user-attachments/assets/1f4dd93a-52e0-4373-b489-b754c6fb3c09)

![Screenshot 2024-08-29 163749](https://github.com/user-attachments/assets/716168bc-6aa2-40d7-b7ad-a72c97a7ce4c)

![Screenshot 2024-08-29 163729](https://github.com/user-attachments/assets/8d69dc6c-3cd5-4f0f-a584-d9abb43eab50)



Mockups
![image](https://github.com/user-attachments/assets/4992f717-9a4d-46c3-9727-4e5313644641)


![image](https://github.com/user-attachments/assets/0fc46035-edba-4a49-9b6b-5aa727ba5f02)



Features
Homepage: Provides background information about the company and its purpose.
Property Listings: Displays properties available for purchase in a visually appealing card layout.
User Registration and Login: Allows users to create accounts and log in to access more features.
Save Favorite Properties: Logged-in users can save properties they are interested in for future reference.
Contact Form: Allows users to inquire about properties directly.
Offer Form: Lets users submit an offer for a property, triggering a confirmation alert.
Responsive Design: Fully responsive design optimized for different screen sizes.
Getting Started
To get a local copy of the project up and running, follow these simple steps:

Prerequisites
XAMPP or WAMP (for local PHP server)
MySQL (included with XAMPP/WAMP)
Web Browser (e.g., Chrome, Firefox)
Installation
Clone the repository:

bash
Copy code
git clone https://github.com/your-username/prime-property-solutions.git
Move the Project Folder to the Web Directory:

If using XAMPP, move the project folder to C:/xampp/htdocs/.
Import the Database:

Open PHPMyAdmin (http://localhost/phpmyadmin).
Create a new database named prime_property_solutions.
Import the SQL file located in the database folder.
Update the Database Configuration:

Open the includes/db.php file.
Update the database credentials to match your local environment:
php
Copy code
$servername = "localhost";
$username = "root"; // Update if you use a different user
$password = "";     // Update if your MySQL has a password
$dbname = "prime_property_solutions";
Run the Project:

Start Apache and MySQL from XAMPP Control Panel.
Open your web browser and go to http://localhost/prime-property-solutions.
Usage
Register or Log in to access additional features such as saving favorite properties.
Navigate through the pages to explore properties.
Submit an inquiry through the contact form for any property of interest.
Make an offer using the "Offer on Property" form.
Save favorite properties to view them later.
File Structure
index.php - The homepage of the website.
buy_property.php - A page with a form to inquire about buying a property.
offer_property.php - A page where users can submit an offer for a property.
register.php - Registration page for new users.
login.php - Login page for existing users.
favorites.php - Page where users can view their saved properties.
includes/ - Contains PHP files for database connections and navigation components.
css/ - Contains stylesheets.
images/ - Contains images used throughout the website.
Future Implementations
Add property filters based on location, price range, and other criteria.
Integrate with Google Maps for property locations.
Add admin functionality to manage property listings.

Demo Video Link: 
https://drive.google.com/drive/folders/1y1Cjbu5Tb-UqlUTwd8iPsiNzKkcswJyn?usp=drive_link
