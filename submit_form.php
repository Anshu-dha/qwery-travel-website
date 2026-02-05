<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_registration"; // Ensure this matches your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connection successful<br>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Print the POST data to verify it's being passed correctly
    print_r($_POST);

    $name = $_POST['name'];
    $email = $_POST['email'];
    $destination = $_POST['destination'];
    $departure_date = $_POST['departure-date'];
    $return_date = $_POST['return-date'];

    $sql = "INSERT INTO bookings (name, email, destination, departure_date, return_date) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssss", $name, $email, $destination, $departure_date, $return_date);

    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->errno . " - " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
