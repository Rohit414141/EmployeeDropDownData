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
    
<?php
}
?>

<!-- hichart used  -->

<?php

$sql = "SELECT gender, AVG(salary) as avg_salary FROM Emp WHERE state_id = '$selectedState' AND city_id = '$selectedCity' GROUP BY gender";
$result = $conn->query($sql);

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$conn->close();
?>

<?php
$chartData = array();

foreach ($data as $row) {
    $chartData[] = array(
        'gender' => $row['gender'],
        'avg_salary' => floatval($row['avg_salary'])
    );
}

$chartDataJson = json_encode($chartData);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gender vs Salary Chart</title>
    <script src="https://code.highcharts.com/highcharts.js"></script>
</head>
<body>

<div id="container" style="width: 50%; height: 400px;"></div>

<script>
    var chartData = <?php echo $chartDataJson; ?>;

    Highcharts.chart('container', {
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Gender vs Salary'
        },
        xAxis: {
            categories: chartData.map(function (item) {
                return item.gender;
            })
        },
        yAxis: {
            title: {
                text: 'Average Salary'
            }
        },
        series: [{
            name: 'Average Salary',
            data: chartData.map(function (item) {
                return item.avg_salary;
            })
        }]
    });
</script>

</body>
</html>