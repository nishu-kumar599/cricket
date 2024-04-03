<?php
include '../db_connection.php';
$name = $_POST['search'];
$club_id = $_POST['club_id'];
$sql = "SELECT * FROM players WHERE name LIKE ? AND club_id = ?";
$stmt = $conn->prepare($sql);
$searchTerm = "%$name%";
$stmt->bind_param("si", $searchTerm, $club_id);
$stmt->execute();
$result_clubs = $stmt->get_result();

if ($result_clubs->num_rows > 0) {
    while ($row = $result_clubs->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['player_id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['age'] . "</td>";
        echo "<td>" . $row['mobile'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['type'] . "</td>";
        echo "<td><img src='" . $profile_picture_data_url . "' alt='Profile Picture' width='100'></td>";
        echo '<td><button class="btn btn-primary edit-scorecard" data-toggle="modal" data-target="#editScoreModal" 
        data-player-id="' . $row['player_id'] . '" data-runs="' . $row['runs'] . '" 
        data-wickets="' . $row['wicket'] . '" data-catches="' . $row['catches'] . '"
        data-no_of_six="' . $row['no_of_six'] . '" data-no_of_four="' . $row['no_of_four'] . '"
        data-five_wickets_hall="' . $row['five_wicket_hall'] . '" data-no_of_hundred="' . $row['no_of_hundred'] . '"
        data-no_of_fifty="' . $row['no_of_fifty'] . '" data-no_of_stumping="' . $row['no_of_stumping'] . '">View</button></td>';
        echo "</tr>";
    }
} else {
    echo "<tr>";
    echo "No results found";
    echo "</tr>";
}
?>