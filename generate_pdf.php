<?php
// Include the Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

// Database connection parameters
require "connection.php";

// Query to fetch data from the table
$sql = "SELECT * FROM Emp";

// Executing the query
$result = $conn->query($sql);

// Checking for errors
if (!$result) {
    die("Error: " . $conn->error);
}

// Create mPDF instance
$mpdf = new \Mpdf\Mpdf();

$html = "<h2>All Emp Record</h2>";
$mpdf->WriteHTML($html);

// Add content to the PDF using the fetched data
while ($row = $result->fetch_assoc()) {
    // $mpdf->WriteHTML("ID: {$row['id']} - Name: {$row['name']} - Email: {$row['email']}<br>");
    // $html  = " Name :".$row['name'];
    $html = "
    
    <strong>Id:</strong> {$row['id']}</p>
    <p><strong>Name:</strong> {$row['name']}</p>
    <p><strong>Email:</strong> {$row['email']}</p>
    <p><strong>Contact:</strong> {$row['contact']}</p>
    <p><strong>ThankYou</strong><br>{$row['name']}</p>
    
";
    $mpdf->WriteHTML($html);
}

// Output the PDF to the browser or save it to a file
// $mpdf->Output();
 
// Add content to PDF
// $mpdf->WriteHTML($html);

// Output PDF as a file (you can also use 'I' to output as inline)
$mpdf->Output('Emp_details.pdf', 'D');
?>
