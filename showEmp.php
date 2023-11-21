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

$sql = "SELECT name,salary, gender, state, city FROM Emp";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

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
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    

    <style>
        #highcharts-state-city{
            margin-left: 13em !important;
        }
    </style>
</head>
<body>

<!-- Highcharts Pie Chart for State and City -->
<div id="highcharts-state-city" style="width: 50%; display: inline-block;"></div>

<script>
    // Prepare data for Highcharts
    var genderSalaryData = {};
    var stateCityData = {};

    <?php foreach ($data as $row): ?>

        // State and City Data
        var state = "<?php echo $row['state']; ?>";
        var city = "<?php echo $row['city']; ?>";
        var stateCityKey = state + ' - ' + city;
        if (!stateCityData[stateCityKey]) {
            stateCityData[stateCityKey] = 0;
        }
        stateCityData[stateCityKey]++;
    <?php endforeach; ?>

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

<!-- name salary gender graph show -->

<div id="bar-graph"></div>

<script>
    // Prepare data for Plotly
    var names = <?php echo json_encode(array_column($data, 'name')); ?>;
    var salaries = <?php echo json_encode(array_column($data, 'salary')); ?>;
    var genders = <?php echo json_encode(array_column($data, 'gender')); ?>;

    // Group data by gender
    var groupedData = {};
    for (var i = 0; i < names.length; i++) {
        var gender = genders[i];
        if (!groupedData[gender]) {
            groupedData[gender] = [];
        }
        groupedData[gender].push({name: names[i], salary: salaries[i]});
    }

    // Create traces for each gender
    var traces = [];
    for (var gender in groupedData) {
        var trace = {
            x: groupedData[gender].map(item => item.name),
            y: groupedData[gender].map(item => item.salary),
            type: 'bar',
            name: gender,
        };
        traces.push(trace);
    }

    // Layout
    var layout = {
        barmode: 'group',
        title: 'Salary and Gender Bio Graph',
        xaxis: {
            title: 'Employee Name'
        },
        yaxis: {
            title: 'Salary'
        }
    };

    // Plot the graph
    Plotly.newPlot('bar-graph', traces, layout);
</script>

<!-- state graph show total budget -->

<?php
// Fetch data from the database

$sql_budget = "SELECT state, SUM(salary) as total_salary FROM Emp GROUP BY state";
$result_budget = $conn->query($sql_budget);

$data_budget = [];
while ($row_budget = $result_budget->fetch_assoc()) {
    $data_budget[] = $row_budget;
}


$conn->close();
?>

<div id="salary-chart" style="width: 80%; height: 400px;"></div>

<script>
    // Prepare data for Plotly
    var states = <?php echo json_encode(array_column($data_budget, 'state')); ?>;
    var totalSalaries = <?php echo json_encode(array_column($data_budget, 'total_salary')); ?>;

    // Create a trace for the bar chart
    var trace = {
        x: states,
        y: totalSalaries,
        type: 'bar',
        marker: {
            color: 'rgb(51, 122, 183)',
        },
    };

    // Layout
    var layout = {
        title: 'Total Salary by State',
        xaxis: {
            title: 'State'
        },
        yaxis: {
            title: 'Total Salary'
        }
    };

    // Plot the chart
    Plotly.newPlot('salary-chart', [trace], layout);
</script>

</body>
</html>




