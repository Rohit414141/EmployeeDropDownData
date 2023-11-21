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
<h1 style="margin-left: 8em;">Which State and City Employee Belongs to</h1>
<?php
if ($result->num_rows > 0) {
    echo "<table border='2' style='font-size: 38px; margin-left: 1em '><tr><th>Id</th><th>Name</th><th>Email</th><th>Gender</th><th>Salary</th><th>Contact</th><th>state</th><th>City</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["email"] . "</td><td>". $row["gender"] . "</td><td>" . $row["salary"]."</td><td>" . $row["contact"]."</td><td>". $row["state"] . "</td><td>" . $row["city"] . "</td></tr>";
    }
    echo "</table>";
?>
    <a href="index.php" style="margin-left:65em;">Home Page</a>
    <!-- high chart -->
    <!-- <a href="hychart.php">high chart</a>  -->
    
<?php

} else {
    echo "No employees found in the selected state and city.";
    
?>
    <a href="index.php" style="margin-left:65em;">Home Page</a>
<?php
}
?>
<!-- hichart used  -->
<?php
// Query to get salary and gender information
$query = "SELECT gender, SUM(salary) as total_salary FROM Emp WHERE state_id = '$selectedState' AND city_id = '$selectedCity' GROUP BY gender";
$result = $conn->query($query);

// Fetch data and format for chart
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Salary and Gender Chart</title>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        #myChart{

            width: 700px !important;
            height: 700px !important;
            margin-left: 10em;
            font-size: px;;
        }
    </style>
</head>
<body>
    <h2>Salary and Gender Chart</h2>
    <canvas id="myChart" width="0" height="0"></canvas>

    <script>
        // Prepare data for the chart
        var data = <?php echo json_encode($data); ?>;
        
       // Extract labels and values
        var labels = data.map(function(item) {
            return item.gender;
        });
        var values = data.map(function(item) {
            return item.total_salary;
        });

        // Create a pie chart
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: ['blue', 'pink'], // Adjust colors as needed
                }],
            },
        });
    </script>

</body>
</html>
