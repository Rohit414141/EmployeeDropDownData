<?php
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "rohit";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch states
$state_query = "SELECT * FROM states";
$state_result = $conn->query($state_query);

// Fetch cities (for the first state initially)

$city_query  = "SELECT * 
FROM states
INNER JOIN cities
ON states.id=cities.state_id";

// $city_query = "SELECT * FROM cities WHERE state_id = 4";


$city_result = $conn->query($city_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>State City Dropdown</title>
</head>
<body>

<form>
    <label for="state">State:</label>
    <select id="state" name="state" onchange="fetchCities(this.value)">
        <?php
        while ($state_row = $state_result->fetch_assoc()) {
            echo "<option value='{$state_row['id']}'>{$state_row['state_name']}</option>";
        }
        ?>
    </select>

    <label for="city">City:</label>
    <select id="city" name="city" onchange="fetchCities(this.value)">
        <?php
        while ($city_row = $city_result->fetch_assoc()) {
            echo "<option value='{$city_row['id']}'>{$city_row['city_name']}</option>";
        }
        ?>
    </select>
</form>

<script>
    function fetchCities(stateId) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("city").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "get_cities.php?state_id=" + stateId, true);
        xmlhttp.send();
    }
</script>

</body>
</html>

<?php
$conn->close();
?>

