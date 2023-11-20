<?php
require "connection.php";

$selectedState = $_POST['state'];
$selectedCity = $_POST['city'];

// echo "state id:".$selectedState."<br>";
// echo "city id:". $selectedCity."<br><br>";

$query = "select id,name,email,contact,state,city from Emp  WHERE state_id = '$selectedState' AND city_id = '$selectedCity'";
$result = $conn->query($query);

// Display the results
?>
<h1 style="margin-left: 19em;">Which State and City Employee Belongs to</h1>
<?php
if ($result->num_rows > 0) {
    echo "<table border='2' style='font-size: 38px; margin-left: 14em '><tr><th>Id</th><th>Name</th><th>Email</th><th>Contact</th><th>state</th><th>City</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["email"] . "</td><td>" . $row["contact"]."</td><td>" . $row["state"] . "</td><td>" . $row["city"] . "</td></tr>";
    }
    echo "</table>";
?>
    <a href="index.php" style="margin-left:72em;">Home Page</a>
<?php

} else {
    echo "No employees found in the selected state and city.";

?>
    <a href="index.php">Home Page</a>
<?php
}
?>