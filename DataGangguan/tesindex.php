<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <title>Import data ke MySQL</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </head>
    <body>
        <div class="container">
            <h2>IMPORT DATA EXCEL KE DATABASE</h2>
            <div class="upfile">
                <form method="post" enctype="multipart/form-data" action="import.php">
                    Pilih file excel:
                    <input type="file" name="file" required="required">
                    <button type="submit" name="submit" class="upload"><i class='material-icons'>upload_file</i></button>
                </form>
            </div>
            <br/><br/>
            <div class="navbtn">
                <a href="index.php">
                    <span class="button-text">Log Harian</span>
                    <i class="material-icons">&#xf1be;</i>
                </a>
            </div>
            <div class="Bulan" id="Bulan">
                    <ul>
                        <li><a href="?month=01">Januari</a></li>
                        <li><a href="?month=02">Februari</a></li>
                        <li><a href="?month=03">Maret</a></li>
                        <li><a href="?month=04">April</a></li>
                        <li><a href="?month=05">Mei</a></li>
                        <li><a href="?month=06">Juni</a></li>
                        <li><a href="?month=07">Juli</a></li>
                        <li><a href="?month=08">Agustus</a></li>
                        <li><a href="?month=09">September</a></li>
                        <li><a href="?month=10">Oktober</a></li>
                        <li><a href="?month=11">November</a></li>
                        <li><a href="?month=12">Desember</a></li>
                    </ul>
                </div>
        </div>

        <?php

