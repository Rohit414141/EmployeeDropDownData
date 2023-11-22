<?php
// Include the Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

// Create mPDF object
$mpdf = new \Mpdf\Mpdf();

// Sample data
$name = "John Doe";
$email = "john.doe@example.com";
$contact = "123-456-7890";
$description = "This is a sample description for the PDF.";

// HTML content for the PDF
$html = "
    <h1>User Information</h1>
    <p><strong>Name:</strong> $name</p>
    <p><strong>Email:</strong> $email</p>
    <p><strong>Contact:</strong> $contact</p>
    <p><strong>Description:</strong> $description</p>
";

// Add content to PDF
$mpdf->WriteHTML($html);

// Output PDF as a file (you can also use 'I' to output as inline)
$mpdf->Output('user_information.pdf', 'D');
?>
