<?php
require "connection.php";

$selectedState = $_POST['state'];
$selectedCity = $_POST['city'];

// echo "state id:".$selectedState."<br>";
// echo "city id:". $selectedCity."<br><br>";

$query = "select id,name,email,gender,salary,contact,state,city from Emp  WHERE state_id = '$selectedState' AND city_id = '$selectedCity'";
$result = $conn->query($query);

// Display the results
?>
<h1 style="margin-left: 20em;">Which State and City Employee Belongs to</h1>
<?php
if ($result->num_rows > 0) {
    echo "<table border='2' style='font-size: 38px; margin-left: 11em '><tr><th>Id</th><th>Name</th><th>Email</th><th>Gender</th><th>Salary</th><th>Contact</th><th>state</th><th>City</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["email"] . "</td><td>". $row["gender"] . "</td><td>" . $row["salary"]."</td><td>" . $row["contact"]."</td><td>". $row["state"] . "</td><td>" . $row["city"] . "</td></tr>";
    }
    echo "</table>";
?>    
 
<?php

} else {
    echo "No employees found in the selected state and city.";
    
}
?>
<!-- high chart -->    
<?php

// Fetch data from the database

$sql = "SELECT salary, gender, state, city FROM Emp";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$conn->close();
?>

<!-- hychart -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary, Gender, State, and City Distribution</title>
    <!-- Include Highcharts library -->
    <script src="https://code.highcharts.com/highcharts.js"></script>

    <style>
        #highcharts-gender-salary{
            margin-left: 5em !important;
        }

        #highcharts-state-city{
            margin: 7em -10em 1em -9em !important;
        }
    </style>
</head>
<body>

<!-- Highcharts Pie Chart for Gender and Salary -->
<div id="highcharts-gender-salary" style="width: 50%; display: inline-block;"></div>

<!-- Highcharts Pie Chart for State and City -->
<div id="highcharts-state-city" style="width: 50%; display: inline-block;"></div>

<script>
    // Prepare data for Highcharts
    var genderSalaryData = {};
    var stateCityData = {};

    <?php foreach ($data as $row): ?>
        // Gender and Salary Data
        var gender = "<?php echo $row['gender']; ?>";
        var salary = parseFloat("<?php echo $row['salary']; ?>");
        if (!genderSalaryData[gender]) {
            genderSalaryData[gender] = 0;
        }
        genderSalaryData[gender] += salary;

        // State and City Data
        var state = "<?php echo $row['state']; ?>";
        var city = "<?php echo $row['city']; ?>";
        var stateCityKey = state + ' - ' + city;
        if (!stateCityData[stateCityKey]) {
            stateCityData[stateCityKey] = 0;
        }
        stateCityData[stateCityKey]++;
    <?php endforeach; ?>

    // Highcharts Pie Chart for Gender and Salary
    Highcharts.chart('highcharts-gender-salary', {
        chart: {
            type: 'pie',
        },
        title: {
            text: 'Gender and Salary Ration'
        },
        series: [{
            data: Object.entries(genderSalaryData).map(([gender, totalSalary]) => ({
                name: gender,
                y: totalSalary
            }))
        }]
    });

    // Highcharts Pie Chart for State and City
    Highcharts.chart('highcharts-state-city', {
        chart: {
            type: 'pie',
        },
        title: {
            text: 'State and City Ratio'
        },
        series: [{
            data: Object.entries(stateCityData).map(([stateCity, count]) => ({
                name: stateCity,
                y: count
            }))
        }]
    });
</script>

</body>
</html>
