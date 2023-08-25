<?php 
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use TCPDF;

if (isset($_GET['format'])) {
    $format = $_GET['format'];

    if ($format === 'excel') {
        exportToExcel();
    } elseif ($format === 'pdf') {
        exportToPDF();
    }
}

function exportToExcel() {
    $pdo = new PDO('mysql:host=localhost;dbname=DataGangguan', 'root', '');
    $stmt = $pdo->query('SELECT * FROM `laporan gangguan`'); // Updated table name
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $header = array_keys($data[0]);
    $sheet->fromArray([$header], NULL, 'A1');

    $rowData = [];
    foreach ($data as $row) {
        $rowData[] = array_values($row);
    }
    $sheet->fromArray($rowData, NULL, 'A2');

    $writer = new Xlsx($spreadsheet);
    $filename = 'laporan.xlsx';
    $writer->save($filename);

    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    readfile($filename);
    unlink($filename);
}

function exportToPDF() {
    $pdo = new PDO('mysql:host=localhost;dbname=DataGangguan', 'root', '');
    $stmt = $pdo->query('SELECT * FROM `laporan gangguan`');
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $pdf = new TCPDF (PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Laporan Data Gangguan Jaringan Bulanan');
    $pdf->SetSubject('Laporan Data Gangguan Jaringan Bulanan');
    $pdf->SetKeywords('Laporan, Gangguan Jaringan, Bulanan');

    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 12);
    $cellWidth = 30;

    $header = array_keys($data[0]);
    foreach ($header as $col) {
        $pdf->Cell($cellWidth, 10, $col, 1);
    }
    $pdf->Ln();

    foreach ($data as $row) {
        foreach ($row as $col) {
            $pdf->Cell($cellWidth, 10, $col, 1);
        }
        $pdf->Ln();
    }

    $pdf->Output('laporan.pdf', 'D');
}
?>
