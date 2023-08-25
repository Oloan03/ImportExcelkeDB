<?php 
require 'vendor/autoload.php';
include ('connect.php');

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
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

    $sql = "UPDATE data SET `No Tiket`='$no_tiket', `Nama Service`='$nama_service', `SID`='$sid', Produk='$produk', Bandwith='$bandwith', `Tiket Open`='$tiket_open', `Tiket Close`='$tiket_close', `Stop Clock (Durasi)`='$stop_clock', `Durasi (Jam)`='$durasi', `Durasi (Menit)`='$durasi_menit', Penyebab='$penyebab', `Action`='$action', Asman='$asman', `Kategori Layanan`='$kategori_layanan', `Unit PLN Pengguna`='$unit_users', `Jenis Gangguan`='$jenis_gangguan', `Detail Gangguan`='$detail_gangguan', `Lokasi Gangguan`='$lokasi_gangguan' WHERE No='$id'";
    if (mysqli_query($connect, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}
?>
