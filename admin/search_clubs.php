<?php
include '../db_connection.php';
$name = $_POST['search'];

$sql = "SELECT * FROM clubs WHERE name LIKE ?";
$stmt = $conn->prepare($sql);
$searchTerm = "%$name%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result_clubs = $stmt->get_result();

if ($result_clubs->num_rows > 0) {
    while ($row = $result_clubs->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['clubid'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['location'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['pan_number'] . "</td>";
        echo "<td>" . $row['aadhar_number'] . "</td>";
        echo "<td>" . $row['club_director_name'] . "</td>";
        echo "<td>" . $row['club_secretary_name'] . "</td>";
        echo "<td>" . $row['contact_number'] . "</td>";
        echo "<td>" . $row['payment_status'] . "</td>";
        echo "<td><button class='btn btn-primary edit-btn' data-club-id='" . $row['id'] . "'>Edit</button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr>";
    echo "No results ";
    echo "</tr>";
}
?>