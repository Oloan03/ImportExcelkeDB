<?php 
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

include 'connect.php';

if (isset($_POST['submit'])) {
    $file = $_FILES["file"]["tmp_name"];
    $startRow = 4;

    try {
        $spreadsheet = IOFactory::load($file);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        for ($i = 1; $i < $startRow; $i++) {
            array_shift($rows);
        }

        $importedCount = 0;

        // Dapatkan baris header dari file Excel
        $headerRow = array_shift($rows);
        
        // Buat daftar kolom dan nilai secara dinamis
        $columns = [];
        $values = [];
        foreach ($headerRow as $index => $columnName) {
            $columnValue = mysqli_real_escape_string($connect, $rows[0][$index]); // Diasumsikan semua baris memiliki struktur yang sama
            $columns[] = "`$columnName`";
            $values[] = "'$columnValue'";
        }

        $columnList = implode(', ', $columns);
        $valueList = implode(', ', $values);

        $sql = "INSERT INTO `data` ($columnList) VALUES ($valueList)";
        
        if (mysqli_query($connect, $sql)) {
            $importedCount++;
        }

        echo "<p> Berhasil Import Data. Jumlah Data yang berhasil diimport: " . $importedCount . "</p>";

        include 'index.php';
   } catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    echo "Query Error: " . mysqli_error($connect);
   }
}
?>
