<?php
session_start();
include_once('../backend/config.php');
require('../pdf/fpdf.php'); // Include FPDF library

if ($_SESSION['user_type'] !== 'admin') {
    header('Location: ../backend/login.php');
    exit();
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM happy__tblmarks WHERE student_id = $id";
$result = mysqli_query($happy_conn, $sql);

// Create PDF instance
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Title
$pdf->Cell(190, 10, 'Student Marks Report', 1, 1, 'C');
$pdf->Ln(10);

// Table Headers
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90, 10, 'Subject', 1, 0, 'C');
$pdf->Cell(40, 10, 'Marks', 1, 0, 'C');
$pdf->Cell(50, 10, 'Date', 1, 1, 'C');

// Table Data
$pdf->SetFont('Arial', '', 12);
while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(90, 10, $row['subject'], 1, 0, 'C');
    $pdf->Cell(40, 10, $row['marks'], 1, 0, 'C');
    $pdf->Cell(50, 10, $row['entry_date'], 1, 1, 'C');
}

// Output the PDF as a download
$pdf->Output('D', 'student_marks.pdf'); // 'D' forces file download
?>
