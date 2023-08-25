

<!DOCTYPE html>
<html>
    <head>
        <title>Laporan Data Gangguan Jaringan Bulanan</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </head>
    <body>
        <div class="container">
            <div class="btn">
                <a id="backBtn" href="index.php"><i class="material-icons">arrow_back</i></a>
            </div>
            <h3>Laporan: </h3>
            
            <div class="export" id="export">
                <a class="exportfile" href="export.php?format=xlsx">Export ke Excel</a> |
                <a class="exportfile" href="export.php?format=pdf">Eksport ke PDF</a>
            </div>
            <?php 
            require 'vendor/autoload.php';
            function generateReport() {
                include 'connect.php';

                $data = mysqli_query($connect, "SELECT * FROM `laporan gangguan`");

                if (isset($_GET['month'])) {
                    $pilihBln = $_GET['month'];
                    $data = mysqli_query($connect, "SELECT * FROM `laporan gangguan` WHERE substr(`Tanggal`,6,2)=$pilihBln");
                } else {
                    $data = mysqli_query($connect, "SELECT * FROM `laporan gangguan`");
                }

                $pdo = new PDO('mysql:host=localhost;dbname=DataGangguan', 'root', '');
                $stmt = $pdo->query('SELECT * FROM data');
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $reportData = array();

                foreach ($data as $row) {
                    
                    $tanggal = substr($row['Tiket Close'], 0, 10);
                    $asman = $row['Asman'];
                    $jenis_produk = $row['Produk'];
                    $durasi_menit = ($row['Durasi (Menit)']);
                    $kategori_layanan = $row['Kategori Layanan'];
                    
                    if (!isset($reportData[$tanggal][$jenis_produk][$kategori_layanan][$asman]['JMLG'])) {
                        $reportData[$tanggal][$jenis_produk][$kategori_layanan][$asman]['JMLG'] = 1;
                        $reportData[$tanggal][$jenis_produk][$kategori_layanan][$asman]['DRS'] = $durasi_menit;
                    } else {
                        $reportData[$tanggal][$jenis_produk][$kategori_layanan][$asman]['JMLG']++;
                        $reportData[$tanggal][$jenis_produk][$kategori_layanan][$asman]['DRS'] += $durasi_menit;
                    } 
                }
                
                echo '<div class="content">';
                    echo '<div class="Bulanlist">
                            <ul>
                                <li><a href="?month=01">Januari</a></li> |
                                <li><a href="?month=02">Februari</a></li> |
                                <li><a href="?month=03">Maret</a></li> |
                                <li><a href="?month=04">April</a></li> |
                                <li><a href="?month=05">Mei</a></li> |
                                <li><a href="?month=06">Juni</a></li> |
                                <li><a href="?month=07">Juli</a></li> |
                                <li><a href="?month=08">Agustus</a></li> |
                                <li><a href="?month=09">September</a></li> |
                                <li><a href="?month=10">Okteber</a></li> |
                                <li><a href="?month=11">November</a></li> |
                                <li><a href="?month=12">Desember</a></li> 
                            </ul>
                        </div>';
                    echo '<div class="tabel-content" style="overflow-x: auto;">';
                        echo '<caption><b>DATA GANGGUAN LAYANAN JARINGAN PER HARI</b></caption>';
                            echo '<table border="1" id="laporan">';
                                echo '<tr>
                                        <th rowspan="3">Tanggal</th>
                                        <th colspan="4">IPVPN (SCADA)</th>
                                        <th colspan="4">IPVPN (NON SCADA)</th>
                                        <th colspan="4">INTERNET (SCADA)</th>
                                        <th colspan="4">INTERNET (NON SCADA)</th>
                                        <th colspan="4">CLEAR CHANNEL (SCADA)</th>
                                        <th colspan="4">CLEAR CHANNEL (NON SCADA)</th>
                                        <th colspan="4">METRONET (SCADA)</th>
                                        <th colspan="4">METRONET (NON SCADA)</th>
                                        <th colspan="4">VSAT IP (SCADA)</th>
                                        <th colspan="4">VSAT IP (NON SCADA)</th>
                                        <th colspan="4">TOTAL SCADA</th>
                                        <th colspan="4">TOTAL NON SCADA</th>
                                    </tr>
                                    <tr>
                                        <!-- Kolom IPVPN (SCADA) -->
                                        <th colspan="2">SUMBAR</th>
                                        <th colspan="2">JAMBI</th>
                                        <!-- Kolom IPVPN (NON SCADA) -->
                                        <th colspan="2">SUMBAR</th>
                                        <th colspan="2">JAMBI</th>
                                        <!-- Kolom INTERNET (SCADA) -->
                                        <th colspan="2">SUMBAR</th>
                                        <th colspan="2">JAMBI</th>
                                        <!-- Kolom INTERNET (NON SCADA) -->
                                        <th colspan="2">SUMBAR</th>
                                        <th colspan="2">JAMBI</th>
                                        <!-- Kolom CLEAR CHANNEL (SCADA) -->
                                        <th colspan="2">SUMBAR</th>
                                        <th colspan="2">JAMBI</th>
                                        <!-- Kolom CLEAR CHANNEL (NON SCADA) -->
                                        <th colspan="2">SUMBAR</th>
                                        <th colspan="2">JAMBI</th>
                                        <!-- Kolom METRONET (SCADA) -->
                                        <th colspan="2">SUMBAR</th>
                                        <th colspan="2">JAMBI</th>
                                        <!-- Kolom METRONET (NON SCADA) -->
                                        <th colspan="2">SUMBAR</th>
                                        <th colspan="2">JAMBI</th>
                                        <!-- Kolom VSAT IP (SCADA) -->
                                        <th colspan="2">SUMBAR</th>
                                        <th colspan="2">JAMBI</th>
                                        <!-- Kolom VSAT IP (NON SCADA) -->
                                        <th colspan="2">SUMBAR</th>
                                        <th colspan="2">JAMBI</th>
                                        <!-- Kolom TOTAL SCADA -->
                                        <th colspan="2">SUMBAR</th>
                                        <th colspan="2">JAMBI</th>
                                        <!-- Total NON SCADA -->
                                        <th colspan="2">SUMBAR</th>
                                        <th colspan="2">JAMBI</th>
                                    </tr>
                                    <tr>
                                        <!-- Kolom SUMBAR dan JAMBI untuk tiap kategori -->
                                        <th>JMLG</th>
                                        <th>DRS</th>
                                        <th>JMLG</th>
                                        <th>DRS</th>
                                        <th>JMLG</th>
                                        <th>DRS</th>
                                        <th>JMLG</th>
                                        <th>DRS</th>
                                        <th>JMLG</th>
                                        <th>DRS</th>
                                        <th>JMLG</th>
                                        <th>DRS</th>
                                        <th>JMLG</th>
                                        <th>DRS</th>
                                        <th>JMLG</th>
                                        <th>DRS</th>
                                        <th>JMLG</th>
                                        <th>DRS</th>
                                        <th>JMLG</th>
                                        <th>DRS</th>
                                        <th>JMLG</th>
                                        <th>DRS</th>
                                        <th>JMLG</th>
                                        <th>DRS</th>
                                        <th>JMLG</th>
                                        <th>DRS</th>
                                        <th>JMLG</th>
                                        <th>DRS</th>
                                        <th>JMLG</th>
                                        <th>DRS</th>
                                        <th>JMLG</th>
                                        <th>DRS</th>
                                        <th>JMLG</th>
                                        <th>DRS</th>
                                        <th>JMLG</th>
                                        <th>DRS</th>
                                        <th>JMLG</th>
                                        <th>DRS</th>
                                        <th>JMLG</th>
                                        <th>DRS</th>
                                        <th>JMLG</th>
                                        <th>DRS</th>
                                        <th>JMLG</th>
                                        <th>DRS</th>
                                        <th>JMLG</th>
                                        <th>DRS</th>
                                        <th>JMLG</th>
                                        <th>DRS</th>
                                    </tr>';

                                foreach ($reportData as $tanggal => $dataPerTanggal) {
                                    $totalScadaSumbarJMLG = 0;
                                    $totalScadaSumbarDRS = 0;
                                    $totalScadaJambiJMLG = 0;
                                    $totalScadaJambiDRS = 0;
                                    $totalNonScadaSumbarJMLG = 0;
                                    $totalNonScadaSumbarDRS = 0;
                                    $totalNonScadaJambiJMLG = 0;
                                    $totalNonScadaJambiDRS = 0;
                                    

                                    foreach (array('IP VPN', 'INTERNET', 'Clear Channel', 'METRONET', 'VSAT IP') as $kategori) {
                                        if (isset($dataPerTanggal[$kategori]['SCADA NON REDUNDANT']['SUMBAR']['JMLG'])) {
                                            $totalScadaSumbarJMLG += $dataPerTanggal[$kategori]['SCADA NON REDUNDANT']['SUMBAR']['JMLG'];
                                        } 
                                        if (isset($dataPerTanggal[$kategori]['SCADA NON REDUNDANT']['SUMBAR']['DRS'])) {
                                            $totalScadaSumbarDRS += $dataPerTanggal[$kategori]['SCADA NON REDUNDANT']['SUMBAR']['DRS'];
                                        }
                                        if (isset($dataPerTanggal[$kategori]['SCADA NON REDUNDANT']['JAMBI']['JMLG'])) {
                                            $totalScadaJambiJMLG += $dataPerTanggal[$kategori]['SCADA NON REDUNDANT']['JAMBI']['JMLG'];
                                        }
                                        if (isset($dataPerTanggal[$kategori]['SCADA NON REDUNDANT']['JAMBI']['DRS'])) {
                                            $totalScadaJambiDRS += $dataPerTanggal[$kategori]['SCADA NON REDUNDANT']['JAMBI']['DRS'];
                                        }
                                        if (isset($dataPerTanggal[$kategori]['NON SCADA']['SUMBAR']['JMLG'])) {
                                            $totalNonScadaSumbarJMLG += $dataPerTanggal[$kategori]['NON SCADA']['SUMBAR']['JMLG'];
                                        }
                                        if (isset($dataPerTanggal[$kategori]['NON SCADA']['SUMBAR']['DRS'])) {
                                            $totalNonScadaSumbarDRS += $dataPerTanggal[$kategori]['NON SCADA']['SUMBAR']['DRS'];
                                        }
                                        if (isset($dataPerTanggal[$kategori]['NON SCADA']['JAMBI']['JMLG'])) {
                                            $totalNonScadaJambiJMLG += $dataPerTanggal[$kategori]['NON SCADA']['JAMBI']['JMLG'];
                                        }
                                        if (isset($dataPerTanggal[$kategori]['NON SCADA']['JAMBI']['DRS'])) {
                                            $totalNonScadaJambiDRS += $dataPerTanggal[$kategori]['NON SCADA']['JAMBI']['DRS'];
                                        }
                                    }

                                    $ipvpn_scada_sumbar_jmlg = (isset($dataPerTanggal['IP VPN']['SCADA NON REDUNDANT']['SUMBAR']['JMLG']) ? $dataPerTanggal['IP VPN']['SCADA NON REDUNDANT']['SUMBAR']['JMLG'] : 0);
                                    $ipvpn_scada_sumbar_drs = (isset($dataPerTanggal['IP VPN']['SCADA NON REDUNDANT']['SUMBAR']['DRS']) ? $dataPerTanggal['IP VPN']['SCADA NON REDUNDANT']['SUMBAR']['DRS'] : 0);
                                    $ipvpn_scada_jambi_jmlg = (isset($dataPerTanggal['IP VPN']['SCADA NON REDUNDANT']['JAMBI']['JMLG']) ? $dataPerTanggal['IP VPN']['SCADA NON REDUNDANT']['JAMBI']['JMLG'] : 0);
                                    $ipvpn_scada_jambi_drs = (isset($dataPerTanggal['IP VPN']['SCADA NON REDUNDANT']['JAMBI']['DRS']) ? $dataPerTanggal['IP VPN']['SCADA NON REDUNDANT']['JAMBI']['DRS'] : 0);
                                    $ipvpn_non_scada_sumbar_jmlg = (isset($dataPerTanggal['IP VPN']['NON SCADA']['SUMBAR']['JMLG']) ? $dataPerTanggal['IP VPN']['NON SCADA']['SUMBAR']['JMLG'] : 0);
                                    $ipvpn_non_scada_sumbar_drs = (isset($dataPerTanggal['IP VPN']['NON SCADA']['SUMBAR']['DRS']) ? $dataPerTanggal['IP VPN']['NON SCADA']['SUMBAR']['DRS'] : 0);
                                    $ipvpn_non_scada_jambi_jmlg = (isset($dataPerTanggal['IP VPN']['NON SCADA']['JAMBI']['JMLG']) ? $dataPerTanggal['IP VPN']['NON SCADA']['JAMBI']['JMLG'] : 0);
                                    $ipvpn_non_scada_jambi_drs = (isset($dataPerTanggal['IP VPN']['NON SCADA']['JAMBI']['DRS']) ? $dataPerTanggal['IP VPN']['NON SCADA']['JAMBI']['DRS'] : 0);
                                    $internet_scada_sumbar_jmlg = (isset($dataPerTanggal['INTERNET']['SCADA NON REDUNDANT']['SUMBAR']['JMLG']) ? $dataPerTanggal['INTERNET']['SCADA NON REDUNDANT']['SUMBAR']['JMLG'] : 0);
                                    $internet_scada_sumbar_drs = (isset($dataPerTanggal['INTERNET']['SCADA NON REDUNDANT']['SUMBAR']['DRS']) ? $dataPerTanggal['INTERNET']['SCADA NON REDUNDANT']['SUMBAR']['DRS'] : 0);
                                    $internet_scada_jambi_jmlg = (isset($dataPerTanggal['INTERNET']['SCADA NON REDUNDANT']['JAMBI']['JMLG']) ? $dataPerTanggal['INTERNET']['SCADA NON REDUNDANT']['JAMBI']['JMLG'] : 0);
                                    $internet_scada_jambi_drs = (isset($dataPerTanggal['INTERNET']['SCADA NON REDUNDANT']['JAMBI']['DRS']) ? $dataPerTanggal['INTERNET']['SCADA NON REDUNDANT']['JAMBI']['DRS'] : 0);
                                    $internet_non_scada_sumbar_jmlg = (isset($dataPerTanggal['INTERNET']['NON SCADA']['SUMBAR']['JMLG']) ? $dataPerTanggal['INTERNET']['NON SCADA']['SUMBAR']['JMLG'] : 0);
                                    $internet_non_scada_sumbar_drs = (isset($dataPerTanggal['INTERNET']['NON SCADA']['SUMBAR']['DRS']) ? $dataPerTanggal['INTERNET']['NON SCADA']['SUMBAR']['DRS'] : 0);
                                    $internet_non_scada_jambi_jmlg = (isset($dataPerTanggal['INTERNET']['NON SCADA']['JAMBI']['JMLG']) ? $dataPerTanggal['INTERNET']['NON SCADA']['JAMBI']['JMLG'] : 0);
                                    $internet_non_scada_jambi_drs = (isset($dataPerTanggal['INTERNET']['NON SCADA']['JAMBI']['DRS']) ? $dataPerTanggal['INTERNET']['NON SCADA']['JAMBI']['DRS'] : 0);
                                    $clear_channel_scada_sumbar_jmlg = (isset($dataPerTanggal['Clear Channel']['SCADA NON REDUNDANT']['SUMBAR']['JMLG']) ? $dataPerTanggal['Clear Channel']['SCADA NON REDUNDANT']['SUMBAR']['JMLG'] : 0);
                                    $clear_channel_scada_sumbar_drs = (isset($dataPerTanggal['Clear Channel']['SCADA NON REDUNDANT']['SUMBAR']['DRS']) ? $dataPerTanggal['Clear Channel']['SCADA NON REDUNDANT']['SUMBAR']['DRS'] : 0);
                                    $clear_channel_scada_jambi_jmlg = (isset($dataPerTanggal['Clear Channel']['SCADA NON REDUNDANT']['JAMBI']['JMLG']) ? $dataPerTanggal['Clear Channel']['SCADA NON REDUNDANT']['JAMBI']['JMLG'] : 0);
                                    $clear_channel_scada_jambi_drs = (isset($dataPerTanggal['Clear Channel']['SCADA NON REDUNDANT']['JAMBI']['DRS']) ? $dataPerTanggal['Clear Channel']['SCADA NON REDUNDANT']['JAMBI']['DRS'] : 0);
                                    $clear_channel_non_scada_sumbar_jmlg = (isset($dataPerTanggal['Clear Channel']['NON SCADA']['SUMBAR']['JMLG']) ? $dataPerTanggal['Clear Channel']['NON SCADA']['SUMBAR']['JMLG'] : 0);
                                    $clear_channel_non_scada_sumbar_drs = (isset($dataPerTanggal['Clear Channel']['NON SCADA']['SUMBAR']['DRS']) ? $dataPerTanggal['Clear Channel']['NON SCADA']['SUMBAR']['DRS'] : 0);
                                    $clear_channel_non_scada_jambi_jmlg = (isset($dataPerTanggal['Clear Channel']['NON SCADA']['JAMBI']['JMLG']) ? $dataPerTanggal['Clear Channel']['NON SCADA']['JAMBI']['JMLG'] : 0);
                                    $clear_channel_non_scada_jambi_drs = (isset($dataPerTanggal['Clear Channel']['NON SCADA']['JAMBI']['DRS']) ? $dataPerTanggal['Clear Channel']['NON SCADA']['JAMBI']['DRS'] : 0);
                                    $metronet_scada_sumbar_jmlg = (isset($dataPerTanggal['METRONET']['SCADA NON REDUNDANT']['SUMBAR']['JMLG']) ? $dataPerTanggal['METRONET']['SCADA NON REDUNDANT']['SUMBAR']['JMLG'] : 0);
                                    $metronet_scada_sumbar_drs = (isset($dataPerTanggal['METRONET']['SCADA NON REDUNDANT']['SUMBAR']['DRS']) ? $dataPerTanggal['METRONET']['SCADA NON REDUNDANT']['SUMBAR']['DRS'] : 0);
                                    $metronet_scada_jambi_jmlg = (isset($dataPerTanggal['METRONET']['SCADA NON REDUNDANT']['JAMBI']['JMLG']) ? $dataPerTanggal['METRONET']['SCADA NON REDUNDANT']['JAMBI']['JMLG'] : 0);
                                    $metronet_scada_jambi_drs = (isset($dataPerTanggal['METRONET']['SCADA NON REDUNDANT']['JAMBI']['DRS']) ? $dataPerTanggal['METRONET']['SCADA NON REDUNDANT']['JAMBI']['DRS'] : 0);
                                    $metronet_non_scada_sumbar_jmlg = (isset($dataPerTanggal['METRONET']['NON SCADA']['SUMBAR']['JMLG']) ? $dataPerTanggal['METRONET']['NON SCADA']['SUMBAR']['JMLG'] : 0);
                                    $metronet_non_scada_sumbar_drs = (isset($dataPerTanggal['METRONET']['NON SCADA']['SUMBAR']['DRS']) ? $dataPerTanggal['METRONET']['NON SCADA']['SUMBAR']['DRS'] : 0);
                                    $metronet_non_scada_jambi_jmlg = (isset($dataPerTanggal['METRONET']['NON SCADA']['JAMBI']['JMLG']) ? $dataPerTanggal['METRONET']['NON SCADA']['JAMBI']['JMLG'] : 0);
                                    $metronet_non_scada_jambi_drs = (isset($dataPerTanggal['METRONET']['NON SCADA']['JAMBI']['DRS']) ? $dataPerTanggal['METRONET']['NON SCADA']['JAMBI']['DRS'] : 0);
                                    $vsatip_scada_sumbar_jmlg = (isset($dataPerTanggal['VSAT IP']['SCADA NON REDUNDANT']['SUMBAR']['JMLG']) ? $dataPerTanggal['VSAT IP']['SCADA NON REDUNDANT']['SUMBAR']['JMLG'] : 0);
                                    $vsatip_scada_sumbar_drs = (isset($dataPerTanggal['VSAT IP']['SCADA NON REDUNDANT']['SUMBAR']['DRS']) ? $dataPerTanggal['VSAT IP']['SCADA NON REDUNDANT']['SUMBAR']['DRS'] : 0);
                                    $vsatip_scada_jambi_jmlg = (isset($dataPerTanggal['VSAT IP']['SCADA NON REDUNDANT']['JAMBI']['JMLG']) ? $dataPerTanggal['VSAT IP']['SCADA NON REDUNDANT']['JAMBI']['JMLG'] : 0);
                                    $vsatip_scada_jambi_drs = (isset($dataPerTanggal['VSAT IP']['SCADA NON REDUNDANT']['JAMBI']['DRS']) ? $dataPerTanggal['VSAT IP']['SCADA NON REDUNDANT']['JAMBI']['DRS'] : 0);
                                    $vsatip_non_scada_sumbar_jmlg = (isset($dataPerTanggal['VSAT IP']['NON SCADA']['SUMBAR']['JMLG']) ? $dataPerTanggal['VSAT IP']['NON SCADA']['SUMBAR']['JMLG'] : 0);
                                    $vsatip_non_scada_sumbar_drs = (isset($dataPerTanggal['VSAT IP']['NON SCADA']['SUMBAR']['DRS']) ? $dataPerTanggal['VSAT IP']['NON SCADA']['SUMBAR']['DRS'] : 0);
                                    $vsatip_non_scada_jambi_jmlg = (isset($dataPerTanggal['VSAT IP']['NON SCADA']['JAMBI']['JMLG']) ? $dataPerTanggal['VSAT IP']['NON SCADA']['JAMBI']['JMLG'] : 0);
                                    $vsatip_non_scada_jambi_drs = (isset($dataPerTanggal['VSAT IP']['NON SCADA']['JAMBI']['DRS']) ? $dataPerTanggal['VSAT IP']['NON SCADA']['JAMBI']['DRS'] : 0);

                                    $sqli = "INSERT INTO `laporan gangguan` (`Tanggal`, `IPVPN (SCADA) SUMBAR_JMLG`, `IPVPN (SCADA) SUMBAR_DRS`, `IPVPN (SCADA) JAMBI_JMLG`, `IPVPN (SCADA) JAMBI_DRS`, `IPVPN (NON SCADA) SUMBAR_JMLG`, `IPVPN (NON SCADA) SUMBAR_DRS`, `IPVPN (NON SCADA) JAMBI_JMLG`, `IPVPN (NON SCADA) JAMBI_DRS`, `INTERNET (SCADA) SUMBAR_JMLG`, `INTERNET (SCADA) SUMBAR_DRS`, `INTERNET (SCADA) JAMBI_JMLG`, `INTERNET (SCADA) JAMBI_DRS`, `INTERNET (NON SCADA) SUMBAR_JMLG`, `INTERNET (NON SCADA) SUMBAR_DRS`, `INTERNET (NON SCADA) JAMBI_JMLG`, `INTERNET (NON SCADA) JAMBI_DRS`, `Clear Channel (SCADA) SUMBAR_JMLG`, `Clear Channel (SCADA) SUMBAR_DRS`, `Clear Channel (SCADA) JAMBI_JMLG`, `Clear Channel (SCADA) JAMBI_DRS`, `Clear Channel (NON SCADA) SUMBAR_JMLG`, `Clear Channel (NON SCADA) SUMBAR_DRS`, `Clear Channel (NON SCADA) JAMBI_JMLG`, `Clear Channel (NON SCADA) JAMBI_DRS`, `METRONET (SCADA) SUMBAR_JMLG`, `METRONET (SCADA) SUMBAR_DRS`, `METRONET (SCADA) JAMBI_JMLG`, `METRONET (SCADA) JAMBI_DRS`, `METRONET (NON SCADA) SUMBAR_JMLG`, `METRONET (NON SCADA) SUMBAR_DRS`, `METRONET (NON SCADA) JAMBI_JMLG`, `METRONET (NON SCADA) JAMBI_DRS`, `VSAT IP (SCADA) SUMBAR_JMLG`, `VSAT IP (SCADA) SUMBAR_DRS`, `VSAT IP (SCADA) JAMBI_JMLG`, `VSAT IP (SCADA) JAMBI_DRS`, `VSAT IP (NON SCADA) SUMBAR_JMLG`, `VSAT IP (NON SCADA) SUMBAR_DRS`, `VSAT IP (NON SCADA) JAMBI_JMLG`, `VSAT IP (NON SCADA) JAMBI_DRS`, `TOTAL SCADA SUMBAR_JMLG`, `TOTAL SCADA SUMBAR_DRS`, `TOTAL SCADA JAMBI_JMLG`, `TOTAL SCADA JAMBI_DRS`, `TOTAL NON SCADA SUMBAR_JMLG`, `TOTAL NON SCADA SUMBAR_DRS`, `TOTAL NON SCADA JAMBI_JMLG`, `TOTAL NON SCADA JAMBI_DRS`)
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                                    $stmt = $connect->prepare($sqli);
                                    $stmt->bind_param("siiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii", $tanggal, $ipvpn_scada_sumbar_jmlg, $ipvpn_scada_sumbar_drs, $ipvpn_scada_jambi_jmlg, $ipvpn_scada_jambi_drs, $ipvpn_non_scada_sumbar_jmlg, $ipvpn_non_scada_sumbar_drs, $ipvpn_non_scada_jambi_jmlg, $ipvpn_non_scada_jambi_drs,
                                            $internet_scada_sumbar_jmlg, $internet_scada_sumbar_drs, $internet_scada_jambi_jmlg, $internet_scada_jambi_drs, $internet_non_scada_sumbar_jmlg, $internet_non_scada_sumbar_drs, $internet_non_scada_jambi_jmlg, $internet_non_scada_jambi_drs,
                                            $clear_channel_scada_sumbar_jmlg, $clear_channel_scada_sumbar_drs, $clear_channel_scada_jambi_jmlg, $clear_channel_scada_jambi_drs, $clear_channel_non_scada_sumbar_jmlg, $clear_channel_non_scada_sumbar_drs, $clear_channel_non_scada_jambi_jmlg, $clear_channel_non_scada_jambi_drs,
                                            $metronet_scada_sumbar_jmlg, $metronet_scada_sumbar_drs, $metronet_scada_jambi_jmlg, $metronet_scada_jambi_drs, $metronet_non_scada_sumbar_jmlg, $metronet_non_scada_sumbar_drs, $metronet_non_scada_jambi_jmlg, $metronet_non_scada_jambi_drs,
                                            $vsatip_scada_sumbar_jmlg, $vsatip_scada_sumbar_drs, $vsatip_scada_jambi_jmlg, $vsatip_scada_jambi_drs, $vsatip_non_scada_sumbar_jmlg, $vsatip_non_scada_sumbar_drs, $vsatip_non_scada_jambi_jmlg, $vsatip_non_scada_jambi_drs,
                                            $totalScadaSumbarJMLG, $totalScadaSumbarDRS, $totalScadaJambiJMLG, $totalScadaJambiDRS, $totalNonScadaSumbarJMLG, $totalNonScadaSumbarDRS, $totalNonScadaJambiJMLG, $totalNonScadaJambiDRS);
                                    if ($stmt->execute()) {
                                        echo '';
                                    } else {
                                        echo 'Error: ' . $stmt->error;
                                    }
                                    $stmt->close();
                                    
                                    echo '<tr>';
                                    echo '<td>' . $tanggal . '</td>';
                                    echo '<td>' . $ipvpn_scada_sumbar_jmlg . '</td>';
                                    echo '<td>' . $ipvpn_scada_sumbar_drs . '</td>';
                                    echo '<td>' . $ipvpn_scada_jambi_jmlg . '</td>';
                                    echo '<td>' . $ipvpn_scada_jambi_drs . '</td>';
                                    echo '<td>' . $ipvpn_non_scada_sumbar_jmlg . '</td>';
                                    echo '<td>' . $ipvpn_non_scada_sumbar_drs . '</td>';
                                    echo '<td>' . $ipvpn_non_scada_jambi_jmlg . '</td>';
                                    echo '<td>' . $ipvpn_non_scada_jambi_drs . '</td>';
                                    echo '<td>' . $internet_scada_sumbar_jmlg . '</td>';
                                    echo '<td>' . $internet_scada_sumbar_drs . '</td>';
                                    echo '<td>' . $internet_scada_jambi_jmlg . '</td>';
                                    echo '<td>' . $internet_scada_jambi_drs . '</td>';
                                    echo '<td>' . $internet_non_scada_sumbar_jmlg . '</td>';
                                    echo '<td>' . $internet_non_scada_sumbar_drs . '</td>';
                                    echo '<td>' . $internet_non_scada_jambi_jmlg . '</td>';
                                    echo '<td>' . $internet_non_scada_jambi_drs . '</td>';
                                    echo '<td>' . $clear_channel_scada_sumbar_jmlg . '</td>';
                                    echo '<td>' . $clear_channel_scada_sumbar_drs . '</td>';
                                    echo '<td>' . $clear_channel_scada_jambi_jmlg . '</td>';
                                    echo '<td>' . $clear_channel_scada_jambi_drs . '</td>';
                                    echo '<td>' . $clear_channel_non_scada_sumbar_jmlg . '</td>';
                                    echo '<td>' . $clear_channel_non_scada_sumbar_drs . '</td>';
                                    echo '<td>' . $clear_channel_non_scada_jambi_jmlg . '</td>';
                                    echo '<td>' . $clear_channel_non_scada_jambi_drs . '</td>';
                                    echo '<td>' . $metronet_scada_sumbar_jmlg . '</td>';
                                    echo '<td>' . $metronet_scada_sumbar_drs . '</td>';
                                    echo '<td>' . $metronet_scada_jambi_jmlg . '</td>';
                                    echo '<td>' . $metronet_scada_jambi_drs . '</td>';
                                    echo '<td>' . $metronet_non_scada_sumbar_jmlg . '</td>';
                                    echo '<td>' . $metronet_non_scada_sumbar_drs . '</td>';
                                    echo '<td>' . $metronet_non_scada_jambi_jmlg . '</td>';
                                    echo '<td>' . $metronet_non_scada_jambi_drs . '</td>';
                                    echo '<td>' . $vsatip_scada_sumbar_jmlg . '</td>';
                                    echo '<td>' . $vsatip_scada_sumbar_drs . '</td>';
                                    echo '<td>' . $vsatip_scada_jambi_jmlg . '</td>';
                                    echo '<td>' . $vsatip_scada_jambi_drs . '</td>';
                                    echo '<td>' . $vsatip_non_scada_sumbar_jmlg . '</td>';
                                    echo '<td>' . $vsatip_non_scada_sumbar_drs . '</td>';
                                    echo '<td>' . $vsatip_non_scada_jambi_jmlg . '</td>';
                                    echo '<td>' . $vsatip_non_scada_jambi_drs . '</td>';
                                    echo '<td>' . $totalScadaSumbarJMLG . '</td>';
                                    echo '<td>' . $totalScadaSumbarDRS . '</td>';
                                    echo '<td>' . $totalScadaJambiJMLG . '</td>';
                                    echo '<td>' . $totalScadaJambiDRS . '</td>';
                                    echo '<td>' . $totalNonScadaSumbarJMLG . '</td>';
                                    echo '<td>' . $totalNonScadaSumbarDRS . '</td>';
                                    echo '<td>' . $totalNonScadaJambiJMLG . '</td>';
                                    echo '<td>' . $totalNonScadaJambiDRS . '</td>';
                                    echo '</tr>';
                                }
                                    echo '<tr>';
                                    echo '<td>Total</td>';
                                    foreach (array('IP VPN', 'INTERNET', 'Clear Channel', 'METRONET', 'VSAT IP') as $kategori) {
                                        foreach (array('SCADA NON REDUNDANT', 'NON SCADA') as $jenis) {
                                            foreach (array('SUMBAR', 'JAMBI') as $lokasi) {
                                                $totalJMLG = 0;
                                                $totalDRS = 0;

                                                foreach ($reportData as $dataPerTanggal) {
                                                    if (isset($dataPerTanggal[$kategori][$jenis][$lokasi]['JMLG'])) {
                                                        $totalJMLG += $dataPerTanggal[$kategori][$jenis][$lokasi]['JMLG'];
                                                    }
                                                    if (isset($dataPerTanggal[$kategori][$jenis][$lokasi]['DRS'])) {
                                                        $totalDRS += $dataPerTanggal[$kategori][$jenis][$lokasi]['DRS'];
                                                    }
                                                }

                                                echo '<td>' . $totalJMLG . '</td>';
                                                echo '<td>' . $totalDRS . '</td>';
                                            }
                                        }
                                    }
                                    
                                    $sqli = "INSERT INTO `laporan gangguan` (`Tanggal`, `IPVPN (SCADA) SUMBAR_JMLG`, `IPVPN (SCADA) SUMBAR_DRS`, `IPVPN (SCADA) JAMBI_JMLG`, `IPVPN (SCADA) JAMBI_DRS`, `IPVPN (NON SCADA) SUMBAR_JMLG`, `IPVPN (NON SCADA) SUMBAR_DRS`, `IPVPN (NON SCADA) JAMBI_JMLG`, `IPVPN (NON SCADA) JAMBI_DRS`, `INTERNET (SCADA) SUMBAR_JMLG`, `INTERNET (SCADA) SUMBAR_DRS`, `INTERNET (SCADA) JAMBI_JMLG`, `INTERNET (SCADA) JAMBI_DRS`, `INTERNET (NON SCADA) SUMBAR_JMLG`, `INTERNET (NON SCADA) SUMBAR_DRS`, `INTERNET (NON SCADA) JAMBI_JMLG`, `INTERNET (NON SCADA) JAMBI_DRS`, `Clear Channel (SCADA) SUMBAR_JMLG`, `Clear Channel (SCADA) SUMBAR_DRS`, `Clear Channel (SCADA) JAMBI_JMLG`, `Clear Channel (SCADA) JAMBI_DRS`, `Clear Channel (NON SCADA) SUMBAR_JMLG`, `Clear Channel (NON SCADA) SUMBAR_DRS`, `Clear Channel (NON SCADA) JAMBI_JMLG`, `Clear Channel (NON SCADA) JAMBI_DRS`, `METRONET (SCADA) SUMBAR_JMLG`, `METRONET (SCADA) SUMBAR_DRS`, `METRONET (SCADA) JAMBI_JMLG`, `METRONET (SCADA) JAMBI_DRS`, `METRONET (NON SCADA) SUMBAR_JMLG`, `METRONET (NON SCADA) SUMBAR_DRS`, `METRONET (NON SCADA) JAMBI_JMLG`, `METRONET (NON SCADA) JAMBI_DRS`, `VSAT IP (SCADA) SUMBAR_JMLG`, `VSAT IP (SCADA) SUMBAR_DRS`, `VSAT IP (SCADA) JAMBI_JMLG`, `VSAT IP (SCADA) JAMBI_DRS`, `VSAT IP (NON SCADA) SUMBAR_JMLG`, `VSAT IP (NON SCADA) SUMBAR_DRS`, `VSAT IP (NON SCADA) JAMBI_JMLG`, `VSAT IP (NON SCADA) JAMBI_DRS`, `TOTAL SCADA SUMBAR_JMLG`, `TOTAL SCADA SUMBAR_DRS`, `TOTAL SCADA JAMBI_JMLG`, `TOTAL SCADA JAMBI_DRS`, `TOTAL NON SCADA SUMBAR_JMLG`, `TOTAL NON SCADA SUMBAR_DRS`, `TOTAL NON SCADA JAMBI_JMLG`, `TOTAL NON SCADA JAMBI_DRS`)
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                                    $stmt = $connect->prepare($sqli);
                                    $stmt->bind_param("siiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii", $tanggal, $ipvpn_scada_sumbar_jmlg, $ipvpn_scada_sumbar_drs, $ipvpn_scada_jambi_jmlg, $ipvpn_scada_jambi_drs, $ipvpn_non_scada_sumbar_jmlg, $ipvpn_non_scada_sumbar_drs, $ipvpn_non_scada_jambi_jmlg, $ipvpn_non_scada_jambi_drs,
                                            $internet_scada_sumbar_jmlg, $internet_scada_sumbar_drs, $internet_scada_jambi_jmlg, $internet_scada_jambi_drs, $internet_non_scada_sumbar_jmlg, $internet_non_scada_sumbar_drs, $internet_non_scada_jambi_jmlg, $internet_non_scada_jambi_drs,
                                            $clear_channel_scada_sumbar_jmlg, $clear_channel_scada_sumbar_drs, $clear_channel_scada_jambi_jmlg, $clear_channel_scada_jambi_drs, $clear_channel_non_scada_sumbar_jmlg, $clear_channel_non_scada_sumbar_drs, $clear_channel_non_scada_jambi_jmlg, $clear_channel_non_scada_jambi_drs,
                                            $metronet_scada_sumbar_jmlg, $metronet_scada_sumbar_drs, $metronet_scada_jambi_jmlg, $metronet_scada_jambi_drs, $metronet_non_scada_sumbar_jmlg, $metronet_non_scada_sumbar_drs, $metronet_non_scada_jambi_jmlg, $metronet_non_scada_jambi_drs,
                                            $vsatip_scada_sumbar_jmlg, $vsatip_scada_sumbar_drs, $vsatip_scada_jambi_jmlg, $vsatip_scada_jambi_drs, $vsatip_non_scada_sumbar_jmlg, $vsatip_non_scada_sumbar_drs, $vsatip_non_scada_jambi_jmlg, $vsatip_non_scada_jambi_drs,
                                            $totalScadaSumbarJMLG, $totalScadaSumbarDRS, $totalScadaJambiJMLG, $totalScadaJambiDRS, $totalNonScadaSumbarJMLG, $totalNonScadaSumbarDRS, $totalNonScadaJambiJMLG, $totalNonScadaJambiDRS);
                                    if ($stmt->execute()) {
                                        echo '';
                                        
                                    } else {
                                        echo 'Error: ' . $stmt->error;
                                    }
                                    $stmt->close();

                                // Total dari kolom "TOTAL SCADA" dan "TOTAL NON SCADA"
                                $totalScadaSumbarJMLG = 0;
                                $totalScadaSumbarDRS = 0;
                                $totalScadaJambiJMLG = 0;
                                $totalScadaJambiDRS = 0;
                                $totalNonScadaSumbarJMLG = 0;
                                $totalNonScadaSumbarDRS = 0;
                                $totalNonScadaJambiJMLG = 0;
                                $totalNonScadaJambiDRS = 0;

                                foreach ($reportData as $dataPerTanggal) {
                                    foreach (array('IP VPN', 'INTERNET', 'Clear Channel', 'METRONET', 'VSAT IP') as $kategori) {
                                        if (isset($dataPerTanggal[$kategori]['SCADA NON REDUNDANT']['SUMBAR']['JMLG'])) {
                                            $totalScadaSumbarJMLG += $dataPerTanggal[$kategori]['SCADA NON REDUNDANT']['SUMBAR']['JMLG'];
                                        }
                                        if (isset($dataPerTanggal[$kategori]['SCADA NON REDUNDANT']['SUMBAR']['DRS'])) {
                                            $totalScadaSumbarDRS += $dataPerTanggal[$kategori]['SCADA NON REDUNDANT']['SUMBAR']['DRS'];
                                        }
                                        if (isset($dataPerTanggal[$kategori]['SCADA NON REDUNDANT']['JAMBI']['JMLG'])) {
                                            $totalScadaJambiJMLG += $dataPerTanggal[$kategori]['SCADA NON REDUNDANT']['JAMBI']['JMLG'];
                                        }
                                        if (isset($dataPerTanggal[$kategori]['SCADA NON REDUNDANT']['JAMBI']['DRS'])) {
                                            $totalScadaJambiDRS += $dataPerTanggal[$kategori]['SCADA NON REDUNDANT']['JAMBI']['DRS'];
                                        }
                                        if (isset($dataPerTanggal[$kategori]['NON SCADA']['SUMBAR']['JMLG'])) {
                                            $totalNonScadaSumbarJMLG += $dataPerTanggal[$kategori]['NON SCADA']['SUMBAR']['JMLG'];
                                        }
                                        if (isset($dataPerTanggal[$kategori]['NON SCADA']['SUMBAR']['DRS'])) {
                                            $totalNonScadaSumbarDRS += $dataPerTanggal[$kategori]['NON SCADA']['SUMBAR']['DRS'];
                                        }
                                        if (isset($dataPerTanggal[$kategori]['NON SCADA']['JAMBI']['JMLG'])) {
                                            $totalNonScadaJambiJMLG += $dataPerTanggal[$kategori]['NON SCADA']['JAMBI']['JMLG'];
                                        }
                                        if (isset($dataPerTanggal[$kategori]['NON SCADA']['JAMBI']['DRS'])) {
                                            $totalNonScadaJambiDRS += $dataPerTanggal[$kategori]['NON SCADA']['JAMBI']['DRS'];
                                        }
                                    }
                                }

                                $sqli = "INSERT INTO `laporan gangguan` (`Tanggal`, `IPVPN (SCADA) SUMBAR_JMLG`, `IPVPN (SCADA) SUMBAR_DRS`, `IPVPN (SCADA) JAMBI_JMLG`, `IPVPN (SCADA) JAMBI_DRS`, `IPVPN (NON SCADA) SUMBAR_JMLG`, `IPVPN (NON SCADA) SUMBAR_DRS`, `IPVPN (NON SCADA) JAMBI_JMLG`, `IPVPN (NON SCADA) JAMBI_DRS`, `INTERNET (SCADA) SUMBAR_JMLG`, `INTERNET (SCADA) SUMBAR_DRS`, `INTERNET (SCADA) JAMBI_JMLG`, `INTERNET (SCADA) JAMBI_DRS`, `INTERNET (NON SCADA) SUMBAR_JMLG`, `INTERNET (NON SCADA) SUMBAR_DRS`, `INTERNET (NON SCADA) JAMBI_JMLG`, `INTERNET (NON SCADA) JAMBI_DRS`, `Clear Channel (SCADA) SUMBAR_JMLG`, `Clear Channel (SCADA) SUMBAR_DRS`, `Clear Channel (SCADA) JAMBI_JMLG`, `Clear Channel (SCADA) JAMBI_DRS`, `Clear Channel (NON SCADA) SUMBAR_JMLG`, `Clear Channel (NON SCADA) SUMBAR_DRS`, `Clear Channel (NON SCADA) JAMBI_JMLG`, `Clear Channel (NON SCADA) JAMBI_DRS`, `METRONET (SCADA) SUMBAR_JMLG`, `METRONET (SCADA) SUMBAR_DRS`, `METRONET (SCADA) JAMBI_JMLG`, `METRONET (SCADA) JAMBI_DRS`, `METRONET (NON SCADA) SUMBAR_JMLG`, `METRONET (NON SCADA) SUMBAR_DRS`, `METRONET (NON SCADA) JAMBI_JMLG`, `METRONET (NON SCADA) JAMBI_DRS`, `VSAT IP (SCADA) SUMBAR_JMLG`, `VSAT IP (SCADA) SUMBAR_DRS`, `VSAT IP (SCADA) JAMBI_JMLG`, `VSAT IP (SCADA) JAMBI_DRS`, `VSAT IP (NON SCADA) SUMBAR_JMLG`, `VSAT IP (NON SCADA) SUMBAR_DRS`, `VSAT IP (NON SCADA) JAMBI_JMLG`, `VSAT IP (NON SCADA) JAMBI_DRS`, `TOTAL SCADA SUMBAR_JMLG`, `TOTAL SCADA SUMBAR_DRS`, `TOTAL SCADA JAMBI_JMLG`, `TOTAL SCADA JAMBI_DRS`, `TOTAL NON SCADA SUMBAR_JMLG`, `TOTAL NON SCADA SUMBAR_DRS`, `TOTAL NON SCADA JAMBI_JMLG`, `TOTAL NON SCADA JAMBI_DRS`)
                                        VALUES ($tanggal, $ipvpn_scada_sumbar_jmlg, $ipvpn_scada_sumbar_drs, $ipvpn_scada_jambi_jmlg, $ipvpn_scada_jambi_drs, $ipvpn_non_scada_sumbar_jmlg, $ipvpn_non_scada_sumbar_drs, $ipvpn_non_scada_jambi_jmlg, $ipvpn_non_scada_jambi_drs,
                                        $internet_scada_sumbar_jmlg, $internet_scada_sumbar_drs, $internet_scada_jambi_jmlg, $internet_scada_jambi_drs, $internet_non_scada_sumbar_jmlg, $internet_non_scada_sumbar_drs, $internet_non_scada_jambi_jmlg, $internet_non_scada_jambi_drs,
                                        $clear_channel_scada_sumbar_jmlg, $clear_channel_scada_sumbar_drs, $clear_channel_scada_jambi_jmlg, $clear_channel_scada_jambi_drs, $clear_channel_non_scada_sumbar_jmlg, $clear_channel_non_scada_sumbar_drs, $clear_channel_non_scada_jambi_jmlg, $clear_channel_non_scada_jambi_drs,
                                        $metronet_scada_sumbar_jmlg, $metronet_scada_sumbar_drs, $metronet_scada_jambi_jmlg, $metronet_scada_jambi_drs, $metronet_non_scada_sumbar_jmlg, $metronet_non_scada_sumbar_drs, $metronet_non_scada_jambi_jmlg, $metronet_non_scada_jambi_drs,
                                        $vsatip_scada_sumbar_jmlg, $vsatip_scada_sumbar_drs, $vsatip_scada_jambi_jmlg, $vsatip_scada_jambi_drs, $vsatip_non_scada_sumbar_jmlg, $vsatip_non_scada_sumbar_drs, $vsatip_non_scada_jambi_jmlg, $vsatip_non_scada_jambi_drs,
                                        $totalScadaSumbarJMLG, $totalScadaSumbarDRS, $totalScadaJambiJMLG, $totalScadaJambiDRS, $totalNonScadaSumbarJMLG, $totalNonScadaSumbarDRS, $totalNonScadaJambiJMLG, $totalNonScadaJambiDRS)";
                            

                                echo '<td>' . $totalScadaSumbarJMLG . '</td>';
                                echo '<td>' . $totalScadaSumbarDRS . '</td>';
                                echo '<td>' . $totalScadaJambiJMLG . '</td>';
                                echo '<td>' . $totalScadaJambiDRS . '</td>';
                                echo '<td>' . $totalNonScadaSumbarJMLG . '</td>';
                                echo '<td>' . $totalNonScadaSumbarDRS . '</td>';
                                echo '<td>' . $totalNonScadaJambiJMLG . '</td>';
                                echo '<td>' . $totalNonScadaJambiDRS . '</td>';

                                echo '</tr>';

                                
                            echo '</table>';
                        echo '</div>';
                        ?>
                        <?php $data = mysqli_query($connect, "SELECT * FROM `laporan gangguan`"); ?>
                        
                        <div class="tabelperBln">
                            <table id="mytabe" border="1">
                                <tr>
                                    <th rowspan="4">Tanggal</th>
                                    <th colspan="4">IP VPN (SCADA)</th>
                                </tr>
                                <tr>
                                    <th colspan="2">SUMBAR</th>
                                    <th colspan="2">JAMBI</th>
                                </tr>
                                <tr>
                                    <th>JMLG</th>
                                    <th>DRS</th>
                                    <th>JMLG</th>
                                    <th>DRS</th>
                                </tr>
                                <?php 
                                while ($d = mysqli_fetch_array($data)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $d['Tanggal']; ?></td>
                                        <td><?php echo $d['IPVPN (SCADA) SUMBAR_JMLG'] ?></td>
                                        <td><?php echo $d['IPVPN (SCADA) SUMBAR_DRS'] ?></td>
                                        <td><?php echo $d['IPVPN (SCADA) JAMBI_JMLG'] ?></td>
                                        <td><?php echo $d['IPVPN (SCADA) JAMBI_DRS'] ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                        </div>

                <?php
                    echo '<br/>';

                    echo '<div class="laporanljs">';
                        echo '<div class="tabelSumbar">';
                            echo '<p><b>LAPORAN LAYANAN JARINGAN OPTI SUMBAR</b></p>';
                                echo '<table border="1">
                                        <caption><b>Layanan Jaringan NON SCADA</b></caption>
                                        <tr>
                                            <th></th>
                                            <th>IP VPN</th>
                                            <th>INTERNET</th>
                                            <th>Clear Channel</th>
                                            <th>METRONET</th>
                                            <th>VSAT IP</th>
                                            <th>AKUMULASI</th>
                                        </tr>
                                        <tr>
                                            <th>Total Durasi Gangguan</th>';
                                            $totalsumbarNonScadaDrsakum = 0;
                                            foreach (array('IP VPN', 'INTERNET', 'Clear Channel', 'METRONET', 'VSAT IP') as $kategori) {
                                                $totalsumbarNonScadaDrs = 0;
                                                foreach ($reportData as $tanggalData) {
                                                    if (isset($tanggalData[$kategori]['NON SCADA']['SUMBAR']['DRS'])) {
                                                        $totalsumbarNonScadaDrs += round($tanggalData[$kategori]['NON SCADA']['SUMBAR']['DRS'] / 60);
                                                        
                                                    }
                                                }
                                                ${"totalsumbarNonScadaDrs_" . str_replace(" ", "_", strtoupper($kategori))} = $totalsumbarNonScadaDrs;
                                                $totalsumbarNonScadaDrsakum += $totalsumbarNonScadaDrs;
                                                echo '<td>' . $totalsumbarNonScadaDrs . '</td>';
                                            }
                                            echo '<td>' . $totalsumbarNonScadaDrsakum . '</td>';
                                            $queryTotal = "INSERT INTO ljnssumbar (Gangguan, `IP VPN`, `INTERNET`, `Clear Channel`, `METRONET`, `VSAT IP`, AKUMULASI) Values ('Total Durasi Gangguan', '$totalsumbarNonScadaDrs_IP_VPN', '$totalsumbarNonScadaDrs_INTERNET', '$totalsumbarNonScadaDrs_CLEAR_CHANNEL', '$totalsumbarNonScadaDrs_METRONET', '$totalsumbarNonScadaDrs_VSAT_IP', '$totalNonScadaDrsakum')";
                                                if ( mysqli_query($connect, $queryTotal)) {
                                                    echo "";
                                                } else {
                                                    echo "Error: " . mysqli_error($connect);
                                                }
                                            
                                    echo '</tr>
                                        <tr>
                                            <th>Frekuensi Gangguan</th>';
                                            $totalsumbarNonScadaFreqsum = 0;
                                            foreach(array('IP VPN', 'INTERNET', 'Clear Channel', 'METRONET', 'VSAT IP') as $kategori) {
                                                $totalsumbarNonScadaFreq = 0;
                                                foreach ($reportData as $tanggalData) {
                                                    if (isset($tanggalData[$kategori]['NON SCADA']['SUMBAR']['JMLG'])) {
                                                        $totalsumbarNonScadaFreq += $tanggalData[$kategori]['NON SCADA']['SUMBAR']['JMLG'];
                                                    }
                                                }
                                                ${"totalsumbarNonScadaFreq_" . str_replace(" ", "_", strtoupper($kategori))} = $totalsumbarNonScadaFreq;
                                                $totalsumbarNonScadaFreqsum += $totalsumbarNonScadaFreq;
                                                echo '<td>' . $totalsumbarNonScadaFreq . '</td>';
                                            }
                                            echo '<td>' . $totalsumbarNonScadaFreqsum . '</td>';
                                            $queryFreq = "INSERT INTO ljnssumbar (Gangguan, `IP VPN`, `INTERNET`, `Clear Channel`, `METRONET`, `VSAT IP`, AKUMULASI) VALUES ('Frequensi Gangguan', '$totalsumbarNonScadaFreq_IP_VPN', '$totalsumbarNonScadaFreq_INTERNET', '$totalsumbarNonScadaFreq_CLEAR_CHANNEL', '$totalsumbarNonScadaFreq_METRONET', '$totalsumbarNonScadaFreq_VSAT_IP', '$totalsumbarNonScadaFreqsum')";
                                                    if (mysqli_query($connect, $queryFreq)) {
                                                        echo "";
                                                    } else {
                                                        echo "Error: " . mysqli_error($connect);
                                                    }
                                    echo '</tr>
                                        <tr>
                                            <th>Rata-rata Durasi Gangguan</th>';
                                            $rataRataNonScadasumbarsum = 0;
                                            $totalsumbarNonScadaRataKategori = array(); // Buat array untuk menyimpan total rata-rata untuk masing-masing kategori

                                            foreach (array('IP VPN', 'INTERNET', 'Clear Channel', 'METRONET', 'VSAT IP') as $kategori) {
                                                $totalsumbarNonScadaRataRataDurasi = 0;
                                                $jumlahsumbarNonScadaFrekuensi = 0;

                                                foreach ($reportData as $tanggalData) {
                                                    if (isset($tanggalData[$kategori]['NON SCADA']['SUMBAR']['JMLG']) && isset($tanggalData[$kategori]['NON SCADA']['SUMBAR']['DRS'])) {
                                                        $totalsumbarNonScadaRataRataDurasi += ($tanggalData[$kategori]['NON SCADA']['SUMBAR']['DRS'] / $tanggalData[$kategori]['NON SCADA']['SUMBAR']['JMLG']) / 60;
                                                        $jumlahsumbarNonScadaFrekuensi++;
                                                    }
                                                }

                                                if ($jumlahsumbarNonScadaFrekuensi > 0) {
                                                    $rataRatasumbarNonScada = $totalsumbarNonScadaRataRataDurasi / $jumlahsumbarNonScadaFrekuensi;
                                                    echo '<td>' . $rataRatasumbarNonScada . '</td>';
                                                } else {
                                                    $rataRatasumbarNonScada = 0;
                                                    echo '<td>' . $rataRatasumbarNonScada . '</td>';
                                                }
                                                
                                                $totalsumbarNonScadaRataKategori[str_replace(" ", "_", strtoupper($kategori))] = $rataRatasumbarNonScada;
                                            }

                                            if ($totalsumbarNonScadaFreqsum != 0) {
                                                $rataRataNonScadasumbarsum = ($totalNonScadaDrsakum / $totalsumbarNonScadaFreqsum) / 60;
                                                echo '<td>' . $rataRataNonScadasumbarsum . '</td>';
                                            } else {
                                                echo '<td>' . 0 . '</td>';
                                            }

                                            $queryRata = "INSERT INTO ljnssumbar (Gangguan, `IP VPN`, `INTERNET`, `Clear Channel`, `METRONET`, `VSAT IP`, AKUMULASI)
                                                        VALUES ('Rata-rata Durasi Gangguan', '{$totalsumbarNonScadaRataKategori['IP_VPN']}', '{$totalsumbarNonScadaRataKategori['INTERNET']}', '{$totalsumbarNonScadaRataKategori['CLEAR_CHANNEL']}', '{$totalsumbarNonScadaRataKategori['METRONET']}', '{$totalsumbarNonScadaRataKategori['VSAT_IP']}', '$rataRataNonScadasumbarsum')";

                                            if (mysqli_query($connect, $queryRata)) {
                                                echo "";
                                            } else {
                                                echo "Error: " . mysqli_error($connect);
                                            }

                                            
                                    echo '</tr>';

                                echo '</table>';
                                
                                echo '<br/>';
                                echo '<table border="1">
                                        <caption><b>Layanan Jaringan SCADA</b></caption>
                                        <tr>
                                            <th></th>
                                            <th>IP VPN</th>
                                            <th>INTERNET</th>
                                            <th>Clear Channel</th>
                                            <th>METRONET</th>
                                            <th>VSAT IP</th>
                                            <th>AKUMULASI</th>
                                        </tr>
                                        <tr>
                                            <th>Total Durasi Gangguan</th>';
                                            $totalScadasumbarDrsakum = 0;
                                            foreach (array('IP VPN', 'INTERNET', 'Clear Channel', 'METRONET', 'VSAT IP') as $kategori) {
                                                $totalScadasumbarDrs = 0;
                                                foreach ($reportData as $tanggalData) {
                                                    if (isset($tanggalData[$kategori]['SCADA NON REDUNDANT']['SUMBAR']['DRS'])) {
                                                        $totalScadasumbarDrs += $tanggalData[$kategori]['SCADA NON REDUNDANT']['SUMBAR']['DRS'];
                                                    }
                                                }
                                                ${"totalScadasumbarDrs_" . str_replace(" ", "_", strtoupper($kategori))} = $totalScadasumbarDrs;
                                                $totalScadasumbarDrsakum += $totalScadasumbarDrs;
                                                echo '<td>' . $totalScadasumbarDrs . '</td>';
                                            }
                                            echo '<td>' . $totalScadasumbarDrsakum . '</td>';

                                            $queryTotal = "INSERT INTO ljssumbar (Gangguan, `IP VPN`, `INTERNET`, `Clear Channel`, `METRONET`, `VSAT IP`, AKUMULASI) Values ('Total Durasi Gangguan', '$totalScadasumbarDrs_IP_VPN', '$totalScadasumbarDrs_INTERNET', '$totalScadasumbarDrs_CLEAR_CHANNEL', '$totalScadasumbarDrs_METRONET', '$totalScadasumbarDrs_VSAT_IP', '$totalScadasumbarDrsakum')";
                                                if ( mysqli_query($connect, $queryTotal)) {
                                                    echo "";
                                                } else {
                                                    echo "Error: " . mysqli_error($connect);
                                                }
                                        echo '</tr>
                                            <tr>
                                                <th>Frekuensi Gangguan</th>';
                                                $totalScadasumbarFreqsum = 0;
                                                foreach (array('IP VPN', 'INTERNET', 'Clear Channel', 'METRONET', 'VSAT IP') as $kategori) {
                                                    $totalScadasumbarFreq = 0;
                                                    foreach ($reportData as $tanggalData) {
                                                        if (isset($tanggalData[$kategori]['SCADA NON REDUNDANT']['SUMBAR']['JMLG'])) {
                                                            $totalScadasumbarFreq += $tanggalData[$kategori]['SCADA NON REDUNDANT']['SUMBAR']['JMLG'];
                                                        }
                                                    }
                                                    ${"totalScadasumbarFreq_" . str_replace(" ", "_", strtoupper($kategori))} = $totalScadasumbarFreq;
                                                    $totalScadasumbarFreqsum += $totalScadasumbarFreq;
                                                    echo '<td>' . $totalScadasumbarFreq . '</td>';
                                                }
                                                echo '<td>' . $totalScadasumbarFreqsum . '</td>';
                                                $queryFreq = "INSERT INTO ljssumbar (Gangguan, `IP VPN`, `INTERNET`, `Clear Channel`, `METRONET`, `VSAT IP`, AKUMULASI) VALUES ('Frequensi Gangguan', '$totalScadasumbarFreq_IP_VPN', '$totalScadasumbarFreq_INTERNET', '$totalScadasumbarFreq_CLEAR_CHANNEL', '$totalScadasumbarFreq_METRONET', '$totalScadasumbarFreq_VSAT_IP', '$totalScadasumbarFreqsum')";
                                                    if (mysqli_query($connect, $queryFreq)) {
                                                        echo "";
                                                    } else {
                                                        echo "Error: " . mysqli_error($connect);
                                                    }
                                        echo '</tr>
                                            <tr>
                                                <th>Rata-rata Durasi Gangguan</th>';
                                                $rataRataScadasumbarsum = 0;
                                                foreach (array('IP VPN', 'INTERNET', 'Clear Channel', 'METRONET', 'VSAT IP') as $kategori) {
                                                    $totalRataRataScadasumbarDurasi = 0;
                                                    $jumlahScadasumbarFrekuensi = 0;
                                                    foreach ($reportData as $tanggalData) {
                                                        if (isset($tanggalData[$kategori]['SCADA NON REDUNDANT']['SUMBAR']['JMLG']) && isset($tanggalData[$kategori]['SCADA NON REDUNDANT']['SUMBAR']['DRS'])) {
                                                            $totalRataRataScadasumbarDurasi += $tanggalData[$kategori]['SCADA NON REDUNDANT']['SUMBAR']['DRS'] / $tanggalData[$kategori]['SCADA NON REDUNDANT']['SUMBAR']['JMLG'];
                                                            $jumlahScadasumbarFrekuensi++;
                                                        }
                                                    }
                                                    if ($jumlahScadasumbarFrekuensi > 0) {
                                                        $rataRataScadasumbar = $totalRataRataScadasumbarDurasi / $jumlahScadasumbarFrekuensi;
                                                        echo '<td>' . $rataRataScadasumbar . '</td>';
                                                    } else {
                                                        echo '<td>' . 0 . '</td>';
                                                    }
                                                    ${"totalRataScadasumbar_" . str_replace(" ", "_", strtoupper($kategori))} = $rataRataScadasumbar;
                                                }
                                                if ($totalScadasumbarFreqsum != 0) {
                                                    $rataRataScadasumbarsum = ($totalScadaDrsakum / $totalScadasumbarFreqsum) / 60;
                                                    echo '<td>' . $rataRataScadasumbarsum . '</td>';
                                                } else {
                                                    echo '</td>' . 0 . '</td>';
                                                }
                                                $queryRata = "INSERT INTO ljssumbar (Gangguan, `IP VPN`, `INTERNET`, `Clear Channel`, `METRONET`, `VSAT IP`, AKUMULASI) VALUES ('Rata-rata Durasi Gangguan', '$totalRataScadasumbar_IP_VPN', '$totalRataScadasumbar_INTERNET', '$totalRataScadasumbar_CLEAR_CHANNEL', '$totalRataScadasumbar_METRONET', '$totalRataScadasumbar_VSAT_IP', '$rataRataScadasumbarsum')";
                                                    if (mysqli_query($connect, $queryRata)) {
                                                        echo "";
                                                    } else {
                                                        echo "Error: " . mysqli_error($connect);
                                                    }
                                                
                                        echo '</tr>';
                                echo '</table>';
                            echo '</div>';

                        echo '<br/> <br/>';

                            echo '<div class="tabelJambi">';
                                include 'connect.php';
                                echo '<p><b>LAPORAN LAYANAN JARINGAN OPTI JAMBI</b></p>';
                                    echo '<table border="1">
                                            <caption><b>Layanan Jaringan NON SCADA</b></caption>
                                            <tr>
                                                <th></th>
                                                <th>IP VPN</th>
                                                <th>INTERNET</th>
                                                <th>Clear Channel</th>
                                                <th>METRONET</th>
                                                <th>VSAT IP</th>
                                                <th>AKUMULASI</th>
                                            </tr>
                                            <tr>
                                                <th>Total Durasi Gangguan</th>';
                                                $totaljambiNonScadaDrsakum = 0;
                                                foreach(array('IP VPN', 'INTERNET', 'Clear Channel', 'METRONET', 'VSAT IP') as $kategori) {
                                                    $totaljambiNonScadaDrs = 0;
                                                    foreach ($reportData as $tanggalData) {
                                                        if (isset($tanggalData[$kategori]['NON SCADA']['JAMBI']['DRS'])) {
                                                            $totaljambiNonScadaDrs += round($tanggalData[$kategori]['NON SCADA']['JAMBI']['DRS'] / 60);
                                                        }
                                                    }
                                                    ${"totaljambiNonScadaDrs_" . str_replace(" ", "_", strtoupper($kategori))} = $totaljambiNonScadaDrs;

                                                    $totaljambiNonScadaDrsakum += $totaljambiNonScadaDrs;
                                                    echo '<td>' . $totaljambiNonScadaDrs . '</td>';
                                                }
                                                echo '<td>' . $totaljambiNonScadaDrsakum . '</td>';

                                                $queryTotal = "INSERT INTO ljnsjambi (Gangguan, `IP VPN`, `INTERNET`, `Clear Channel`, `METRONET`, `VSAT IP`, AKUMULASI) Values ('Total Durasi Gangguan', '$totaljambiNonScadaDrs_IP_VPN', '$totaljambiNonScadaDrs_INTERNET', '$totaljambiNonScadaDrs_CLEAR_CHANNEL', '$totaljambiNonScadaDrs_METRONET', '$totaljambiNonScadaDrs_VSAT_IP', '$totaljambiNonScadaDrsakum')";
                                                if ( mysqli_query($connect, $queryTotal)) {
                                                    echo "";
                                                } else {
                                                    echo "Error: " . mysqli_error($connect);
                                                }
                                            echo '</tr>
                                                <tr>
                                                    <th>Frekuensi Gangguan</th>';
                                                    $totaljambiNonScadaFreqsum = 0;
                                                    foreach (array('IP VPN', 'INTERNET', 'Clear Channel', 'METRONET', 'VSAT IP') as $kategori) {
                                                        $totaljambiNonScadaFreq = 0;
                                                        foreach($reportData as $tanggalData) {
                                                            if (isset($tanggalData[$kategori]['NON SCADA']['JAMBI']['JMLG'])) {
                                                                $totaljambiNonScadaFreq += $tanggalData[$kategori]['NON SCADA']['JAMBI']['JMLG'];
                                                            }
                                                        }
                                                        ${"totaljambiNonScadaFreq_" . str_replace(" ", "_", strtoupper($kategori))} = $totaljambiNonScadaFreq;
                                                        $totaljambiNonScadaFreqsum += $totaljambiNonScadaFreq;
                                                        echo '<td>' . $totaljambiNonScadaFreq . '</td>';
                                                    }
                                                    echo '<td>' . $totaljambiNonScadaFreqsum . '</td>';
                                                    $queryFreq = "INSERT INTO ljnsjambi (Gangguan, `IP VPN`, `INTERNET`, `Clear Channel`, `METRONET`, `VSAT IP`, AKUMULASI) VALUES ('Frequensi Gangguan', '$totaljambiNonScadaFreq_IP_VPN', '$totaljambiNonScadaFreq_INTERNET', '$totaljambiNonScadaFreq_CLEAR_CHANNEL', '$totaljambiNonScadaFreq_METRONET', '$totaljambiNonScadaFreq_VSAT_IP', '$totaljambiNonScadaFreqsum')";
                                                    if (mysqli_query($connect, $queryFreq)) {
                                                        echo "";
                                                    } else {
                                                        echo "Error: " . mysqli_error($connect);
                                                    }
                                            echo '</tr>
                                                <tr>
                                                    <th>Rata-rata Durasi Gangguan</th>';
                                                    $rataRatajambiNonScadasum = 0;
                                                    foreach (array('IP VPN', 'INTERNET', 'Clear Channel', 'METRONET', 'VSAT IP') as $kategori) {
                                                        $totalRataRatajambiNonScadaDurasi = 0;
                                                        $jumlahJambiNonScadaFrekuensi = 0;
                                                        foreach ($reportData as $tanggalData) {
                                                            if (isset($tanggalData[$kategori]['NON SCADA']['JAMBI']['JMLG']) && isset($tanggalData[$kategori]['NON SCADA']['JAMBI']['DRS'])) {
                                                                $totalRataRatajambiNonScadaDurasi += ($tanggalData[$kategori]['NON SCADA']['JAMBI']['DRS'] / $tanggalData[$kategori]['NON SCADA']['JAMBI']['JMLG']);
                                                                $jumlahjambiNonScadaFrekuensi++;
                                                            }
                                                        }
                                                        if ($totaljambiNonScadaFreqsum > 0) {
                                                            $rataRata = ($totalRataRatajambiNonScadaDurasi / $totaljambiNonScadaFreqsum) / 60;
                                                            echo '<td>' . $rataRata . '</td>';
                                                        } else {
                                                            echo '<td>' . 0 . '</td>';
                                                        }
                                                        ${"totalRata_" . str_replace(" ", "_", strtoupper($kategori))} = $rataRata;
                                                    }
                                                    
                                                    if ($totalFreqsum != 0) {
                                                        $rataRatasum = ($totalNonScadaDrsakum / $totalFreqsum) / 60;
                                                        echo '<td>' . $rataRatasum . '</td>';
                                                    } else {
                                                        echo "<td>" . 0 . "</td>";
                                                    }
                                                    $queryRata = "INSERT INTO ljnsjambi (Gangguan, `IP VPN`, `INTERNET`, `Clear Channel`, `METRONET`, `VSAT IP`, AKUMULASI) VALUES ('Rata-rata Durasi Gangguan', '$totalRata_IP_VPN', '$totalRata_INTERNET', '$totalRata_CLEAR_CHANNEL', '$totalRata_METRONET', '$totalRata_VSAT_IP', '$rataRatasum')";
                                                    if (mysqli_query($connect, $queryRata)) {
                                                        echo "";
                                                    } else {
                                                        echo "Error: " . mysqli_error($connect);
                                                    }
                                            echo '</tr>';
                                    echo '</table>';

                                    echo '<br/>';

                                    echo '<table border="1">
                                            <caption><b>Layanan Jaringan SCADA</b></caption>
                                            <tr>
                                                <th></th>
                                                <th>IP VPN</th>
                                                <th>INTERNET</th>
                                                <th>Clear Channel</th>
                                                <th>METRONET</th>
                                                <th>VSAT IP</th>
                                                <th>AKUMULASI</th>
                                            </tr>
                                            <tr>
                                                <th>Total Durasi Gangguan</th>';
                                                $totalScadaDrsakum = 0;
                                                foreach(array('IP VPN', 'INTERNET', 'Clear Channel', 'METRONET', 'VSAT IP') as $kategori) {
                                                    $totalScadaDrs = 0;
                                                    foreach ($reportData as $tanggalData) {
                                                        if (isset($tanggalData[$kategori]['SCADA NON REDUNDANT']['JAMBI']['DRS'])) {
                                                            $totalScadaDrs += $tanggalData[$kategori]['SCADA NON REDUNDANT']['JAMBI']['DRS'];
                                                        }
                                                    }
                                                    ${"totalScadaDrs_" . str_replace(" ", "_", strtoupper($kategori))} = $totalScadaDrs;
                                                    $totalScadaDrsakum += $totalScadaDrs;
                                                    echo '<td>' . $totalScadaDrs . '</td>';
                                                }
                                                echo '<td>' . $totalScadaDrsakum . '</td>';

                                                $queryTotal = "INSERT INTO ljsjambi (Gangguan, `IP VPN`, `INTERNET`, `Clear Channel`, `METRONET`, `VSAT IP`, AKUMULASI) Values ('Total Durasi Gangguan', '$totalScadaDrs_IP_VPN', '$totalScadaDrs_INTERNET', '$totalScadaDrs_CLEAR_CHANNEL', '$totalScadaDrs_METRONET', '$totalScadaDrs_VSAT_IP', '$totalScadaDrsakum')";
                                                if ( mysqli_query($connect, $queryTotal)) {
                                                    echo "";
                                                } else {
                                                    echo "Error: " . mysqli_error($connect);
                                                }
                                        echo '</tr>
                                            <tr>
                                                <th>Frekuensi Gangguan</th>';
                                                $totalFreqsum = 0;
                                                foreach (array('IP VPN', 'INTERNET', 'Clear Channel', 'METRONET', 'VSAT IP') as $kategori) {
                                                    $totalFreq = 0;
                                                    foreach ($reportData as $tanggalData) {
                                                        if (isset($tanggalData[$kategori]['SCADA NON REDUNDANT']['JAMBI']['JMLG'])) {
                                                            $totalFreq += $tanggalData[$kategori]['SCADA NON REDUNDANT']['JAMBI']['JMLG'];
                                                        }
                                                    }
                                                    ${"totalFreq_" . str_replace(" ", "_", strtoupper($kategori))} = $totalFreq;
                                                    $totalFreqsum += $totalFreq;
                                                    echo '<td>' . $totalFreq . '</td>';
                                                }
                                                echo '<td>' . $totalFreqsum . '</td>';
                                                $queryFreq = "INSERT INTO ljsjambi (Gangguan, `IP VPN`, `INTERNET`, `Clear Channel`, `METRONET`, `VSAT IP`, AKUMULASI) VALUES ('Frequensi Gangguan', '$totalFreq_IP_VPN', '$totalFreq_INTERNET', '$totalFreq_CLEAR_CHANNEL', '$totalFreq_METRONET', '$totalFreq_VSAT_IP', '$totalFreqsum')";
                                                    if (mysqli_query($connect, $queryFreq)) {
                                                        echo "";
                                                    } else {
                                                        echo "Error: " . mysqli_error($connect);
                                                    }
                                        echo '</tr>
                                            <tr>
                                                <th>Rata-rata Durasi Gangguan</th>';
                                                $rataRatasum = 0;
                                                foreach (array('IP VPN', 'INTERNET', 'Clear Channel', 'METRONET', 'VSAT IP') as $kategori) {
                                                    $totalRataRataDurasi = 0;
                                                    $jumlahFrekuensi = 0;
                                                    foreach ($reportData as $tanggalData) {
                                                        if (isset($tanggalData[$kategori]['SCADA NON REDUNDANT']['JAMBI']['JMLG']) && isset($tanggalData[$kategori]['SCADA NON REDUNDANT']['JAMBI']['DRS'])) {
                                                            $totalRataRataDurasi += $tanggalData[$kategori]['SCADA NON REDUNDANT']['JAMBI']['DRS'] / $tanggalData[$kategori]['SCADA NON REDUNDANT']['JAMBI']['JMLG'];
                                                            $jumlahFrekuensi++;
                                                        }
                                                    }
                                                    if ($jumlahFrekuensi > 0) {
                                                        $rataRata = $totalRataRataDurasi / $jumlahFrekuensi;
                                                        echo '<td>'. $rataRata . '</td>';
                                                    } else {
                                                        echo '<td>'. 0 . '</td>'; 
                                                    }
                                                    ${"totalRata_" . str_replace(" ", "_", strtoupper($kategori))} = $rataRata;
                                                }
                                                if ($totalFreqsum != 0) {
                                                    $rataRatasum = ($totalScadaDrsakum / $totalFreqsum) / 60;
                                                    echo '<td>' . $rataRatasum . '</td>';
                                                } else {
                                                    echo '<td>' . 0 . '</td>';
                                                }
                                                $queryRata = "INSERT INTO ljsjambi (Gangguan, `IP VPN`, `INTERNET`, `Clear Channel`, `METRONET`, `VSAT IP`, AKUMULASI) VALUES ('Rata-rata Durasi Gangguan', '$totalRata_IP_VPN', '$totalRata_INTERNET', '$totalRata_CLEAR_CHANNEL', '$totalRata_METRONET', '$totalRata_VSAT_IP', '$rataRatasum')";
                                                    if (mysqli_query($connect, $queryRata)) {
                                                        echo "";
                                                    } else {
                                                        echo "Error: " . mysqli_error($connect);
                                                    }
                                        echo '</tr>';
                                    echo '</table>';
                            echo '</div>';
                            echo '<div class="tabelSumbarJambi"';
                                    echo '<p><b>LAPORAN LAYANAN JARINGAN OPTI SUMBAR JAMBI</b></p>';
                                    echo '<table border="1"
                                            <caption><b>Layanan Jaringan NON SCADA</b></caption>
                                            <tr>
                                                <th></th>
                                                <th>IP VPN</th>
                                                <th>INTERNET</th>
                                                <th>Clear Channel</th>
                                                <th>METRONET</th>
                                                <th>VSAT IP</th>
                                                <th>AKUMULASI</th>
                                            </tr>
                                            <tr>
                                                <th>Total Durasi Gangguan</th>';
                                                $totalNonScadaDrsakum = 0;
                                                
                    echo '</div>';
                
                $reset = "ALTER TABLE `laporan gangguan` AUTO_INCREMENT = 1";
                mysqli_query($connect, $reset);
                $connect->close();
                echo '</div>';
            }


            generateReport();
            ?>
            <div class="floating-btn">
                    <button class="scroll-btn1" onclick="scrollToTop()"><i class="material-icons">&#xE5d8;</i></button>
                    <button class="scroll-btn2" onclick="scrollToBottom()"><i class="material-icons">&#xE5db;</i></button>
            </div>
                <script>
                    function scrollToTop() {
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    }

                    function scrollToBottom() {
                        window.scrollTo({
                            top: document.body.scrollHeight,
                            behavior: 'smooth'
                        });
                    }
                </script>
        </div>
    </body>
</html>
