<?php
// get_rooms.php
header("Access-Control-Allow-Origin: *");

$host = 'localhost'; // หรือที่อยู่เซิร์ฟเวอร์ฐานข้อมูลของคุณ
$db = 'babydevg_home'; // ชื่อฐานข้อมูล
$user = 'babydevg_chopper'; // ชื่อผู้ใช้
$pass = '123456789'; // รหัสผ่าน

$conn = new mysqli($host, $username, $password, $db_name);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare an SQL statement to select all rooms
$query = "SELECT * FROM rooms";
$result = $conn->query($query);

$rooms = [];
if ($result->num_rows > 0) {
    // Fetch data
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }
}

// Set the content type to JSON and return the data
header('Content-Type: application/json');
echo json_encode($rooms);

// Close the connection
$conn->close();
?>