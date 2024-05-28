<?php
header('Access-Control-Allow-Origin: *'); // Allow requests from any origin
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS'); // Allowed HTTP methods
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Allowed headers

// Connect to the MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ahsan_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Query the database for data
$sql = "SELECT * FROM form";
$result = $conn->query($sql);

// Convert the result set to an array of objects
$data = array();
while ($row = $result->fetch_assoc()) {
  $data[] = $row;
}

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($data);

// Close the database connection
$conn->close();
?>