use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;

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

                                $sqli = "INSERT INTO `laporan gangguan` (`Tanggal`, `IPVPN (SCADA) SUMBAR_JMLG`, `IPVPN (SCADA) SUMBAR_DRS`, `IPVPN (SCADA) JAMBI_JMLG`, `IPVPN (SCADA) JAMBI_DRS`, `IPVPN (NON SCADA) SUMBAR_JMLG`, `IPVPN (NON SCADA) SUMBAR_DRS`, `IPVPN (NON SCADA) JAMBI_JMLG`, `IPVPN (NON SCADA) JAMBI_DRS`, 
                                        `INTERNET (SCADA) SUMBAR_JMLG`, `INTERNET (SCADA) SUMBAR_DRS`, `INTERNET (SCADA) JAMBI_JMLG`, `INTERNET (SCADA) JAMBI_DRS`, `INTERNET (NON SCADA) SUMBAR_JMLG`, `INTERNET (NON SCADA) SUMBAR_DRS`, `INTERNET (NON SCADA) JAMBI_JMLG`, `INTERNET (NON SCADA) JAMBI_DRS`, 
                                        `Clear Channel (SCADA) SUMBAR_JMLG`, `Clear Channel (SCADA) SUMBAR_DRS`, `Clear Channel (SCADA) JAMBI_JMLG`, `Clear Channel (SCADA) JAMBI_DRS`, `Clear Channel (NON SCADA) SUMBAR_JMLG`, `Clear Channel (NON SCADA) SUMBAR_DRS`, `Clear Channel (NON SCADA) JAMBI_JMLG`, `Clear Channel (NON SCADA) JAMBI_DRS`, 
                                        `METRONET (SCADA) SUMBAR_JMLG`, `METRONET (SCADA) SUMBAR_DRS`, `METRONET (SCADA) JAMBI_JMLG`, `METRONET (SCADA) JAMBI_DRS`, `METRONET (NON SCADA) SUMBAR_JMLG`, `METRONET (NON SCADA) SUMBAR_DRS`, `METRONET (NON SCADA) JAMBI_JMLG`, `METRONET (NON SCADA) JAMBI_DRS`, 
                                        `VSAT IP (SCADA) SUMBAR_JMLG`, `VSAT IP (SCADA) SUMBAR_DRS`, `VSAT IP (SCADA) JAMBI_JMLG`, `VSAT IP (SCADA) JAMBI_DRS`, `VSAT IP (NON SCADA) SUMBAR_JMLG`, `VSAT IP (NON SCADA) SUMBAR_DRS`, `VSAT IP (NON SCADA) JAMBI_JMLG`, `VSAT IP (NON SCADA) JAMBI_DRS`, 
                                        `TOTAL SCADA SUMBAR_JMLG`, `TOTAL SCADA SUMBAR_DRS`, `TOTAL SCADA JAMBI_JMLG`, `TOTAL SCADA JAMBI_DRS`, `TOTAL NON SCADA SUMBAR_JMLG`, `TOTAL NON SCADA SUMBAR_DRS`, `TOTAL NON SCADA JAMBI_JMLG`, `TOTAL NON SCADA JAMBI_DRS`)
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
                                
                            }
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
                                        }
                                    }
                                }
                                
                                $sqli = "INSERT INTO `laporan gangguan` (`Tanggal`, `IPVPN (SCADA) SUMBAR_JMLG`, `IPVPN (SCADA) SUMBAR_DRS`, `IPVPN (SCADA) JAMBI_JMLG`, `IPVPN (SCADA) JAMBI_DRS`, `IPVPN (NON SCADA) SUMBAR_JMLG`, `IPVPN (NON SCADA) SUMBAR_DRS`, `IPVPN (NON SCADA) JAMBI_JMLG`, `IPVPN (NON SCADA) JAMBI_DRS`, 
                                `INTERNET (SCADA) SUMBAR_JMLG`, `INTERNET (SCADA) SUMBAR_DRS`, `INTERNET (SCADA) JAMBI_JMLG`, `INTERNET (SCADA) JAMBI_DRS`, `INTERNET (NON SCADA) SUMBAR_JMLG`, `INTERNET (NON SCADA) SUMBAR_DRS`, `INTERNET (NON SCADA) JAMBI_JMLG`, `INTERNET (NON SCADA) JAMBI_DRS`, 
                                `Clear Channel (SCADA) SUMBAR_JMLG`, `Clear Channel (SCADA) SUMBAR_DRS`, `Clear Channel (SCADA) JAMBI_JMLG`, `Clear Channel (SCADA) JAMBI_DRS`, `Clear Channel (NON SCADA) SUMBAR_JMLG`, `Clear Channel (NON SCADA) SUMBAR_DRS`, `Clear Channel (NON SCADA) JAMBI_JMLG`, `Clear Channel (NON SCADA) JAMBI_DRS`, 
                                `METRONET (SCADA) SUMBAR_JMLG`, `METRONET (SCADA) SUMBAR_DRS`, `METRONET (SCADA) JAMBI_JMLG`, `METRONET (SCADA) JAMBI_DRS`, `METRONET (NON SCADA) SUMBAR_JMLG`, `METRONET (NON SCADA) SUMBAR_DRS`, `METRONET (NON SCADA) JAMBI_JMLG`, `METRONET (NON SCADA) JAMBI_DRS`, 
                                `VSAT IP (SCADA) SUMBAR_JMLG`, `VSAT IP (SCADA) SUMBAR_DRS`, `VSAT IP (SCADA) JAMBI_JMLG`, `VSAT IP (SCADA) JAMBI_DRS`, `VSAT IP (NON SCADA) SUMBAR_JMLG`, `VSAT IP (NON SCADA) SUMBAR_DRS`, `VSAT IP (NON SCADA) JAMBI_JMLG`, `VSAT IP (NON SCADA) JAMBI_DRS`, 
                                `TOTAL SCADA SUMBAR_JMLG`, `TOTAL SCADA SUMBAR_DRS`, `TOTAL SCADA JAMBI_JMLG`, `TOTAL SCADA JAMBI_DRS`, `TOTAL NON SCADA SUMBAR_JMLG`, `TOTAL NON SCADA SUMBAR_DRS`, `TOTAL NON SCADA JAMBI_JMLG`, `TOTAL NON SCADA JAMBI_DRS`)
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

                            $sqli = "INSERT INTO `laporan gangguan` (`Tanggal`, `IPVPN (SCADA) SUMBAR_JMLG`, `IPVPN (SCADA) SUMBAR_DRS`, `IPVPN (SCADA) JAMBI_JMLG`, `IPVPN (SCADA) JAMBI_DRS`, `IPVPN (NON SCADA) SUMBAR_JMLG`, `IPVPN (NON SCADA) SUMBAR_DRS`, `IPVPN (NON SCADA) JAMBI_JMLG`, `IPVPN (NON SCADA) JAMBI_DRS`, 
                            `INTERNET (SCADA) SUMBAR_JMLG`, `INTERNET (SCADA) SUMBAR_DRS`, `INTERNET (SCADA) JAMBI_JMLG`, `INTERNET (SCADA) JAMBI_DRS`, `INTERNET (NON SCADA) SUMBAR_JMLG`, `INTERNET (NON SCADA) SUMBAR_DRS`, `INTERNET (NON SCADA) JAMBI_JMLG`, `INTERNET (NON SCADA) JAMBI_DRS`, 
                            `Clear Channel (SCADA) SUMBAR_JMLG`, `Clear Channel (SCADA) SUMBAR_DRS`, `Clear Channel (SCADA) JAMBI_JMLG`, `Clear Channel (SCADA) JAMBI_DRS`, `Clear Channel (NON SCADA) SUMBAR_JMLG`, `Clear Channel (NON SCADA) SUMBAR_DRS`, `Clear Channel (NON SCADA) JAMBI_JMLG`, `Clear Channel (NON SCADA) JAMBI_DRS`, 
                            `METRONET (SCADA) SUMBAR_JMLG`, `METRONET (SCADA) SUMBAR_DRS`, `METRONET (SCADA) JAMBI_JMLG`, `METRONET (SCADA) JAMBI_DRS`, `METRONET (NON SCADA) SUMBAR_JMLG`, `METRONET (NON SCADA) SUMBAR_DRS`, `METRONET (NON SCADA) JAMBI_JMLG`, `METRONET (NON SCADA) JAMBI_DRS`, 
                            `VSAT IP (SCADA) SUMBAR_JMLG`, `VSAT IP (SCADA) SUMBAR_DRS`, `VSAT IP (SCADA) JAMBI_JMLG`, `VSAT IP (SCADA) JAMBI_DRS`, `VSAT IP (NON SCADA) SUMBAR_JMLG`, `VSAT IP (NON SCADA) SUMBAR_DRS`, `VSAT IP (NON SCADA) JAMBI_JMLG`, `VSAT IP (NON SCADA) JAMBI_DRS`, 
                            `TOTAL SCADA SUMBAR_JMLG`, `TOTAL SCADA SUMBAR_DRS`, `TOTAL SCADA JAMBI_JMLG`, `TOTAL SCADA JAMBI_DRS`, `TOTAL NON SCADA SUMBAR_JMLG`, `TOTAL NON SCADA SUMBAR_DRS`, `TOTAL NON SCADA JAMBI_JMLG`, `TOTAL NON SCADA JAMBI_DRS`)
                                    VALUES ($tanggal, $ipvpn_scada_sumbar_jmlg, $ipvpn_scada_sumbar_drs, $ipvpn_scada_jambi_jmlg, $ipvpn_scada_jambi_drs, $ipvpn_non_scada_sumbar_jmlg, $ipvpn_non_scada_sumbar_drs, $ipvpn_non_scada_jambi_jmlg, $ipvpn_non_scada_jambi_drs,
                                    $internet_scada_sumbar_jmlg, $internet_scada_sumbar_drs, $internet_scada_jambi_jmlg, $internet_scada_jambi_drs, $internet_non_scada_sumbar_jmlg, $internet_non_scada_sumbar_drs, $internet_non_scada_jambi_jmlg, $internet_non_scada_jambi_drs,
                                    $clear_channel_scada_sumbar_jmlg, $clear_channel_scada_sumbar_drs, $clear_channel_scada_jambi_jmlg, $clear_channel_scada_jambi_drs, $clear_channel_non_scada_sumbar_jmlg, $clear_channel_non_scada_sumbar_drs, $clear_channel_non_scada_jambi_jmlg, $clear_channel_non_scada_jambi_drs,
                                    $metronet_scada_sumbar_jmlg, $metronet_scada_sumbar_drs, $metronet_scada_jambi_jmlg, $metronet_scada_jambi_drs, $metronet_non_scada_sumbar_jmlg, $metronet_non_scada_sumbar_drs, $metronet_non_scada_jambi_jmlg, $metronet_non_scada_jambi_drs,
                                    $vsatip_scada_sumbar_jmlg, $vsatip_scada_sumbar_drs, $vsatip_scada_jambi_jmlg, $vsatip_scada_jambi_drs, $vsatip_non_scada_sumbar_jmlg, $vsatip_non_scada_sumbar_drs, $vsatip_non_scada_jambi_jmlg, $vsatip_non_scada_jambi_drs,
                                    $totalScadaSumbarJMLG, $totalScadaSumbarDRS, $totalScadaJambiJMLG, $totalScadaJambiDRS, $totalNonScadaSumbarJMLG, $totalNonScadaSumbarDRS, $totalNonScadaJambiJMLG, $totalNonScadaJambiDRS)";
                        
                    echo '</div>';
                    
                echo '<br/>';

                echo '<div class="laporanljs">';
                            $bulan = "-";
                            if ($pilihBln == '01') {
                                $bulan = "JANUARI";
                               // echo '<div class="tabelSumbar">';
                                //echo '<p><b>LAPORAN LAYANAN JARINGAN OPTI SUMBAR BULAN' . $bulan . '</b></p>';
                                
                            } elseif ($pilihBln == '02'){
                                $bulan = "FEBRUARI";
                            } elseif ($pilihBln == '03') {
                                $bulan = "MARET";
                            } elseif ($pilihBln == '04') {
                                $bulan = "APRIL";
                            } elseif ($pilihBln == '05') {
                                $bulan = "MEI";
                            } elseif ($pilihBln == '06') {
                                $bulan = "JUNI";
                            } elseif ($pilihBln == '07') {
                                $bulan = "JULI";
                            } elseif ($pilihBln == '08') {
                                $bulan = "AGUSTUS";
                            } elseif ($pilihBln == '09') {
                                $bulan = "SEPTEMBER";
                            } elseif ($pilihBln == '10') {
                                $bulan = "OKTOBER";
                            } elseif ($pilihBln == '11') {
                                $bulan = "NOVEMBER";
                            } elseif ($pilihBln == '12') {
                                $bulan = "DESEMBER";
                            }
                            $totalsumbarNonScadaDrsakum = 0;
                                        foreach (array('IP VPN', 'INTERNET', 'Clear Channel', 'METRONET', 'VSAT IP') as $kategori) {
                                            $totalsumbarNonScadaDrs = 0;
                                            foreach ($reportData as $tanggalData) {
                                                if (isset($tanggalData[$kategori]['NON SCADA']['SUMBAR']['DRS'])) {
                                                    $totalsumbarNonScadaDrs += round($tanggalData[$kategori]['NON SCADA']['SUMBAR']['DRS'] / 60, 2);
                                                    
                                                }
                                            }
                                            ${"totalsumbarNonScadaDrs_" . str_replace(" ", "_", strtoupper($kategori))} = $totalsumbarNonScadaDrs;
                                            $totalsumbarNonScadaDrsakum += $totalsumbarNonScadaDrs;

                                            $TDIPVPN = (isset($tanggalData['IP VPN']['NON SCADA']['SUMBAR']['DRS']) ? ($tanggalData['IPVPN']['NON SCADA']['SUMBAR']['DRS'] / 60) : 0);
                                            $TDINTERNET = (isset($tanggalData['INTERNET']['NON SCADA']['SUMBAR']['DRS']) ? $tanggalData['INTERNET']['NON SCADA']['SUMBAR']['DRS'] / 60 : 0);
                                            $TDCC = (isset($tanggalData['Clear Channel']['NON SCADA']['SUMBAR']['DRS']) ? $tanggalData['Clear Channel']['NON SCADA']['SUMBAR']['DRS'] / 60 : 0);
                                            $TDMETRONET = (isset($tanggalData['METRONET']['NON SCADA']['SUMBAR']['DRS']) ? $tanggalData['METRONET']['NON SCADA']['SUMBAR']['DRS'] / 60 : 0);
                                            $TDVSATIP = (isset($tanggalData['VSAT IP']['NON SCADA']['SUMBAR']['DRS']) ? $tanggalData['VSAT IP']['NON SCADA']['SUMBAR']['DRS'] / 60 : 0);
                                        }
                                        //echo '<td>' . $totalsumbarNonScadaDrsakum . '</td>';
                                        $queryTotal = "INSERT INTO nonscadasumbar (`TDIPVPN`, `TDINTERNET`, `TDCC`, `TDMETRONET`, `TDVSATIP`) VALUES (?, ?, ?, ?, ?)";
                                        $stmt = $connect->prepare($queryTotal);
                                        $stmt->bind_param("iiiii", $TDIPVPN, $TDINTERNET, $TDCC, $TDMETRONET, $TDVSATIP);
                                        if ($stmt->execute()) {
                                            echo '';
                                            
                                        } else {
                                            echo 'Error: ' . $stmt->error;
                                        }
                                        $stmt->close();
                                        
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

                                                $rataRataNonScadasumbarsum = 0;
                                                $totalsumbarNonScadaRataKategori = array(); // Buat array untuk menyimpan total rata-rata untuk masing-masing kategori
        
                                                foreach (array('IP VPN', 'INTERNET', 'Clear Channel', 'METRONET', 'VSAT IP') as $kategori) {
                                                    $totalsumbarNonScadaRataRataDurasi = 0;
                                                    $jumlahsumbarNonScadaFrekuensi = 0;
        
                                                    foreach ($reportData as $tanggalData) {
                                                        if (isset($tanggalData[$kategori]['NON SCADA']['SUMBAR']['JMLG']) && isset($tanggalData[$kategori]['NON SCADA']['SUMBAR']['DRS'])) {
                                                            $totalsumbarNonScadaRataRataDurasi += round(($tanggalData[$kategori]['NON SCADA']['SUMBAR']['DRS'] / $tanggalData[$kategori]['NON SCADA']['SUMBAR']['JMLG']) / 60, 2);
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
                                                    $rataRataNonScadasumbarsum = round(($totalsumbarNonScadaDrsakum / $totalsumbarNonScadaFreqsum) / 60, 2);
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
        
                    echo '<div class="tabelSumbar">';
                        echo '<p><b>LAPORAN LAYANAN JARINGAN OPTI SUMBAR BULAN ' . $bulan . '</b></p>';
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
                                        echo '<td>' . $TDIPVPN . '</td>';
                                        
                                echo '</tr>
                                    <tr>
                                        <th>Frekuensi Gangguan</th>';
                                        
                                echo '</tr>
                                    <tr>
                                        <th>Rata-rata Durasi Gangguan</th>';
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
                                                    $totalScadasumbarDrs += round($tanggalData[$kategori]['SCADA NON REDUNDANT']['SUMBAR']['DRS'], 2);
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
                                            $totalsumbarScadaRataKategori = array();
                                            foreach (array('IP VPN', 'INTERNET', 'Clear Channel', 'METRONET', 'VSAT IP') as $kategori) {
                                                $totalsumbarScadaRatarataDurasi = 0;
                                                $jumlahsumbarScadaFrekuensi = 0;
                                                foreach ($reportData as $tanggalData) {
                                                    if (isset($tanggalData[$kategori]['SCADA NON REDUNDANT']['SUMBAR']['JMLG']) && isset($tanggalData[$kategori]['SCADA NON REDUNDANT']['SUMBAR']['DRS'])) {
                                                        $totalsumbarScadaRatarataDurasi += $tanggalData[$kategori]['SCADA NON REDUNDANT']['SUMBAR']['DRS'] / $tanggalData[$kategori]['SCADA NON REDUNDANT']['SUMBAR']['JMLG'];
                                                        $jumlahsumbarScadaFrekuensi++;
                                                    }
                                                }
                                                if ($jumlahsumbarScadaFrekuensi > 0) {
                                                    $rataRatasumbarScada = round($totalsumbarScadaRatarataDurasi / $jumlahsumbarScadaFrekuensi, 2);
                                                    echo '<td>' . $rataRatasumbarScada . '</td>';
                                                } else {
                                                    $rataRatasumbarScada = 0;
                                                    echo '<td>' . $rataRatasumbarScada . '</td>';
                                                }
                                                $totalsumbarScadaRataKategori[str_replace(" ", "_", strtoupper($kategori))] = $rataRatasumbarScada;
                                            }
                                            if ($totalScadasumbarFreqsum != 0) {
                                                $rataRataScadasumbarsum = round(($totalScadasumbarDrsakum / $totalScadasumbarFreqsum) / 60, 2);
                                                echo '<td>' . $rataRataScadasumbarsum . '</td>';
                                            } else {
                                                echo '</td>' . 0 . '</td>';
                                            }
                                            $queryRata = "INSERT INTO ljssumbar (Gangguan, `IP VPN`, `INTERNET`, `Clear Channel`, `METRONET`, `VSAT IP`, AKUMULASI) 
                                                            VALUES ('Rata-rata Durasi Gangguan', '{$totalsumbarScadaRataKategori['IP_VPN']}', '{$totalsumbarScadaRataKategori['INTERNET']}', '{$totalsumbarScadaRataKategori['CLEAR_CHANNEL']}', '{$totalsumbarScadaRataKategori['METRONET']}', '{$totalsumbarScadaRataKategori['VSAT_IP']}', '$rataRataScadasumbarsum')";
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
                            echo '<p><b>LAPORAN LAYANAN JARINGAN OPTI JAMBI BULAN ' . $bulan . '</b></p>';
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
                                                $totalRatajambiNonScada = array();
                                                foreach (array('IP VPN', 'INTERNET', 'Clear Channel', 'METRONET', 'VSAT IP') as $kategori) {
                                                    $totalRataRatajambiNonScadaDurasi = 0;
                                                    $jumlahjambiNonScadaFrekuensi = 0;
                                                    foreach ($reportData as $tanggalData) {
                                                        if (isset($tanggalData[$kategori]['NON SCADA']['JAMBI']['JMLG']) && isset($tanggalData[$kategori]['NON SCADA']['JAMBI']['DRS'])) {
                                                            $totalRataRatajambiNonScadaDurasi += ($tanggalData[$kategori]['NON SCADA']['JAMBI']['DRS'] / $tanggalData[$kategori]['NON SCADA']['JAMBI']['JMLG']);
                                                            $jumlahjambiNonScadaFrekuensi++;
                                                        }
                                                    }

                                                    if ($jumlahjambiNonScadaFrekuensi > 0) {
                                                        $ratajambiNonScada = round(($totalRataRatajambiNonScadaDurasi / $totaljambiNonScadaFreqsum) / 60, 2);
                                                        echo '<td>' . $ratajambiNonScada . '</td>';
                                                    } else {
                                                        $ratajambiNonScada = 0;
                                                        echo '<td>' . $ratajambiNonScada . '</td>';
                                                    }

                                                    $totalRatajambiNonScada[str_replace(" ", "_", strtoupper($kategori))] = $ratajambiNonScada;
                                                }
                                                
                                                if ($totaljambiNonScadaFreqsum != 0) {
                                                    $ratajambiNonScadasum = round(($totaljambiNonScadaDrsakum / $totaljambiNonScadaFreqsum) / 60, 2);
                                                    echo '<td>' . $ratajambiNonScadasum . '</td>';
                                                } else {
                                                    $ratajambiNonScadasum = 0;
                                                    echo "<td>" . $ratajambiNonScadasum . "</td>";
                                                }
                                                $queryRata = "INSERT INTO ljnsjambi (Gangguan, `IP VPN`, `INTERNET`, `Clear Channel`, `METRONET`, `VSAT IP`, AKUMULASI) 
                                                            VALUES ('Rata-rata Durasi Gangguan', '{$totalRatajambiNonScada['IP_VPN']}', '{$totalRatajambiNonScada['INTERNET']}', '{$totalRatajambiNonScada['CLEAR_CHANNEL']}', '{$totalRatajambiNonScada['METRONET']}', '{$totalRatajambiNonScada['VSAT_IP']}', '$ratajambiNonScadasum')";
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
                                            $totaljambiScadaDrsakum = 0;
                                            foreach(array('IP VPN', 'INTERNET', 'Clear Channel', 'METRONET', 'VSAT IP') as $kategori) {
                                                $totaljambiScadaDrs = 0;
                                                foreach ($reportData as $tanggalData) {
                                                    if (isset($tanggalData[$kategori]['SCADA NON REDUNDANT']['JAMBI']['DRS'])) {
                                                        $totaljambiScadaDrs += round($tanggalData[$kategori]['SCADA NON REDUNDANT']['JAMBI']['DRS']);
                                                    }
                                                }
                                                ${"totaljambiScadaDrs_" . str_replace(" ", "_", strtoupper($kategori))} = $totaljambiScadaDrs;
                                                $totaljambiScadaDrsakum += $totaljambiScadaDrs;
                                                echo '<td>' . $totaljambiScadaDrs . '</td>';
                                            }
                                            echo '<td>' . $totaljambiScadaDrsakum . '</td>';

                                            $queryTotal = "INSERT INTO ljsjambi (Gangguan, `IP VPN`, `INTERNET`, `Clear Channel`, `METRONET`, `VSAT IP`, AKUMULASI) Values ('Total Durasi Gangguan', '$totaljambiScadaDrs_IP_VPN', '$totaljambiScadaDrs_INTERNET', '$totaljambiScadaDrs_CLEAR_CHANNEL', '$totaljambiScadaDrs_METRONET', '$totaljambiScadaDrs_VSAT_IP', '$totaljambiScadaDrsakum')";
                                            if ( mysqli_query($connect, $queryTotal)) {
                                                echo "";
                                            } else {
                                                echo "Error: " . mysqli_error($connect);
                                            }
                                    echo '</tr>
                                        <tr>
                                            <th>Frekuensi Gangguan</th>';
                                            $totaljambiScadaFreqsum = 0;
                                            foreach (array('IP VPN', 'INTERNET', 'Clear Channel', 'METRONET', 'VSAT IP') as $kategori) {
                                                $totaljambiScadaFreq = 0;
                                                foreach ($reportData as $tanggalData) {
                                                    if (isset($tanggalData[$kategori]['SCADA NON REDUNDANT']['JAMBI']['JMLG'])) {
                                                        $totaljambiScadaFreq += $tanggalData[$kategori]['SCADA NON REDUNDANT']['JAMBI']['JMLG'];
                                                    }
                                                }
                                                ${"totaljambiScadaFreq_" . str_replace(" ", "_", strtoupper($kategori))} = $totaljambiScadaFreq;
                                                $totaljambiScadaFreqsum += $totaljambiScadaFreq;
                                                echo '<td>' . $totaljambiScadaFreq . '</td>';
                                            }
                                            echo '<td>' . $totaljambiScadaFreqsum . '</td>';
                                            $queryFreq = "INSERT INTO ljsjambi (Gangguan, `IP VPN`, `INTERNET`, `Clear Channel`, `METRONET`, `VSAT IP`, AKUMULASI) VALUES ('Frequensi Gangguan', '$totaljambiScadaFreq_IP_VPN', '$totaljambiScadaFreq_INTERNET', '$totaljambiScadaFreq_CLEAR_CHANNEL', '$totaljambiScadaFreq_METRONET', '$totaljambiScadaFreq_VSAT_IP', '$totaljambiScadaFreqsum')";
                                                if (mysqli_query($connect, $queryFreq)) {
                                                    echo "";
                                                } else {
                                                    echo "Error: " . mysqli_error($connect);
                                                }
                                    echo '</tr>
                                        <tr>
                                            <th>Rata-rata Durasi Gangguan</th>';
                                            $rataRataScadajambisum = 0;
                                            $totalrataScadajambi = array();
                                            foreach (array('IP VPN', 'INTERNET', 'Clear Channel', 'METRONET', 'VSAT IP') as $kategori) {
                                                $totaljambiScadaRataRataDurasi = 0;
                                                $jumlahjambiScadaFrekuensi = 0;
                                                foreach ($reportData as $tanggalData) {
                                                    if (isset($tanggalData[$kategori]['SCADA NON REDUNDANT']['JAMBI']['JMLG']) && isset($tanggalData[$kategori]['SCADA NON REDUNDANT']['JAMBI']['DRS'])) {
                                                        $totaljambiScadaRataRataDurasi += $tanggalData[$kategori]['SCADA NON REDUNDANT']['JAMBI']['DRS'] / $tanggalData[$kategori]['SCADA NON REDUNDANT']['JAMBI']['JMLG'];
                                                        $jumlahjambiScadaFrekuensi++;
                                                    }
                                                }
                                                if ($jumlahjambiScadaFrekuensi > 0) {
                                                    $rataRatajambiScada = round($totaljambiScadaRataRataDurasi / $jumlahjambiScadaFrekuensi, 2);
                                                    echo '<td>'. $rataRatajambiScada . '</td>';
                                                } else {
                                                    $rataRatajambiScada = 0;
                                                    echo '<td>'. $rataRatajambiScada . '</td>'; 
                                                }

                                                $totalrataScadajambi[str_replace(" ", "_", strtoupper($kategori))] = $rataRatajambiScada;
                                            }
                                            if ($totaljambiScadaFreqsum != 0) {
                                                $rataRataScadajambisum = round(($totaljambiScadaDrsakum / $totaljambiScadaFreqsum) / 60, 2);
                                                echo '<td>' . $rataRataScadajambisum . '</td>';
                                            } else {
                                                echo '<td>' . 0 . '</td>';
                                            }
                                            $queryRata = "INSERT INTO ljsjambi (Gangguan, `IP VPN`, `INTERNET`, `Clear Channel`, `METRONET`, `VSAT IP`, AKUMULASI) 
                                                        VALUES ('Rata-rata Durasi Gangguan', '{$totalrataScadajambi['IP_VPN']}', '{$totalrataScadajambi['INTERNET']}', '{$totalrataScadajambi['CLEAR_CHANNEL']}', '{$totalrataScadajambi['METRONET']}', '{$totalrataScadajambi['VSAT_IP']}', '$rataRataScadajambisum')";
                                                if (mysqli_query($connect, $queryRata)) {
                                                    echo "";
                                                } else {
                                                    echo "Error: " . mysqli_error($connect);
                                                }
                                    echo '</tr>';
                                echo '</table>';
                        echo '</div>';
                        echo '<br/>';
                        echo '<div class="tabelSumbarJambi"';
                                echo '<p><b>LAPORAN LAYANAN JARINGAN OPTI SUMBAR JAMBI BULAN ' . $bulan . '</b></p>';
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
                                            $totalNonScadaDrs = 0;
                                            $totalNonScadaDrsakum = 0;
                                            foreach (array('IP VPN', 'INTERNET', 'Clear Channel', 'METRONET', 'VSAT IP') as $kategori) {
                                                $totalsumbarNonScadaDrs = 0;
                                                $totaljambiNonScadaDrs = 0;
                                                foreach ($reportData as $tanggalData) {
                                                    if (isset($tanggalData[$kategori]['NON SCADA']['SUMBAR']['DRS'])) {
                                                        $totalsumbarNonScadaDrs += round($tanggalData[$kategori]['NON SCADA']['SUMBAR']['DRS'] / 60);
                                                        
                                                    }
                                                    if (isset($tanggalData[$kategori]['NON SCADA']['JAMBI']['DRS'])) {
                                                        $totaljambiNonScadaDrs += round($tanggalData[$kategori]['NON SCADA']['JAMBI']['DRS'] / 60);
                                                    }
                                                }
                                                $totalNonScadaDrs = $totalsumbarNonScadaDrs + $totaljambiNonScadaDrs;    
                                                ${"totalNonScadaDrs_" . str_replace(" ", "_", strtoupper($kategori))} = $totalNonScadaDrs;
                                                $totalNonScadaDrsakum += $totalNonScadaDrs;
                                                echo '<td>' . $totalNonScadaDrs . '</td>';
                                            }
                                            echo '<td>' . $totalNonScadaDrsakum . '</td>';
                                            $queryTotalNonScada = "INSERT INTO ljns (Gangguan, `IP VPN`, `INTERNET`, `Clear Channel`, `METRONET`, `VSAT IP`, AKUMULASI) VALUES ('Total Durasi Gangguan', '$totalNonScadaDrs_IP_VPN', '$totalNonScadaDrs_INTERNET', '$totalNonScadaDrs_CLEAR_CHANNEL', '$totalNonScadaDrs_METRONET', '$totalNonScadaDrs_VSAT_IP', '$totalNonScadaDrsakum')";
                                            if (mysqli_query($connect, $queryTotalNonScada)) {
                                                echo "";
                                            } else {
                                                echo "Error: " . mysqli_error($connect);
                                            }
                                echo '</tr>';
                                echo '<tr>
                                        <th>Frekuensi Gangguan</th>';
                                        $totalNonScadaFreq = 0;
                                        $totalNonScadaFreqsum = 0;
                                        foreach (array('IP VPN', 'INTERNET', 'Clear Channel', 'METRONET', 'VSAT IP') as $kategori) {
                                            $totalsumbarNonScadaFreq = 0;
                                            $totaljambiNonScadaFreq = 0;
                                            foreach ($reportData as $tanggalData) {
                                                if (isset($tanggalData[$kategori]['NON SCADA']['SUMBAR']['JMLG'])) {
                                                    $totalsumbarNonScadaFreq += round($tanggalData[$kategori]['NON SCADA']['SUMBAR']['JMLG']);
                                                }
                                                if (isset($tanggalData[$kategori]['NON SCADA']['JAMBI']['JMLG'])) {
                                                    $totaljambiNonScadaFreq += round($tanggalData[$kategori]['NON SCADA']['JAMBI']['JMLG']);
                                                }
                                            }
                                            $totalNonScadaFreq = $totalsumbarNonScadaFreq + $totaljambiNonScadaFreq;
                                            ${"totalNonScadaFreq_" . str_replace(" ", "_", strtoupper($kategori))} = $totalNonScadaFreq;
                                            $totalNonScadaFreqsum += $totalNonScadaFreq;
                                            echo '<td>' . $totalNonScadaFreq . '</td>';
                                        }
                                        echo '<td>' . $totalNonScadaFreqsum . '</td>';
                                        $queryFreqNonScada = "INSERT INTO ljns (Gangguan, `IP VPN`, `INTERNET`, `Clear Channel`, `METRONET`, `VSAT IP`, AKUMULASI) VALUES ('Frequensi Gangguan', '$totalNonScadaFreq_IP_VPN', '$totalNonScadaFreq_INTERNET', '$totalNonScadaFreq_CLEAR_CHANNEL', '$totalNonScadaFreq_METRONET', '$totalNonScadaFreq_VSAT_IP', '$totalNonScadaFreqsum')";
                                        if (mysqli_query($connect, $queryFreqNonScada)) {
                                            echo "";
                                        } else {
                                            echo "Error: " . mysqli_error($connect);
                                        }
                                echo '</tr>';
                                echo '<tr>
                                        <th>Rata-rata Durasi Gangguan</th>';
                                        $rataRataNonScada = 0;
                                        $rataRataNonScadasum = 0;
                                        $totalNonScadaRataKategori = array();
                                        foreach (array('IP VPN', 'INTERNET', 'Clear Channel', 'METRONET', 'VSAT IP') as $kategori) {
                                            
                                            $totalsumbarNonScadaRataDrs = 0;
                                            $jumlahsumbarNonScadaFreq = 0;
                                            $totaljambiNonScadaRataDrs = 0;
                                            $jumlahjambiNonScadaFreq = 0;

                                            foreach ($reportData as $tanggalData) {
                                                if (isset($tanggalData[$kategori]['NON SCADA']['SUMBAR']['JMLG']) && isset($tanggalData[$kategori]['NON SCADA']['SUMBAR']['DRS'])) {
                                                    $totalsumbarNonScadaRataDrs += ($tanggalData[$kategori]['NON SCADA']['SUMBAR']['DRS'] / $tanggalData[$kategori]['NON SCADA']['SUMBAR']['JMLG']) / 60;
                                                    $jumlahsumbarNonScadaFreq++;
                                                }
                                                if (isset($tanggalData[$kategori]['NON SCADA']['JAMBI']['JMLG']) && isset($tanggalData[$kategori]['NON SCADA']['JAMBI']['DRS'])) {
                                                    $totaljambiNonScadaRataDrs += ($tanggalData[$kategori]['NON SCADA']['JAMBI']['DRS'] / $tanggalData[$kategori]['NON SCADA']['JAMBI']['JMLG']) / 60;
                                                    $jumlahjambiNonScadaFreq++;
                                                }
                                            }
                                            if ($jumlahsumbarNonScadaFreq > 0) {
                                                $ratasumbarNonScada = $totalsumbarNonScadaRataDrs / $jumlahsumbarNonScadaFreq;
                                            } else {
                                                $ratasumbarNonScada = 0;
                                            }
                                            if ($jumlahjambiNonScadaFreq > 0) {
                                                $ratajambiNonScada = $totaljambiNonScadaRataDrs / $jumlahjambiNonScadaFreq;
                                            } else {
                                                $ratajambiNonScada = 0;
                                            }
                                            $ratarataNonScada = round($ratasumbarNonScada + $ratajambiNonScada, 2);
                                            $totalNonScadaRataKategori[str_replace(" ", "_", strtoupper($kategori))] = $rataRataNonScada;
                                            echo '<td>' . $ratarataNonScada . '</td>';
                                        }
                                            
                                        if ($totalNonScadaFreqsum != 0) {
                                            $rataRataNonScadasum = round(($totalNonScadaDrsakum / $totalNonScadaFreqsum), 2);
                                            echo '<td>' . $rataRataNonScadasum . '</td>';
                                        } else {
                                            echo '<td>' . 0 . '</td>';
                                        }
                                        $sql = "INSERT INTO ljns (Gangguan, `IP VPN`, `INTERNET`, `Clear Channel`, `METRONET`, `VSAT IP`, AKUMULASI)
                                                VALUES ('Rata-rata Durasi Gangguan', '{$totalNonScadaRataKategori['IP_VPN']}', '{$totalNonScadaRataKategori['INTERNET']}', '{$totalNonScadaRataKategori['CLEAR_CHANNEL']}', '{$totalNonScadaRataKategori['METRONET']}', '{$totalNonScadaRataKategori['VSAT_IP']}', '$rataRataNonScadasum')";
                                        if (mysqli_query($connect, $sql)) {
                                            echo "";
                                        } else {
                                            echo "Error: " . mysqli_error($connect);
                                        }
                                echo '</tr>';
                                echo '</table>';
                                ?>
                                <br/>
                                <table border="1">
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
                                        <th>Total Durasi Gangguan</th>
                                        <?php 
                                        $totalScadaDrs = 0;
                                        $totalScadaDrsakum = 0;
                                        foreach (array('IP VPN', 'INTERNET', 'Clear Channel', 'METRONET', 'VSAT IP') as $kategori) {
                                            $totalsumbarScadaDrs = 0;
                                            $totaljambiScadaDrs = 0;
                                            foreach ($reportData as $tanggalData) {
                                                if (isset($tanggalData[$kategori]['SCADA NON REDUNDANT']['SUMBAR']['DRS'])) {
                                                    $totalsumbarScadaDrs += round($tanggalData[$kategori]['SCADA NON REDUNDANT']['SUMBAR']['DRS']);
                                                }
                                                if (isset($tanggalData[$kategori]['SCADA NON REDUNDANT']['JAMBI']['DRS'])) {
                                                    $totaljambiScadaDrs += round($tanggalData[$kategori]['SCADA NON REDUNDANT']['JAMBI']['DRS']);
                                                }
                                            }
                                            $totalScadaDrs = round($totalsumbarScadaDrs + $totaljambiScadaDrs, 2);
                                            ${"totalScadaDrs_" . str_replace(" ", "_", strtoupper(($kategori)))} = $totalScadaDrs;
                                            $totalScadaDrsakum += $totalScadaDrs;
                                            echo '<td>' . $totalScadaDrs . '</td>';
                                        }
                                        echo '<td>' . $totalScadaDrsakum . '</td>';
                                        $sql = "INSERT INTO ljs (Gangguan, `IP VPN`, `INTERNET`, `Clear Channel`, `METRONET`, `VSAT IP`, AKUMULASI) VALUES ('Total Durasi Gangguan', '$totalScadaDrs_IP_VPN', '$totalScadaDrs_INTERNET', '$totalScadaDrs_CLEAR_CHANNEL', '$totalScadaDrs_METRONET', '$totalScadaDrs_VSAT_IP', '$totalScadaDrsakum')";
                                        if (mysqli_query($connect, $sql)) {
                                            echo "";
                                        } else {
                                            echo "Error: " . mysqli_error($connect);
                                        }
                                        ?>
                                    </tr>
                                    <tr>
                                        <th>Frekuensi Gangguan</th>
                                        <?php 
                                        $totalScadaFreq = 0;
                                        $totalScadaFreqsum = 0;
                                        foreach (array('IP VPN', 'INTERNET', 'Clear Channel', 'METRONET', 'VSAT IP') as $kategori) {
                                            $totalsumbarScadaFreq = 0;
                                            $totaljambiScadaFreq = 0;
                                            foreach ($reportData as $tanggalData) {
                                                if (isset($tanggalData[$kategori]['SCADA NON REDUNDANT']['SUMBAR']['JMLG'])) {
                                                    $totalsumbarScadaFreq += round($tanggalData[$kategori]['SCADA NON REDUNDANT']['SUMBAR']['JMLG']);
                                                }
                                                if (isset($tanggalData[$kategori]['SCADA NON REDUNDANT']['JAMBI']['JMLG'])) {
                                                    $totaljambiScadaFreq += round($tanggalData[$kategori]['SCADA NON REDUNDANT']['JAMBI']['JMLG']);
                                                }
                                            }
                                            $totalScadaFreq = $totalsumbarScadaFreq + $totaljambiScadaFreq;
                                            ${"totalScadaFreq_" . str_replace(" ", "_", strtoupper($kategori))} = $totalScadaFreq;
                                            $totalScadaFreqsum += $totalScadaFreq;
                                            echo '<td>' . $totalScadaFreq . '</td>';
                                        }
                                        echo '<td>' . $totalScadaFreqsum . '</td>';
                                        $sql = "INSERT INTO ljs (Gangguan, `IP VPN`, `INTERNET`, `Clear Channel`, `METRONET`, `VSAT IP`, AKUMULASI) VALUES ('Frequensi Gangguan', '$totalScadaFreq_IP_VPN', '$totalScadaFreq_INTERNET', '$totalScadaFreq_CLEAR_CHANNEL', '$totalScadaFreq_METRONET', '$totalScadaFreq_VSAT_IP', '$totalScadaFreqsum')";
                                        if (mysqli_query($connect, $sql)) {
                                            echo "";
                                        } else {
                                            echo "Error: " . mysqli_error($connect);
                                        }
                                        ?>
                                    </tr>
                                    <tr>
                                        <th>Rata-rata Durasi Gangguan</th>
                                        <?php 
                                        $rataRataScada = 0;
                                        $rataRataScadasum = 0;
                                        $totalScadaRataKategori = array();
                                        foreach (array('IP VPN', 'INTERNET', 'Clear Channel', 'METRONET', 'VSAT IP') as $kategori) {
                                            
                                            $totalsumbarScadaRataDrs = 0;
                                            $jumlahsumbarScadaFreq = 0;
                                            $totaljambiScadaRataDrs = 0;
                                            $jumlahjambiScadaFreq = 0;

                                            foreach ($reportData as $tanggalData) {
                                                if (isset($tanggalData[$kategori]['SCADA NON REDUNDANT']['SUMBAR']['JMLG']) && isset($tanggalData[$kategori]['SCADA NON REDUNDANT']['SUMBAR']['DRS'])) {
                                                    $totalsumbarScadaRataDrs += ($tanggalData[$kategori]['SCADA NON REDUNDANT']['SUMBAR']['DRS'] / $tanggalData[$kategori]['SCADA NON REDUNDANT']['SUMBAR']['JMLG']) / 60;
                                                    $jumlahsumbarScadaFreq++;
                                                }
                                                if (isset($tanggalData[$kategori]['SCADA NON REDUNDANT']['JAMBI']['JMLG']) && isset($tanggalData[$kategori]['SCADA NON REDUNDANT']['JAMBI']['DRS'])) {
                                                    $totaljambiScadaRataDrs += ($tanggalData[$kategori]['SCADA NON REDUNDANT']['JAMBI']['DRS'] / $tanggalData[$kategori]['SCADA NON REDUNDANT']['JAMBI']['JMLG']) / 60;
                                                    $jumlahjambiScadaFreq++;
                                                }
                                            }
                                            if ($jumlahsumbarScadaFreq > 0) {
                                                $ratasumbarScada = $totalsumbarScadaRataDrs / $jumlahsumbarScadaFreq;
                                            } else {
                                                $ratasumbarScada = 0;
                                            }
                                            if ($jumlahjambiScadaFreq > 0) {
                                                $ratajambiScada = $totaljambiScadaRataDrs / $jumlahjambiScadaFreq;
                                            } else {
                                                $ratajambiScada = 0;
                                            }
                                            $ratarataScada = round($ratasumbarScada + $ratajambiScada, 2);
                                            $totalScadaRataKategori[str_replace(" ", "_", strtoupper($kategori))] = $rataRataScada;
                                            echo '<td>' . $ratarataScada . '</td>';
                                        }
                                            
                                        if ($totalScadaFreqsum != 0) {
                                            $rataRataScadasum = round(($totalScadaDrsakum / $totalScadaFreqsum), 2);
                                            echo '<td>' . $rataRataScadasum . '</td>';
                                        } else {
                                            echo '<td>' . 0 . '</td>';
                                        }
                                        $sql = "INSERT INTO ljns (Gangguan, `IP VPN`, `INTERNET`, `Clear Channel`, `METRONET`, `VSAT IP`, AKUMULASI)
                                                VALUES ('Rata-rata Durasi Gangguan', '{$totalScadaRataKategori['IP_VPN']}', '{$totalScadaRataKategori['INTERNET']}', '{$totalScadaRataKategori['CLEAR_CHANNEL']}', '{$totalScadaRataKategori['METRONET']}', '{$totalScadaRataKategori['VSAT_IP']}', '$rataRataScadasum')";
                                        if (mysqli_query($connect, $sql)) {
                                            echo "";
                                        } else {
                                            echo "Error: " . mysqli_error($connect);
                                        }
                                        ?>
                                    </tr>
                                </table>
                  <?php                           
                echo '</div>';
            
            $reset = "ALTER TABLE `laporan gangguan` AUTO_INCREMENT = 1";
            mysqli_query($connect, $reset);
            $connect->close();
            echo '</div>';
        }


        generateReport();
        ?>

        <footer>Done</footer>
    </body>
</html>