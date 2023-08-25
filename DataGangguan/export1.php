<?php
require 'vendor/autoload.php'; // Memuat autoloader dari PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function generateExcelReport($data) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Membuat judul kolom pada baris pertama
    $columns = ['Tanggal', 'IP VPN SUMBAR JMLG', 'IP VPN SUMBAR DRS', 'IP VPN JAMBI JMLG', 'IP VPN JAMBI DRS', 'INTERNET SUMBAR JMLG', 'INTERNET SUMBAR DRS', 'INTERNET JAMBI JMLG', 'INTERNET JAMBI DRS', 'Clear Channel SUMBAR JMLG', 'Clear Channel SUMBAR DRS', 'Clear Channel JAMBI JMLG', 'Clear Channel JAMBI DRS', 'METRONET SUMBAR JMLG', 'METRONET SUMBAR DRS', 'METRONET JAMBI JMLG', 'METRONET JAMBI DRS', 'VSAT SUMBAR JMLG', 'VSAT SUMBAR DRS', 'VSAT JAMBI JMLG', 'VSAT JAMBI DRS']; // Daftar kolom
    $columnIndex = 1;
    foreach ($columns as $columnTitle) {
        $sheet->setCellValueByColumnAndRow($columnIndex, 1, $columnTitle);
        $columnIndex++;
    }

    // Mengisi data pada baris-baris berikutnya
    $rowIndex = 2;
    foreach ($data as $tanggal => $rowData) {
        $columnIndex = 1;
        $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $tanggal);
        $columnIndex++;
        foreach ($rowData as $value) {
            $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
            $columnIndex++;
        }
        $rowIndex++;
    }

    $writer = new Xlsx($spreadsheet);
    $filename = 'laporan.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
}

// Panggil fungsi generateExcelReport dengan data yang sesuai
// Anda perlu menyesuaikan bagian ini sesuai dengan cara Anda mendapatkan data laporan
// Misalnya: $data = getDataFromDatabase();
// generateExcelReport($data);
