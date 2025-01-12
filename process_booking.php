<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lpg_booking";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Debugging: Print all form data
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    // Retrieve and sanitize form data
    $name = isset($_POST['name']) ? $conn->real_escape_string(trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? $conn->real_escape_string(trim($_POST['email'])) : '';
    $phone = isset($_POST['phone']) ? $conn->real_escape_string(trim($_POST['phone'])) : '';
    $address = isset($_POST['address']) ? $conn->real_escape_string(trim($_POST['address'])) : '';
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

    // Calculate total cost based on quantity and price per unit (assuming a price per unit is defined)
    $price_per_unit = 3600; // Example price per unit, adjust as necessary
    $total_cost = $quantity * $price_per_unit; // Calculate total cost

    // Debugging: Check if data was captured
    echo "Name: $name, Email: $email, Phone: $phone, Address: $address, Quantity: $quantity, Total Cost: $total_cost<br>";

    // Validate required fields
    if (empty($name) || empty($email) || empty($phone) || empty($address) || $quantity <= 0)  {
        die("Error: One or more fields are empty or invalid.");
    }

    // Insert data into the database
    $sql = "INSERT INTO bookings (name, email, phone, address, quantity, total_cost) 
            VALUES ('$name', '$email', '$phone', '$address', '$quantity', '$total_cost')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Booking successful!');</script>";
        echo "<script>window.location.href = 'lpg_gas_booking.html';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
