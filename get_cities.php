<?php
$state_id = $_GET['state_id'];

// Fetch cities based on the selected state
$city_query = "SELECT * FROM cities WHERE state_id = $state_id";
$city_result = $conn->query($city_query);

// Generate the HTML options for cities
$options = "";
while ($city_row = $city_result->fetch_assoc()) {
    $options .= "<option value='{$city_row['id']}'>{$city_row['city_name']}</option>";
}

echo $options;
?>