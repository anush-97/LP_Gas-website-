<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'C:/xampp/htdocs/Lponlin/PHPMailer/src/Exception.php'; // Absolute path
require 'C:/xampp/htdocs/Lponlin/PHPMailer/src/PHPMailer.php'; // Absolute path
require 'C:/xampp/htdocs/Lponlin/PHPMailer/src/SMTP.php'; // Absolute path

$servername = "localhost";
$username = "root"; // default XAMPP username
$password = ""; // default XAMPP password
$dbname = "lpg_booking"; // replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO contact_submissions (full_name, email, phone_number, address, message) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $full_name, $email, $phone_number, $address, $message);

// Set parameters and execute
$full_name = $_POST['full-name'];
$email = $_POST['email'];
$phone_number = $_POST['phone-number'];
$address = $_POST['address'];
$message = $_POST['message'];

if ($stmt->execute()) {
    echo "New record created successfully";

    // Send confirmation email
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     // Use Gmail's SMTP server
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'nuwansilva847@gmail.com';                // Your Gmail address
        $mail->Password   = 'yoty ccoa mpuo woik';                   // Your Gmail app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      // Enable TLS encryption
        $mail->Port       = 587;                                   // TCP port to connect to

        // Enable verbose debug output
        

        //Recipients
        $mail->setFrom('nuwansilva847@gmail.com', 'online booking contact mail');
        $mail->addAddress('anushka@gammainterpharm.lk');                    // Add a recipient

        // Content
        $mail->isHTML(true);                                      // Set email format to HTML
        $mail->Subject = 'Contact Form Submission Confirmation';
        $mail->Body    = 'Thank you for contacting us, ' . $full_name . ' ,' . $message . '. We have received your message and will get back to you shortly.';
        $mail->AltBody = 'Thank you for contacting us, ' . $full_name . '. We have received your message and will get back to you shortly.';

        $mail->send();
        echo 'Confirmation email has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    header("Location: http://localhost:8080/Lponlin/Contact.html");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();
?>