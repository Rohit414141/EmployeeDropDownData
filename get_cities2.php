<?php
// get_cities.php

$stateId = $_POST['state_id'];

$conn = new mysqli("localhost", "root", "password", "rohit");

$result = $conn->query("SELECT * FROM cities WHERE state_id = $stateId");

echo "<option value=''>Select City</option>";

while ($row = $result->fetch_assoc()) {
    echo "<option value='{$row['id']}'>{$row['city_name']}</option>";
}

$conn->close();
?>
