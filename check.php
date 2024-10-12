<?php
$host = 'localhost';
$db_name = 'home';
$username = 'root';
$password = '';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->room_id)) {
    $query = "SELECT is_paid FROM rooms WHERE id = :room_id";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':room_id', $data->room_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $is_paid = $row['is_paid'];

        http_response_code(200);
        echo json_encode(array("room_id" => $data->room_id, "is_paid" => $is_paid));
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "Room not found."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Incomplete data."));
}
?>
