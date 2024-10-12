<?php
// delete_room.php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");

$host = 'localhost'; // Database host
$db_name = 'home'; // Database name
$username = 'root'; // Database username
$password = ''; // Database password

$conn = new mysqli($host, $username, $password, $db_name);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the ID from the query string
$id = $_GET['id'];

// Prepare an SQL statement to delete the room
$stmt = $conn->prepare("DELETE FROM rooms WHERE id = ?");
$stmt->bind_param("i", $id);

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(["message" => "Room deleted successfully."]);
} else {
    echo json_encode(["message" => "Failed to delete room."]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
  