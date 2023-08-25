<?php 
include ('connect.php');

$delete_Data = "DELETE FROM `data`";
mysqli_query($connect, $delete_Data);

//$delete_laporan = "DELETE FROM `Laporan gangguan`";
//mysqli_query($connect, $delete_laporan);

header('Location: index.php');
exit();
?>