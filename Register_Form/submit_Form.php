<?php
header('Content-Type: application/json'); // Ensure the content type is JSON
header('Access-Control-Allow-Origin: *'); // Allow cross-origin requests
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS'); // Allow different HTTP methods
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Allowed headers

// Handle preflight (OPTIONS) requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(204); // No content
  exit; // Stop further execution
}

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ahsan_db"; // Update with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
  exit;
}

// Get JSON data from the request body
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if ($data === null) {
  echo json_encode(['error' => 'Invalid JSON data']);
  exit;
}

// Insert into the database
$Fname = $data['Fname'];
$Lname = $data['Lname'];
$email = $data['email'];
$password = password_hash($data['password'], PASSWORD_DEFAULT); // Hash the password for security
$address = $data['address'];

$sql = "INSERT INTO form (Fname, Lname, email, password, address) 
        VALUES ('$Fname', '$Lname', '$email', '$password', '$address')";

if ($conn->query($sql) === TRUE) {
  echo json_encode(['message' => 'Data inserted successfully']);
} else {
  echo json_encode(['error' => 'Error inserting data: ' . $conn->error]);
}

// Close the connection
$conn->close();
