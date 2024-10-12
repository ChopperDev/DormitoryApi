    <?php
    header("Access-Control-Allow-Origin: *");
    header('Content-Type: application/json');
    $servername = "localhost"; // Use your database server
    $username = "root"; // Use your database username
    $password = ""; // Use your database password
    $dbname = "home"; // Use your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
    }

    // Check if the request is GET or POST
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Fetch room data
        $sql = "SELECT * FROM rooms";
        $result = $conn->query($sql);
        
        $rooms = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rooms[] = $row;
            }
        }
        echo json_encode($rooms);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if all necessary parameters are set
        if (
            isset($_POST['room_number'], $_POST['previous_electricity_unit'], $_POST['current_electricity_unit'], 
            $_POST['electricity_fee'], $_POST['water_fee'], $_POST['wifi_fee'], $_POST['common_fee'], $_POST['total_amount'])
        ) {
            // Get new room data
            $room_number = $_POST['room_number'];
            $previous_electricity_unit = $_POST['previous_electricity_unit'];
            $current_electricity_unit = $_POST['current_electricity_unit'];
            $electricity_fee = $_POST['electricity_fee'];
            $water_fee = $_POST['water_fee'];
            $wifi_fee = $_POST['wifi_fee'];
            $common_fee = $_POST['common_fee'];
            $total_amount = $_POST['total_amount'];

            // Use prepared statements to prevent SQL Injection
            $stmt = $conn->prepare("INSERT INTO rooms (room_number, previous_electricity_unit, current_electricity_unit, electricity_fee, water_fee, wifi_fee, common_fee, total_amount) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('ssssssss', $room_number, $previous_electricity_unit, $current_electricity_unit, $electricity_fee, $water_fee, $wifi_fee, $common_fee, $total_amount);

            if ($stmt->execute()) {
                echo json_encode(["message" => "Room added successfully"]);
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
