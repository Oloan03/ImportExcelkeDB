<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <title>Import data ke MySQL</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>
    <div class="tabel">
        
        <?php 
        include 'connect.php';
        $data = mysqli_query($connect, "SELECT * FROM `data harian`");
        if(isset($_GET['month'])) {
            $pilibln = $_GET['month'];
            $data = mysqli_query($connect, "SELECT * FROM `data harian` WHERE substr(`Tanggal`,6,2)='$pilibln'");
        } else {
            $data = mysqli_query($connect, "SELECT * FROM `data harian`");
        }
        ?>
        <div class="backbtn">
            <a id="backBtn" href="index2.php"><i class="material-icons">arrow_back</i></a>
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
        <div class="content">
            
            <div style="overflow-x: auto;">
                <table border="1">
                    <tr>
                        <th rowspan="3">Tanggal</th>
                        <th colspan="4">IP VPN (SCADA)</th>
                        <th colspan="4">IP VPN (NON SCADA)</th>
                        <th colspan="4">INTERNET (SCADA)</th>
                        <th colspan="4">INTERNET (NON SCADA)</th>
                        <th colspan="4">Clear Channel (SCADA)</th>
                        <th colspan="4">Clear Channel (NON SCADA)</th>
                        <th colspan="4">METRONET (SCADA)</th>
                        <th colspan="4">METRONET (NON SCADA)</th>
                        <th colspan="4">VSAT IP (SCADA)</th>
                        <th colspan="4">VSAT IP (NON SCADA)</th>
                        <th colspan="4">TOTAL SCADA</th>
                        <th colspan="4">TOTAL NON SCADA</th>
                    </tr>
                    <tr>
                        <th colspan="2">SUMBAR</th>
                        <th colspan="2">JAMBI</th>
                        <th colspan="2">SUMBAR</th>
                        <th colspan="2">JAMBI</th>
                        <th colspan="2">SUMBAR</th>
                        <th colspan="2">JAMBI</th>
                        <th colspan="2">SUMBAR</th>
                        <th colspan="2">JAMBI</th>
                        <th colspan="2">SUMBAR</th>
                        <th colspan="2">JAMBI</th>
                        <th colspan="2">SUMBAR</th>
                        <th colspan="2">JAMBI</th>
                        <th colspan="2">SUMBAR</th>
                        <th colspan="2">JAMBI</th>
                        <th colspan="2">SUMBAR</th>
                        <th colspan="2">JAMBI</th>
                        <th colspan="2">SUMBAR</th>
                        <th colspan="2">JAMBI</th>
                        <th colspan="2">SUMBAR</th>
                        <th colspan="2">JAMBI</th>
                        <th colspan="2">SUMBAR</th>
                        <th colspan="2">JAMBI</th>
                        <th colspan="2">SUMBAR</th>
                        <th colspan="2">JAMBI</th>
                    </tr>
                    <tr>
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
                    </tr>
                    <?php 
                    while ($d = mysqli_fetch_array($data)) {
                        ?>
                        <tr>
                            <td><?php echo $d['Tanggal']; ?></td>
                            <td><?php echo $d['IPVPN (SCADA) SUMBAR_JMLG']; ?></td>
                            <td><?php echo $d['IPVPN (SCADA) SUMBAR_DRS']; ?></td>
                            <td><?php echo $d['IPVPN (SCADA) JAMBI_JMLG']; ?></td>
                            <td><?php echo $d['IPVPN (SCADA) JAMBI_DRS']; ?></td>
                            <td><?php echo $d['IPVPN (NON SCADA) SUMBAR_JMLG']; ?></td>
                            <td><?php echo $d['IPVPN (NON SCADA) SUMBAR_DRS']; ?></td>
                            <td><?php echo $d['IPVPN (NON SCADA) JAMBI_JMLG']; ?></td>
                            <td><?php echo $d['IPVPN (NON SCADA) JAMBI_DRS']; ?></td>
                            <td><?php echo $d['INTERNET (SCADA) SUMBAR_JMLG']; ?></td>
                            <td><?php echo $d['INTERNET (SCADA) SUMBAR_DRS']; ?></td>
                            <td><?php echo $d['INTERNET (SCADA) JAMBI_JMLG']; ?></td>
                            <td><?php echo $d['INTERNET (SCADA) JAMBI_DRS']; ?></td>
                            <td><?php echo $d['INTERNET (NON SCADA) SUMBAR_JMLG']; ?></td>
                            <td><?php echo $d['INTERNET (NON SCADA) SUMBAR_DRS']; ?></td>
                            <td><?php echo $d['INTERNET (NON SCADA) JAMBI_JMLG']; ?></td>
                            <td><?php echo $d['INTERNET (NON SCADA) JAMBI_DRS']; ?></td>
                            <td><?php echo $d['Clear Channel (SCADA) SUMBAR_JMLG']; ?></td>
                            <td><?php echo $d['Clear Channel (SCADA) SUMBAR_DRS']; ?></td>
                            <td><?php echo $d['Clear Channel (SCADA) JAMBI_JMLG']; ?></td>
                            <td><?php echo $d['Clear Channel (SCADA) JAMBI_DRS']; ?></td>
                            <td><?php echo $d['Clear Channel (NON SCADA) SUMBAR_JMLG']; ?></td>
                            <td><?php echo $d['Clear Channel (NON SCADA) SUMBAR_DRS']; ?></td>
                            <td><?php echo $d['Clear Channel (NON SCADA) JAMBI_JMLG']; ?></td>
                            <td><?php echo $d['Clear Channel (NON SCADA) JAMBI_DRS']; ?></td>
                            <td><?php echo $d['METRONET (SCADA) SUMBAR_JMLG']; ?></td>
                            <td><?php echo $d['METRONET (SCADA) SUMBAR_DRS']; ?></td>
                            <td><?php echo $d['METRONET (SCADA) JAMBI_JMLG']; ?></td>
                            <td><?php echo $d['METRONET (SCADA) JAMBI_DRS']; ?></td>
                            <td><?php echo $d['METRONET (NON SCADA) SUMBAR_JMLG']; ?></td>
                            <td><?php echo $d['METRONET (NON SCADA) SUMBAR_DRS']; ?></td>
                            <td><?php echo $d['METRONET (NON SCADA) JAMBI_JMLG']; ?></td>
                            <td><?php echo $d['METRONET (NON SCADA) JAMBI_DRS']; ?></td>
                            <td><?php echo $d['VSAT IP (SCADA) SUMBAR_JMLG']; ?></td>
                            <td><?php echo $d['VSAT IP (SCADA) SUMBAR_DRS']; ?></td>
                            <td><?php echo $d['VSAT IP (SCADA) JAMBI_JMLG']; ?></td>
                            <td><?php echo $d['VSAT IP (SCADA) JAMBI_DRS']; ?></td>
                            <td><?php echo $d['VSAT IP (NON SCADA) SUMBAR_JMLG']; ?></td>
                            <td><?php echo $d['VSAT IP (NON SCADA) SUMBAR_DRS']; ?></td>
                            <td><?php echo $d['VSAT IP (NON SCADA) JAMBI_JMLG']; ?></td>
                            <td><?php echo $d['VSAT IP (NON SCADA) JAMBI_DRS']; ?></td>
                            <td><?php echo $d['TOTAL SCADA SUMBAR_JMLG']; ?></td>
                            <td><?php echo $d['TOTAL SCADA SUMBAR_DRS']; ?></td>
                            <td><?php echo $d['TOTAL SCADA JAMBI_JMLG']; ?></td>
                            <td><?php echo $d['TOTAL SCADA JAMBI_DRS']; ?></td>
                            <td><?php echo $d['TOTAL NON SCADA SUMBAR_JMLG']; ?></td>
                            <td><?php echo $d['TOTAL NON SCADA SUMBAR_DRS']; ?></td>
                            <td><?php echo $d['TOTAL NON SCADA JAMBI_JMLG']; ?></td>
                            <td><?php echo $d['TOTAL NON SCADA JAMBI_DRS']; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>