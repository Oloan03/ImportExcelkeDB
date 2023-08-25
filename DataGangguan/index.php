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
            
            <?php
            
            include ('connect.php');

            $data = mysqli_query($connect, "SELECT * FROM `data`");
            $searchQuery = "";

            if (isset($_GET['search'])) {
                $keyword = $_GET['keyword'];

                $searchQuery = "SELECT * FROM `data` WHERE
                                `No Tiket` LIKE '%$keyword%' OR
                                `Nama Service` LIKE '%$keyword%' OR
                                `SID` LIKE '%$keyword%' OR
                                `Produk` LIKE '%$keyword%' OR
                                `Bandwith` LIKE '%$keyword%' OR
                                `Tiket Open` LIKE '%$keyword%' OR
                                `Tiket Close` LIKE '%$keyword%' OR
                                `Stop Clock (Durasi)` LIKE '%$keyword%' OR
                                `Durasi (Jam)` LIKE '%$keyword%' OR
                                `Durasi (Menit)` LIKE '%$keyword%' OR
                                `Penyebab` LIKE '%$keyword%' OR
                                `Action` LIKE '%$keyword%' OR
                                `Asman` LIKE '%$keyword%' OR
                                `Kategori Layanan` LIKE '%$keyword%' OR
                                `Unit PLN Pengguna` LIKE '%$keyword%' OR
                                `Jenis Gangguan` LIKE '%$keyword%' OR
                                `Detail Gangguan` LIKE '%$keyword%' OR
                                `Lokasi Gangguan` LIKE '%$keyword%'";

                $data = mysqli_query($connect, $searchQuery === "" ? "SELECT * FROM `data`" : $searchQuery);
            }

            ?> 
            <script>
                function mySearch() {
                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById("search-input");
                    filter = input.value.toUpperCase();
                    table = document.getElementById("myTable");
                    tr = table.getElementsByTagName("tr");

                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[0];
                        if (td) {
                            txtValue = td.textContent || td.innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                }
            </script>

            <?php
                if (isset($_GET['month'])) {
                    $pilihBln = $_GET['month'];
                    $data = mysqli_query($connect, "SELECT * FROM `data` WHERE substr(`Tiket Open`,6,2)=$pilihBln");
                } else {
                    $data = mysqli_query($connect, "SELECT * FROM `data`");
                }
                if (isset($_GET['filter'])) {
                    $filter = $_GET['filter'];
                    switch ($filter) {
                        case 'sortbydate':
                            $sortbydate = $_GET['sortbydate'];
                            $data = mysqli_query($connect, "SELECT * FROM `data` ORDER BY `Tiket Open` $sortbydate");
                            break;
                        case 'sortbycategory':
                            $sortbycategory = $_GET['sortbycategory'];
                            $data = mysqli_query($connect, "SELECT * FROM `data` WHERE `Kategori Layanan` = '$sortbycategory'");
                            break;
                        case 'sortbyproduk':
                            $sortbyproduk = $_GET['sortbyproduk'];
                            $data = mysqli_query($connect, "SELECT * FROM `data` WHERE `Produk` = '$sortbyproduk'");
                            break;
                        case 'sortbyasman':
                            $sortbyasman = $_GET['sortbyasman'];
                            $data = mysqli_query($connect, "SELECT * FROM `data` WHERE `Asman` = '$sortbyasman'");
                            break;
                        default:
                            $data = mysqli_query($connect, "SELECT * FROM `data`");
                            break;
                    }
                }
            ?>
            
        

            <div class="content">
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
                <div class="navbtn">
                    <a href="index2.php?month=01">
                        <span class="button-text">Laporan</span>
                        <i class="material-icons">&#xf1be;</i>
                    </a>
                </div>
                <h3>LAPORAN DATA STATISTIK GANGGUAN JARINGAN</h3>
                <div class="header-tbl">
                    <div class="data">
                        <a href="add.php" class="button">
                            <span class="button-text">Tambah data</span>
                            <i class="material-icons">add</i>
                        </a>
                        <a href="testlaporan.php" class="button">
                            <span class="button-text">Laporan</span>
                            <i class="material-icons">library_books</i>
                        </a>
                    </div> 
                    <div class="search-box">
                            <input type="text" id="search-input" onkeyup="mySearch()" placeholder="Search...">
                            <i class="material-icons">search</i>
                    </div>
                    <button class="filterBtn" onclick="toggleFilterPopup()"><i class="material-icons">&#xE152;</i></button>
                    <div class="filterPopup" id="filterPopup" style="display: none">
                        <div class="filter">
                            <form method="get" action="index.php">
                                <select name="sortbydate">
                                    <option value="ASC">Awal ke Akhir</option>
                                    <option value="DESC">Akhir ke Awal</option>
                                </select>
                                <input type="hidden" name="filter" value="sortbydate">
                                <input type="submit" class="filter-ops" value="Urutkan">
                            </form>

                            <form method="get" action="index.php">
                                <select name="sortbycategory">
                                    <option value="SCADA NON REDUNDANT">SCADA NON REDUNDANT</option>
                                    <option value="NON SCADA">NON SCADA</option>
                                </select>
                                <input type="hidden" name="filter" value="sortbycategory">
                                <input type="submit" class="filter-ops" value="Filter">
                            </form>

                            <form method="get" action="index.php">
                                <select name="sortbyproduk">
                                    <option value="IP VPN">IP VPN</option>
                                    <option value="INTERNET">INTERNET</option>
                                    <option value="Clear Channel">Clear Channel</option>
                                    <option value="METRONET">METRONET</option>
                                    <option value="VSAT IP">VSAT IP</option>
                                </select>
                                <input type="hidden" name="filter" value="sortbyproduk">
                                <input type="submit" class="filter-ops" value="Filter">
                            </form>

                            <form method="get" action="index.php">
                                <select name="sortbyasman">
                                    <option value="SUMBAR">SUMBAR</option>
                                    <option value="JAMBI">JAMBI</option>
                                </select>
                                <input type="hidden" name="filter" value="sortbyasman">
                                <input type="submit" class="filter-ops" value="Filter">
                            </form>
                        </div>
                    </div>
                    
                    <script>
                        function toggleFilterPopup() {
                            var popup = document.getElementById("filterPopup");
                            var button = document.querySelector(".filterBtn");

                            if (popup.style.display === "block") {
                                popup.style.display = "none";
                                button.innerHTML = "<i class='material-icons'>&#xE152;</i>";
                            } else {
                                popup.style.display = "block";
                                button.innerHTML = "<i class='material-icons'>&#xEb57;</i>";
                            }
                        }
                    </script>
                </div>
                    
                <div style="overflow-x: auto;">
                    <table id="myTable">
                        <tr>
                            <th>No</th>
                            <th>No Tiket</th>
                            <th>Nama Service</th>
                            <th>SID</th>
                            <th>Produk</th>
                            <th>Bandwith</th>
                            <th>Tiket Open</th>
                            <th>Tiket Close</th>
                            <th>Stop Clock (Durasi)</th>
                            <th>Durasi (Jam)</th>
                            <th>Durasi (Menit)</th>
                            <th>Penyebab</th>
                            <th>Action</th>
                            <th>Asman</th>
                            <th>Kategori Layanan</th>
                            <th>Unit PLN Pengguna</th>
                            <th>Jenis Gangguan</th>
                            <th>Detail Gangguan</th>
                            <th>Lokasi Gangguan</th>
                            <th>E/D</th>
                        </tr>
                        <?php
                        $no = 1;
                        while ($d = mysqli_fetch_array($data)) {
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $d['No Tiket']; ?></td>
                                <td><?php echo $d['Nama Service']; ?></td>
                                <td><?php echo $d['SID']; ?></td>
                                <td><?php echo $d['Produk']; ?></td>
                                <td><?php echo $d['Bandwith']; ?></td>
                                <td><?php echo $d['Tiket Open']; ?></td>
                                <td><?php echo $d['Tiket Close']; ?></td>
                                <td><?php echo $d['Stop Clock (Durasi)']; ?></td>
                                <td><?php echo $d['Durasi (Jam)']; ?></td>
                                <td><?php echo $d['Durasi (Menit)']; ?></td>
                                <td><?php echo $d['Penyebab']; ?></td>
                                <td><?php echo $d['Action']; ?></td>
                                <td><?php echo $d['Asman']; ?></td>
                                <td><?php echo $d['Kategori Layanan']; ?></td>
                                <td><?php echo $d['Unit PLN Pengguna']; ?></td>
                                <td><?php echo $d['Jenis Gangguan']; ?></td>
                                <td><?php echo $d['Detail Gangguan']; ?></td>
                                <td><?php echo $d['Lokasi Gangguan']; ?></td>
                                <td>
                                    <a href="edit.php?id=<?php echo $d['No']; ?>" id="editbtn"><i class="material-icons">&#xE254;</i></a>
                                    <a href="delete.php?id=<?php echo $d['No']; ?>" id="deletebtn"><i class="material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                
                </div>
                
                <div id="editPopup" style="display: none;">
                    
                </div>
                <script>
                    function mySearch() {
                        var input, filter, table, tr, td, i,txtValue;
                        input = document.getElementById("search-input");
                        filter = input.value.toUpperCase();
                        table = document.getElementById("myTable");
                        tr = table.getElementsByTagName("tr");

                        for (i = 1; i < tr.length; i++) {
                            var found = false;
                            for (j = 0; j < tr[i].cells.length; j++) {
                                td = tr[i].cells[j];
                                if (td) {
                                    txtValue = td.textContent || td.innerText;
                                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                        found = true;
                                        break;
                                    }
                                }
                            }
                            if (found) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }

                    document.getElementById("editbtn").addEventListener("click", function() {
                        var edit = document.getElementById("editPopup");

                        fetch("edit.php")
                            .then(response => response.text())
                            .then(data => {
                                edit.innerHTML = data;
                                edit.style.display = "block";
                            });
                    });
                    function closePopup() {
                        var edit = document.getElementById("editPopup");
                        edit.style.display = "none";
                        edit.innerHTML = "";
                    }
                </script>
            </div>
            <button class="clear" id="clear-btn" onclick="showPopUp()"><i class="material-icons">&#xE872;</i>Hapus data</button>
            <div id="popup" class="popup">
                <div class="popup-content">
                    <span class="close" onclick="hidePopup()">&times;</span>
                    <p>Apakah anda yakin ingin menghapus seluruh data?</p>
                    <a class="confirm-btm" href="clear.php"><i class="material-icons">&#xE872;</i></a>
                    <button class="cancel-btn" onclick="hidePopup()"><i class="material-icons">&#xE5cd;</i></button>
                </div>
            </div>

            <script>
                function showPopUp() {
                    const popup = document.getElementById("popup");
                    popup.style.display ="flex";
                }
                function hidePopup() {
                    const popup = document.getElementById("popup");
                    popup.style.display = "none";
                }
                function clearData() {
                    fetch('clear.php', {
                        method: 'POST',
                    })

                    hidePopup();
                }
            </script>

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

            <br/><br/>
            <?php
            $reset = "ALTER TABLE `Data` AUTO_INCREMENT = 1";
            mysqli_query($connect, $reset);
            ?>
        </div>
    </body>
</html>