<?php
// update_room.php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Content-Type");

$host = 'localhost'; // หรือที่อยู่เซิร์ฟเวอร์ฐานข้อมูลของคุณ
$db = 'babydevg_home'; // ชื่อฐานข้อมูล
$user = 'babydevg_home'; // ชื่อผู้ใช้
$pass = 'ttpa8kHcfzmfhbtAjF3G'; // รหัสผ่าน

$conn = new mysqli($host, $username, $password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับข้อมูลจาก body
$input = json_decode(file_get_contents('php://input'), true);

$id = $input['id'];
$roomNumber = $input['room_number'];
$previousElectricity = $input['previous_electricity'];
$currentElectricity = $input['current_electricity'];
$waterFee = $input['water_fee'];
$wifiFee = $input['wifi_fee'];
$commonFee = $input['common_fee'];

// คำนวณค่าไฟฟ้าและยอดรวม
$electricityFee = ($currentElectricity - $previousElectricity) * 8;
$totalAmount = $electricityFee + $waterFee + $wifiFee + $commonFee;

// สร้างคำสั่ง SQL สำหรับอัปเดต
$query = "UPDATE rooms SET room_number = ?, previous_electricity_unit = ?, current_electricity_unit = ?, electricity_fee = ?, water_fee = ?, wifi_fee = ?, common_fee = ?, total_amount = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sdddiiddi", $roomNumber, $previousElectricity, $currentElectricity, $electricityFee, $waterFee, $wifiFee, $commonFee, $totalAmount, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
