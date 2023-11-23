<?php
require "connection.php";

// Step 2: Fetch data from the database
$sql = "SELECT * FROM Emp";
$result = $conn->query($sql);

// Step 3: Display data in a Bootstrap table
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Emp Record</title>
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
    <h1 class="mt-4" style="text-align: center;">All Employee Record</h1>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Contact</th>
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

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>