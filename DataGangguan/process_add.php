<?php 
require 'vendor/autoload.php';
include ('connect.php');

if (isset($_POST["submit"])) {
    $no_tiket = $_POST['No_Tiket'];
    $nama_service = $_POST['Nama_Service'];
    $sid = $_POST['SID'];
    $produk = $_POST['Produk'];
    $bandwith = $_POST['Bandwith'];
    $tiket_open = $_POST['Tiket_Open'];
    $tiket_close = $_POST['Tiket_Close'];
    $stop_clock = $_POST['Stop_Clock_Durasi'];
    $durasi = $_POST['Durasi_Jam'];
    $durasi_menit = $_POST['Durasi_Menit'];
    $penyebab = $_POST['Penyebab'];
    $action = $_POST['Action'];
    $asman = $_POST['Asman'];
    $kategori_layanan = $_POST['Kategori_Layanan'];
    $unit_users = $_POST['Unit_PLN_Pengguna'];
    $jenis_gangguan = $_POST['Jenis_Gangguan'];
    $detail_gangguan = $_POST['Detail_Gangguan'];
    $lokasi_gangguan = $_POST['Lokasi_Gangguan'];

    $sql = "INSERT INTO `data` (`No Tiket`, `Nama Service`, `SID`, Produk, Bandwith, `Tiket Open`, `Tiket Close`, `Stop Clock (Durasi)`, `Durasi (Jam)`, `Durasi (Menit)`, Penyebab, `Action`, Asman, `Kategori Layanan`, `Unit PLN Pengguna`, `Jenis Gangguan`, `Detail Gangguan`, `Lokasi Gangguan`) VALUES ('$no_tiket', '$nama_service', '$sid', '$produk', '$bandwith', '$tiket_open', '$tiket_close', '$stop_clock', '$durasi', '$durasi_menit', '$penyebab', '$action', '$asman', '$kategori_layanan', '$unit_users', '$jenis_gangguan', '$detail_gangguan', '$lokasi_gangguan')";
    if (mysqli_query($connect, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}
?>
