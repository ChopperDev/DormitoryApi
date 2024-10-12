<?php
$host = 'localhost'; // หรือที่อยู่เซิร์ฟเวอร์ฐานข้อมูลของคุณ
$db = 'babydevg_home'; // ชื่อฐานข้อมูล
$user = 'babydevg_home'; // ชื่อผู้ใช้
$pass = 'ttpa8kHcfzmfhbtAjF3G'; // รหัสผ่าน

// สร้างการเชื่อมต่อ
$conn = new mysqli($host, $username, $password, $db_name);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับค่าจาก GET request (จาก ESP32)
$room_number = $_GET['room_number']; // รับค่า room_number เพื่อระบุห้อง
$previous_electricity_unit = $_GET['previous_electricity_unit'];
$current_electricity_unit = $_GET['current_electricity_unit'];

// คำนวณค่าต่าง ๆ
$unit_difference = $current_electricity_unit - $previous_electricity_unit;
$electricity_fee = $unit_difference * 8;

// อัปเดตค่าหน่วยไฟในตารางที่มี room_number ตรงกัน
$sql = "UPDATE rooms SET 
        previous_electricity_unit = $previous_electricity_unit, 
        current_electricity_unit = $current_electricity_unit,
        electricity_fee = $electricity_fee,
        total_amount = electricity_fee + water_fee + wifi_fee + common_fee 
        WHERE room_number = $room_number";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
