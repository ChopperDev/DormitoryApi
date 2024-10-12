<?php
$host = 'localhost'; // หรือที่อยู่เซิร์ฟเวอร์ฐานข้อมูลของคุณ
$db = 'babydevg_home'; // ชื่อฐานข้อมูล
$user = 'babydevg_home'; // ชื่อผู้ใช้
$pass = 'ttpa8kHcfzmfhbtAjF3G'; // รหัสผ่าน

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
