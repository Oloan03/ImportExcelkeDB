<?php 
if (isset($_GET["date"])) {
    $selectedDate = $_GET["date"];
    $starOfMonth = date("Y-m-01", strtotime($selectedDate));
    $endOfMonth = date("Y-m-t", strtotime($selectedDate));

    include 'connect.php';
    $pdo = new PDO('mysql:host=localhost;dbname=DataGangguan', 'root', '');

    $query = "SELECT * FROM data where Tiket_Close BETWEEN '$stratOfMonth' AND '$endOfMonth'";
    $stmt = $pdo->query($query);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<table>';
    foreach ($dataPerTanggal as $tanggal => $data) {
        echo '<tr>';
        echo '<td>' . $tanggal . '</td>';
        echo '<td>' . $data['IP VPN']['SCADA NON REDUNDANT']['SUMBAR']['JMLG'] . '</td>';
        echo '<td>' . $data['IP VPN']['SCADA NON REDUNDANT']['SUMBAR']['DRS'] . '</td>';
        echo '<td>' . $data['IP VPN']['SCADA NON REDUNDANT']['JAMBI']['JMLG'] . '</td>';
        echo '<td>' . $data['IP VPN']['SCADA NON REDUNDANT']['JAMBI']['DRS'] . '</td>';
        echo '<td>' . $data['IP VPN']['NON SCADA']['SUMBAR']['JMLG'] . '</td>';
        echo '<td>' . $data['IP VPN']['NON SCADA']['SUMBAR']['DRS'] . '</td>';
        echo '<td>' . $data['IP VPN']['NON SCADA']['JAMBI']['JMLG'] . '</td>';
        echo '<td>' . $data['IP VPN']['NON SCADA']['JAMBI']['DRS'] . '</td>';
        echo '<td>' . $data['INTERNET']['SCADA NON REDUNDANT']['SUMBAR']['JMLG'] . '</td>';
        echo '<td>' . $data['INTERNET']['SCADA NON REDUNDANT']['SUMBAR']['DRS'] . '</td>';
        echo '<td>' . $data['INTERNET']['SCADA NON REDUNDANT']['JAMBI']['JMLG'] . '</td>';
        echo '<td>' . $data['INTERNET']['SCADA NON REDUNDANT']['JAMBI']['DRS'] . '</td>';
        echo '<td>' . $data['INTERNET']['NON SCADA']['SUMBAR']['JMLG'] . '</td>';
        echo '<td>' . $data['INTERNET']['NON SCADA']['SUMBAR']['DRS'] . '</td>';
        echo '<td>' . $data['INTERNET']['NON SCADA']['JAMBI']['JMLG'] . '</td>';
        echo '<td>' . $data['INTERNET']['NON SCADA']['JAMBI']['DRS'] . '</td>';
        echo '<td>' . $data['Clear Channel']['SCADA NON REDUNDANT']['SUMBAR']['JMLG'] . '</td>';
        echo '<td>' . $data['Clear Channel']['SCADA NON REDUNDANT']['SUMBAR']['DRS'] . '</td>';
        echo '<td>' . $data['Clear Channel']['SCADA NON REDUNDANT']['JAMBI']['JMLG'] . '</td>';
        echo '<td>' . $data['Clear Channel']['SCADA NON REDUNDANT']['JAMBI']['DRS'] . '</td>';
        echo '<td>' . $data['Clear Channel']['NON SCADA']['SUMBAR']['JMLG'] . '</td>';
        echo '<td>' . $data['Clear Channel']['NON SCADA']['SUMBAR']['DRS'] . '</td>';
        echo '<td>' . $data['Clear Channel']['NON SCADA']['JAMBI']['JMLG'] . '</td>';
        echo '<td>' . $data['Clear Channel']['NON SCADA']['JAMBI']['DRS'] . '</td>';
        echo '<td>' . $data['METRONET']['SCADA NON REDUNDANT']['SUMBAR']['JMLG'] . '</td>';
        echo '<td>' . $data['METRONET']['SCADA NON REDUNDANT']['SUMBAR']['DRS'] . '</td>';
        echo '<td>' . $data['METRONET']['SCADA NON REDUNDANT']['JAMBI']['JMLG'] . '</td>';
        echo '<td>' . $data['METRONET']['SCADA NON REDUNDANT']['JAMBI']['DRS'] . '</td>';
        echo '<td>' . $data['METRONET']['NON SCADA']['SUMBAR']['JMLG'] . '</td>';
        echo '<td>' . $data['METRONET']['NON SCADA']['SUMBAR']['DRS'] . '</td>';
        echo '<td>' . $data['METRONET']['NON SCADA']['JAMBI']['JMLG'] . '</td>';
        echo '<td>' . $data['METRONET']['NON SCADA']['JAMBI']['DRS'] . '</td>';
        echo '<td>' . $data['VSAT IP']['SCADA NON REDUNDANT']['SUMBAR']['JMLG'] . '</td>';
        echo '<td>' . $data['VSAT IP']['SCADA NON REDUNDANT']['SUMBAR']['DRS'] . '</td>';
        echo '<td>' . $data['VSAT IP']['SCADA NON REDUNDANT']['JAMBI']['JMLG'] . '</td>';
        echo '<td>' . $data['VSAT IP']['SCADA NON REDUNDANT']['JAMBI']['DRS'] . '</td>';
        echo '<td>' . $data['VSAT IP']['NON SCADA']['SUMBAR']['JMLG'] . '</td>';
        echo '<td>' . $data['VSAT IP']['NON SCADA']['SUMBAR']['DRS'] . '</td>';
        echo '<td>' . $data['VSAT IP']['NON SCADA']['JAMBI']['JMLG'] . '</td>';
        echo '<td>' . $data['VSAT IP']['NON SCADA']['JAMBI']['DRS'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
}
?>