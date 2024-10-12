<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "home";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['room_number'], $_POST['previous_electricity_unit'], $_POST['current_electricity_unit'], 
    $_POST['electricity_fee'], $_POST['water_fee'], $_POST['wifi_fee'], $_POST['common_fee'], $_POST['total_amount'])) {
        
        $room_number = $_POST['room_number'];
        $previous_electricity_unit = $_POST['previous_electricity_unit'];
        $current_electricity_unit = $_POST['current_electricity_unit'];
        $electricity_fee = $_POST['electricity_fee'];
        $water_fee = $_POST['water_fee'];
        $wifi_fee = $_POST['wifi_fee'];
        $common_fee = $_POST['common_fee'];
        $total_amount = $_POST['total_amount'];

        $stmt = $conn->prepare("UPDATE rooms SET previous_electricity_unit=?, current_electricity_unit=?, electricity_fee=?, water_fee=?, wifi_fee=?, common_fee=?, total_amount=? WHERE room_number=?");
        $stmt->bind_param('ssssssss', $previous_electricity_unit, $current_electricity_unit, $electricity_fee, $water_fee, $wifi_fee, $common_fee, $total_amount, $room_number);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Room updated successfully"]);
        } else {
            echo json_encode(["error" => $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["error" => "Missing required parameters"]);
    }
}

$conn->close();
?>
