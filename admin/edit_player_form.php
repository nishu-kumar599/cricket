<?php
// Include the database connection file
include '../db_connection.php';

// Check if player_id is provided via POST request
if (isset($_POST['player_id'])) {
    $player_id = $_POST['player_id'];

    // Fetch player details from the database
    $sql_player = "SELECT * FROM players WHERE player_id = ?";
    $stmt = $conn->prepare($sql_player);
    $stmt->bind_param("s", $player_id);
    $stmt->execute();
    $result_player = $stmt->get_result();

    // Check if player exists
    if ($result_player->num_rows > 0) {
        $player_data = $result_player->fetch_assoc();
        // Return player data as JSON response
        echo json_encode($player_data);
    } else {
        // Return error message if player not found
        echo json_encode(array('error' => 'Player not found.'));
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // If player_id is not provided, return an error message
    echo json_encode(array('error' => 'Player ID not provided.'));
}
?>
