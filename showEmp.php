<?php
require "connection.php";

$selectedState = $_POST['state'];
$selectedCity = $_POST['city'];

// echo "state id:".$selectedState."<br>";
// echo "city id:". $selectedCity."<br><br>";

$query = "select id,name,email,gender,salary,contact,state,city from Emp  WHERE state_id = '$selectedState' AND city_id = '$selectedCity'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap Table Example</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 60px; /* Adjust the top padding if using a fixed navbar */
        }
        .container-fluid{
            margin-top: -82px;
        
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <h1 class="mt-4" style="text-align: center;">State City Wise Emp Record</h1>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Salary</th>
            <th>State</th>
            <th>City</th>
            <!-- Add more columns as needed -->
        </tr>
        </thead>
        <tbody>
        <?php
        // Loop through the fetched data and display it in the table
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["contact"]. "</td>";
                echo "<td>" . $row["salary"]. "</td>";
                echo "<td>" . $row["state"]. "</td>";
                echo "<td>" . $row["city"]. "</td>";
                // Add more columns as needed
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No records found</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>
 
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

<?php
// Fetch data from the database

$sql_budget = "SELECT state, Avg(salary) as total_salary FROM Emp GROUP BY state";
$result_budget = $conn->query($sql_budget);

$data_budget = [];
while ($row_budget = $result_budget->fetch_assoc()) {
    $data_budget[] = $row_budget;
}

// $conn->close();
?>

<div id="bar-chart" style="width: 100%; height: 400px;"></div>

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
            title: 'State Name'
        },
        yaxis: {
            title: 'Total Salary'
        }
    };

    // Plot the chart
    Plotly.newPlot('bar-chart', [trace], layout);
  
</script>


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


</body>
</html>




