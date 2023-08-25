<?php
session_start();
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
        //create log import
        $dateimport = date('Y-m-d H:i:s');
        $insertImportTable = mysqli_query($connect, "insert into table_import (tgl_import) values ('$dateimport')");
        $idImport = mysqli_insert_id($connect);

        foreach ($rows as $row) {
            $no_tiket = mysqli_real_escape_string($connect, $row[1]);
            $querry = "SELECT COUNT(*) AS total FROM `Data` WHERE `No Tiket` = '$no_tiket'";
            $result = mysqli_query($connect, $querry);
            $row_count = mysqli_fetch_assoc($result)['total'];
            if ($row_count == 0) {

                $nama_service = mysqli_real_escape_string($connect, $row[2]);
                $sid = (int) $row[3];
                $produk = mysqli_real_escape_string($connect, $row[4]);
                $bandwith = mysqli_real_escape_string($connect, $row[5]);
                $tiket_open = date('Y-m-d H:i:s', strtotime($row[6]));
                $tiket_close = date('Y-m-d H:i:s', strtotime($row[7]));
                $stop_clock = (int) $row[8];
                $durasi = (string) $row[9];
                $durasi_menit = (double) $row[10];
                $penyebab = mysqli_real_escape_string($connect, $row[11]);
                $action = mysqli_real_escape_string($connect, $row[12]);
                $asman = mysqli_real_escape_string($connect, $row[13]);
                $kategori_layanan = mysqli_real_escape_string($connect, $row[14]);
                $unit_users = mysqli_real_escape_string($connect, $row[15]);
                $jenis_gangguan = mysqli_real_escape_string($connect, $row[16]);
                $detail_gangguan = mysqli_real_escape_string($connect, $row[17]);
                $lokasi_gangguan = mysqli_real_escape_string($connect, $row[18]);

                $sql = "INSERT INTO `data` (`No Tiket`,`import_id`,  `Nama Service`, `SID`, `Produk`, `Bandwith`, `Tiket Open`, `Tiket Close`, `Stop Clock (Durasi)`, `Durasi (Jam)`, `Durasi (Menit)`, Penyebab, `Action`, Asman, `Kategori Layanan`, `Unit PLN Pengguna`, `Jenis Gangguan`, `Detail Gangguan`, `Lokasi Gangguan`) 
                        VALUES ('$no_tiket', '$idImport', '$nama_service', '$sid', '$produk', '$bandwith', '$tiket_open', '$tiket_close', '$stop_clock', '$durasi', '$durasi_menit', '$penyebab', '$action', '$asman', '$kategori_layanan', '$unit_users', '$jenis_gangguan', '$detail_gangguan', '$lokasi_gangguan')";

                if (mysqli_query($connect, $sql)) {
                    $importedCount++;
                }

                
            }
        }
        $_SESSION['$importedCount'] = $importedCount;
        //Get Data berdasarkan idImport
        $sql = "SELECT substring(`Tiket Close`,1,10) Tanggal,`Produk`, `Kategori Layanan`, `Asman`, COUNT(No) jmlgangguan, SUM(`Durasi (Menit)`) drs  FROM `data` where import_id=$idImport GROUP BY substring(`Tiket Close`,1,10) ,`Produk`, `Kategori Layanan`, `Asman` order by substring(`Tiket Close`,1,10) ASC;";
        $qy = mysqli_query($connect, $sql);
    
        while($data = mysqli_fetch_array($qy)){
            $id = $idImport;
            $tanggal = $data['Tanggal'];
            $jenis_produk = $data['Produk'];
            $kategori_layanan = $data['Kategori Layanan'];
            $Asman = $data['Asman'];
            $jumlah = $data['jmlgangguan'];
            $durasi = $data['drs'];
            //insert ke table log_harian
            $sqlharian = "INSERT INTO `log_harian` (`import_id`, `Tanggal`, `jenis_produk`, `Kategori_layanan`, `Asman`, `jumlah`, `durasi`) Values ('$id', '$tanggal','$jenis_produk', '$kategori_layanan', '$Asman', '$jumlah', '$durasi')";
            $simpanHarian = mysqli_query($connect, $sqlharian);


        }

        $sql = "SELECT  `Asman`, `Kategori_layanan`, `jenis_produk`, substring(`Tanggal`, 1, 7) Bulan, COUNT(jumlah) jmlgangguan, SUM(`durasi`) drs FROM `log_harian` where import_id=$idImport";
        echo $sql;
        $query = mysqli_query($connect, $sql);
        while ($data = mysqli_fetch_array($query)) {
            $totaldrs = $data['jmlgangguan'];
            $freq = $data['drs'];
            if ($freq != 0 && $totaldrs != 0) {
                $id = $idImport;
                $Asman = $data['Asman'];
                $kategori_layanan = $data['Kategori_layanan'];
                $produk = $data['jenis_produk'];
                $avg = $totaldrs / $freq;
                $thbl = $data['Bulan'];

                $sql = "INSERT INTO rekap_bulanan (id, asman, kategori_layanan, produk, totaldrs, freq, rata_rata, thbl) VALUES ('$id', '$Asman', '$kategori_layanan', '$produk', '$totaldrs', '$freq', '$avg', '$thbl')";
                $simpanrekap = mysqli_query($connect, $sql);

            }
            
        }


        //header("Location: index2.php");
        exit();
   } catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    echo "Query Error: " . mysqli_error($connect);
   }
}
?>