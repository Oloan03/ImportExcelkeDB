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
            <h2>IMPORT DATA EXCEL KE DATABASE </h2>
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
            include 'connect.php';

            $data = mysqli_query($connect, "SELECT * FROM `data harian`");

            if (isset($_GET['month'])) {
                $pilihBln = $_GET['month'];
                $data = mysqli_query($connect, "SELECT * FROM `data harian` WHERE substr(`Tanggal`,6,2)=$pilihBln");
            } else {
                $data = mysqli_query($connect, "SELECT * FROM `data harian`");
            }

            $pdo = new PDO('mysql:host=localhost;dbname=DataGangguan', 'root', '');
            $stmt = $pdo->query('SELECT * FROM data');
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $reportData = array();
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
                            
                    echo '<div class="tabelSumbar">';
                        echo '<p><b>LAPORAN LAYANAN JARINGAN OPTI SUMBAR BULAN ' . $bulan . ' </b></p>';
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
                                        
                                            
                                    echo '</tr>
                                        <tr>
                                            <th>Frekuensi Gangguan</th>';
                                           
                                    echo '</tr>
                                        <tr>
                                            <th>Rata-rata Durasi Gangguan</th>';
                                            
                                            
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
                                            
                                    echo '</tr>
                                        <tr>
                                            <th>Frekuensi Gangguan</th>';
                                           
                                    echo '</tr>
                                        <tr>
                                            <th>Rata-rata Durasi Gangguan</th>';
                                           
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
                                           
                                echo '</tr>';
                                echo '<tr>
                                        <th>Frekuensi Gangguan</th>';
                                        
                                echo '</tr>';
                                echo '<tr>
                                        <th>Rata-rata Durasi Gangguan</th>';
                                        
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
                                        
                                    </tr>
                                    <tr>
                                        <th>Frekuensi Gangguan</th>
                                       
                                    </tr>
                                    <tr>
                                        <th>Rata-rata Durasi Gangguan</th>
                                       
                                    </tr>
                                </table>         
                echo '</div>';
            
        


        generateReport();
        ?>

        <footer>Done</footer>
    </body>
</html>