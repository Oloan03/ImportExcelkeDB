<!DOCTYPE html>
<html>
    <head>
        <title>Laporan Data Gangguan Jaringan Bulanan</title>
    </head>
    <body>
        <a href="index.php">Kembali</a>
        <h3>Laporan: </h3>

        <a href="export.php?format=excel">Eksport ke Excel</a>
        <a href="export.php?format=pdf">Eksport ke PDF</a>
        
        <?php 
        function generateReport() {
            $pdo = new PDO('mysql:host=localhost;dbname=DataGangguan', 'root', '');
            $stmt = $pdo->query('SELECT * FROM data');
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $reportData = array();

            foreach ($data as $row) {
                $tanggal = substr($row['Tiket Close'], 0, 10);
                $asman = $row['Asman'];
                $jenis_produk = $row['Produk'];
                $durasi_menit = intval($row['Durasi (Menit)']);
                $kategori_layanan = $row['Kategori Layanan'];

                // Menghitung jumlah data dan durasi sesuai kategori yang diinginkan
                if (!isset($reportData[$tanggal][$jenis_produk][$kategori_layanan][$asman]['JMLG'])) {
                    $reportData[$tanggal][$jenis_produk][$kategori_layanan][$asman]['JMLG'] = 1;
                    $reportData[$tanggal][$jenis_produk][$kategori_layanan][$asman]['DRS']= $durasi_menit;
                } else {
                    $reportData[$tanggal][$jenis_produk][$kategori_layanan][$asman]['JMLG']++;
                    $reportData[$tanggal][$jenis_produk][$kategori_layanan][$asman]['DRS'] += $durasi_menit;
                }
            }

            echo '<table border="1">';
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

                $sumbarScada = 0;
                $jambiScada = 0;
                $sumbarNonScada = 0;
                $jambiNonScada = 0;

                foreach ($dataPerTanggal as $jenis_produk => $dataPerProduk) {
                    foreach ($dataPerProduk as $kategori_layanan => $dataPerLayanan) {
                        foreach ($dataPerLayanan as $asman => $dataPerAsman) {
                            if ($kategori_layanan === 'SCADA NON REDUNDANT') {
                                if ($jenis_produk === 'IP VPN') {
                                    $sumbarScada += $dataPerAsman['JMLG'];
                                    $sumbarScada += $dataPerAsman['DRS'];
                                    $jambiScada += $dataPerAsman['JMLG'];
                                    $jambiScada += $dataPerAsman['DRS'];
                                } elseif ($kategori_layanan === 'INTERNET') {
                                    $sumbarScada += $dataPerAsman['JMLG'];
                                    $sumbarScada += $dataPerAsman['DRS'];
                                    $jambiScada += $dataPerAsman['JMLG'];
                                    $jambiScada += $dataPerAsman['DRS'];
                                } elseif ($kategori_layanan === 'METRONET') {
                                    $sumbarScada += $dataPerAsman['JMLG'];
                                    $sumbarScada += $dataPerAsman['DRS'];
                                    $jambiScada += $dataPerAsman['JMLG'];
                                    $jambiScada += $dataPerAsman['DRS'];
                                } elseif ($kategori_layanan === 'VSAT IP') {
                                    $sumbarScada += $dataPerAsman['JMLG'];
                                    $sumbarScada += $dataPerAsman['DRS'];
                                    $jambiScada += $dataPerAsman['JMLG'];
                                    $jambiScada += $dataPerAsman['DRS'];
                                }
                            } elseif ($kategori_layanan === 'NON SCADA') {
                                if ($jenis_produk === 'IP VPN') {
                                    $sumbarScada += $dataPerAsman['JMLG'];
                                    $sumbarScada += $dataPerAsman['DRS'];
                                    $jambiScada += $dataPerAsman['JMLG'];
                                    $jambiScada += $dataPerAsman['DRS'];
                                } elseif ($kategori_layanan === 'INTERNET') {
                                    $sumbarScada += $dataPerAsman['JMLG'];
                                    $sumbarScada += $dataPerAsman['DRS'];
                                    $jambiScada += $dataPerAsman['JMLG'];
                                    $jambiScada += $dataPerAsman['DRS'];
                                } elseif ($kategori_layanan === 'METRONET') {
                                    $sumbarScada += $dataPerAsman['JMLG'];
                                    $sumbarScada += $dataPerAsman['DRS'];
                                    $jambiScada += $dataPerAsman['JMLG'];
                                    $jambiScada += $dataPerAsman['DRS'];
                                } elseif ($kategori_layanan === 'VSAT IP') {
                                    $sumbarScada += $dataPerAsman['JMLG'];
                                    $sumbarScada += $dataPerAsman['DRS'];
                                    $jambiScada += $dataPerAsman['JMLG'];
                                    $jambiScada += $dataPerAsman['DRS'];
                                }
                            }
                        }
                    } 
                }

                echo '<tr>';
                echo '<td>' . $tanggal . '</td>';
                echo '<td>' . (isset($dataPerTanggal['IP VPN']['SCADA NON REDUNDANT']['SUMBAR']['JMLG']) ? $dataPerTanggal['IP VPN']['SCADA NON REDUNDANT']['SUMBAR']['JMLG'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['IP VPN']['SCADA NON REDUNDANT']['SUMBAR']['DRS']) ? $dataPerTanggal['IP VPN']['SCADA NON REDUNDANT']['SUMBAR']['DRS'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['IP VPN']['SCADA NON REDUNDANT']['JAMBI']['JMLG']) ? $dataPerTanggal['IP VPN']['SCADA NON REDUNDANT']['JAMBI']['JMLG'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['IP VPN']['SCADA NON REDUNDANT']['JAMBI']['DRS']) ? $dataPerTanggal['IP VPN']['SCADA NON REDUNDANT']['JAMBI']['DRS'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['IP VPN']['NON SCADA']['SUMBAR']['JMLG']) ? $dataPerTanggal['IP VPN']['NON SCADA']['SUMBAR']['JMLG'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['IP VPN']['NON SCADA']['SUMBAR']['DRS']) ? $dataPerTanggal['IP VPN']['NON SCADA']['SUMBAR']['DRS'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['IP VPN']['NON SCADA']['JAMBI']['JMLG']) ? $dataPerTanggal['IP VPN']['NON SCADA']['JAMBI']['JMLG'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['IP VPN']['NON SCADA']['JAMBI']['DRS']) ? $dataPerTanggal['IP VPN']['NON SCADA']['JAMBI']['DRS'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['INTERNET']['SCADA NON REDUNDANT']['SUMBAR']['JMLG']) ? $dataPerTanggal['INTERNET']['SCADA NON REDUNDANT']['SUMBAR']['JMLG'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['INTERNET']['SCADA NON REDUNDANT']['SUMBAR']['DRS']) ? $dataPerTanggal['INTERNET']['SCADA NON REDUNDANT']['SUMBAR']['DRS'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['INTERNET']['SCADA NON REDUNDANT']['JAMBI']['JMLG']) ? $dataPerTanggal['INTERNET']['SCADA NON REDUNDANT']['JAMBI']['JMLG'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['INTERNET']['SCADA NON REDUNDANT']['JAMBI']['DRS']) ? $dataPerTanggal['INTERNET']['SCADA NON REDUNDANT']['JAMBI']['DRS'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['INTERNET']['NON SCADA']['SUMBAR']['JMLG']) ? $dataPerTanggal['INTERNET']['NON SCADA']['SUMBAR']['JMLG'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['INTERNET']['NON SCADA']['SUMBAR']['DRS']) ? $dataPerTanggal['INTERNET']['NON SCADA']['SUMBAR']['DRS'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['INTERNET']['NON SCADA']['JAMBI']['JMLG']) ? $dataPerTanggal['INTERNET']['NON SCADA']['JAMBI']['JMLG'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['INTERNET']['NON SCADA']['JAMBI']['DRS']) ? $dataPerTanggal['INTERNET']['NON SCADA']['JAMBI']['DRS'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['Clear Channel']['SCADA NON REDUNDANT']['SUMBAR']['JMLG']) ? $dataPerTanggal['Clear Channel']['SCADA NON REDUNDANT']['SUMBAR']['JMLG'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['Clear Channel']['SCADA NON REDUNDANT']['SUMBAR']['DRS']) ? $dataPerTanggal['Clear Channel']['SCADA NON REDUNDANT']['SUMBAR']['DRS'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['Clear Channel']['SCADA NON REDUNDANT']['JAMBI']['JMLG']) ? $dataPerTanggal['Clear Channel']['SCADA NON REDUNDANT']['JAMBI']['JMLG'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['Clear Channel']['SCADA NON REDUNDANT']['JAMBI']['DRS']) ? $dataPerTanggal['Clear Channel']['SCADA NON REDUNDANT']['JAMBI']['DRS'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['Clear Channel']['NON SCADA']['SUMBAR']['JMLG']) ? $dataPerTanggal['Clear Channel']['NON SCADA']['SUMBAR']['JMLG'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['Clear Channel']['NON SCADA']['SUMBAR']['DRS']) ? $dataPerTanggal['Clear Channel']['NON SCADA']['SUMBAR']['DRS'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['Clear Channel']['NON SCADA']['JAMBI']['JMLG']) ? $dataPerTanggal['Clear Channel']['NON SCADA']['JAMBI']['JMLG'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['Clear Channel']['NON SCADA']['JAMBI']['DRS']) ? $dataPerTanggal['Clear Channel']['NON SCADA']['JAMBI']['DRS'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['METRONET']['SCADA NON REDUNDANT']['SUMBAR']['JMLG']) ? $dataPerTanggal['METRONET']['SCADA NON REDUNDANT']['SUMBAR']['JMLG'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['METRONET']['SCADA NON REDUNDANT']['SUMBAR']['DRS']) ? $dataPerTanggal['METRONET']['SCADA NON REDUNDANT']['SUMBAR']['DRS'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['METRONET']['SCADA NON REDUNDANT']['JAMBI']['JMLG']) ? $dataPerTanggal['METRONET']['SCADA NON REDUNDANT']['JAMBI']['JMLG'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['METRONET']['SCADA NON REDUNDANT']['JAMBI']['DRS']) ? $dataPerTanggal['METRONET']['SCADA NON REDUNDANT']['JAMBI']['DRS'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['METRONET']['NON SCADA']['SUMBAR']['JMLG']) ? $dataPerTanggal['METRONET']['NON SCADA']['SUMBAR']['JMLG'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['METRONET']['NON SCADA']['SUMBAR']['DRS']) ? $dataPerTanggal['METRONET']['NON SCADA']['SUMBAR']['DRS'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['METRONET']['NON SCADA']['JAMBI']['JMLG']) ? $dataPerTanggal['METRONET']['NON SCADA']['JAMBI']['JMLG'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['METRONET']['NON SCADA']['JAMBI']['DRS']) ? $dataPerTanggal['METRONET']['NON SCADA']['JAMBI']['DRS'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['VSAT IP']['SCADA NON REDUNDANT']['SUMBAR']['JMLG']) ? $dataPerTanggal['VSAT IP']['SCADA NON REDUNDANT']['SUMBAR']['JMLG'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['VSAT IP']['SCADA NON REDUNDANT']['SUMBAR']['DRS']) ? $dataPerTanggal['VSAT IP']['SCADA NON REDUNDANT']['SUMBAR']['DRS'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['VSAT IP']['SCADA NON REDUNDANT']['JAMBI']['JMLG']) ? $dataPerTanggal['VSAT IP']['SCADA NON REDUNDANT']['JAMBI']['JMLG'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['VSAT IP']['SCADA NON REDUNDANT']['JAMBI']['DRS']) ? $dataPerTanggal['VSAT IP']['SCADA NON REDUNDANT']['JAMBI']['DRS'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['VSAT IP']['NON SCADA']['SUMBAR']['JMLG']) ? $dataPerTanggal['VSAT IP']['NON SCADA']['SUMBAR']['JMLG'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['VSAT IP']['NON SCADA']['SUMBAR']['DRS']) ? $dataPerTanggal['VSAT IP']['NON SCADA']['SUMBAR']['DRS'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['VSAT IP']['NON SCADA']['JAMBI']['JMLG']) ? $dataPerTanggal['VSAT IP']['NON SCADA']['JAMBI']['JMLG'] : 0) . '</td>';
                echo '<td>' . (isset($dataPerTanggal['VSAT IP']['NON SCADA']['JAMBI']['DRS']) ? $dataPerTanggal['VSAT IP']['NON SCADA']['JAMBI']['DRS'] : 0) . '</td>';
                echo '<td>' . $sumbarScada . '</td>';
                echo '<td>' . $jambiScada . '</td>';
                echo '<td>' . $sumbarNonScada . '</td>';
                echo '<td>' . $jambiNonScada . '</td>';
                echo '</tr>';
                echo '</table>';
        }
        generateReport();
        ?>
    </body>
</html>