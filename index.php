<?php
require "connection.php";

echo "<h1 style='font-size: 38px; margin-left: 17em'>Fetch Employee all record </h1>";

// Fetch data from the database
$sql  = "select * from Emp_Record";

// $sql  = "SELECT Emp_Record.id,Emp_Record.name,Emp_Record.email, location.city, location.state
// FROM Emp_Record
// LEFT JOIN location
// ON Emp_Record.id=location.id";
$result = $conn->query($sql);

// Check if any rows were returned

if ($result->num_rows > 0) {
    // Output data in a table

    echo "<table border='2' style='font-size: 38px; margin-left: 16em '><tr><th>Id</th><th>Name</th><th>Email</th></tr>";

    // Output data of each row

    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["email"] . "</td></tr>";
    }

    echo "</table>";
} else {
    echo "0 results";
}
// Close the connection

$conn->close();

?>

<form action="index2.php" method="post" style="margin-left: 38em">
<label for="cars">Next page:</label>
 

    <button>Next</button>
</form>
