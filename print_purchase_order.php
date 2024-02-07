<?php

require_once __DIR__ . '/vendor/autoload.php'; // Adjust the path as needed

// Create new mpdf instance
$mpdf = new \Mpdf\Mpdf();

// Add content to the PDF
$content = '<h1>Hello, this is a PDF generated using mpdf without Composer!</h1>';
$mpdf->WriteHTML($content);

// Save the PDF to a file or output to the browser
$mpdf->Output('output.pdf', 'I'); // 'D' means force download, use 'I' to open in the browser
