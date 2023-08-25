<?php 
include 'connect.php';

$data = json_decode(file_get_contents('php://input'), true);

foreach ($data as $item) {
    $IPVPN = $connect->real_escape_string($item['IP VPN']);
    $INTERNET = $connect->real_escape_string($item['INTERNET']);
    $CC = $connect->real_escape_string($item['Clear Channel']);
    $METRONET = $connect->real_escape_string($item['METRONET']);
    $VSATIP = $connect->real_escape_string($item['VSAT IP']);

    $sql = "INSERT INTO (`IP VPN`, `INTERNET`, `Clear Channel`, `METRONET`, `VSAT IP`) VALUES ('$IPVPN', '$INTERNET', '$CC', '$METRONET', '$VSATIP')";
    if ($connect->query($sql) !== true) {
        echo "Error: " . $sql . "<br>" . $connect->error;
    }
}

$connect->close();
echo json_encode(['message' => 'Data berhasil disimpan!']);
?>