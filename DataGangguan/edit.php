<!DOCTYPE html>
<html>
    <head>
        <title>Edit Data</title>
        <link rel="stylesheet" href="style.scss">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </head>
    <body>
        <div class="edit-form">
            <a href="index.php" class="material-icons">arrow_back</a>
            <span class="title">Edit data</span>
            <?php 
            include ('connect.php');

            if(isset($_GET['id'])) {
                $id = $_GET['id'];

                $sql = "SELECT * FROM data WHERE No='$id'";
                $result = mysqli_query($connect, $sql);

                if (mysqli_num_rows($result) > 0) {
                    $data = mysqli_fetch_assoc($result);
                } else {
                    die("Data tidak tidak ditemukan...");
                }
            } else {
                die("Data tidak diberikan...");
            }
            ?>
            <form method="post" class="form" action="process_edit.php">
                <input type="hidden" name="id" value="<?php echo $data['No']; ?>">
                <div class="grup">
                    <input type="text" name="No Tiket" value="<?php echo $data['No Tiket']; ?>" placeholder="" required>
                    <label for="tiket">No Tiket</label>
                </div>
                <div class="grup">
                    <input type="text" name="Nama Service" value="<?php echo $data['Nama Service']; ?>" placeholder="" required>
                    <label for="service">Nama Service</label>
                </div>
                <div class="grup">
                    <input typ="text" name="SID" value="<?php echo $data['SID']; ?>" placeholder="" required>
                    <label for="sid">SID</label>
                </div>
                <div class="grup">
                    <select name="Produk" value="<?php echo $data['Produk']; ?>" required><option value='IP VPN'>IP VPN</option> <option value='INTERNET'>INTERNET</option> <option value='Clear Chanel'>Clear Chanel</option> <option value='METRONET'>METRONET</option> <option value='VSAT IP'>VSAT IP</option></select>
                    <label for="Produk">Produk</label>
                </div>
                <div class="grup">
                    <input type="text" name="Bandwith" value="<?php echo $data['Bandwith']; ?>" placeholder="" required>
                    <label for="bandwith">Bandwith</label>
                </div>
                <div class="grup">
                    <input type="datetime" name="Tiket Open" value="<?php echo $data['Tiket Open']; ?>" placeholder="" required>
                    <label for="tiketopen">Tiket Open</label>
                </div>
                <div class="grup">
                    <input type="datetime" name="Tiket Close" value="<?php echo $data['Tiket Close']; ?>" placeholder="" required>
                    <label for="tiketClose">Tiket Close</label>
                </div>
                <div class="grup">
                    <input typ="text" name="Stop_Clock_Durasi" value="<?php echo $data['Stop Clock (Durasi)']; ?>" placeholder="" required>
                    <label for="stopclockdurasi">Stop Clock Durasi</label>
                </div>
                <div class="grup">
                    <input type="time" name="Durasi_Jam" value="<?php echo $data['Durasi (Jam)']; ?>" placeholder="" required>
                    <label for="durasi_jam">Durasi Jam</label>
                </div>
                <div class="grup">
                    <input type="text" name="Durasi_Menit" value="<?php echo $data['Durasi (Menit)']; ?>" placeholder="" required>
                    <label for="durasi_menit">Durasi Menit</label>
                </div>
                <div class="grup">
                    <input type="text" name="Penyebab" value="<?php echo $data['Penyebab']; ?>" placeholder="" required>
                    <label for="penyebab">Penyebab</label>
                </div>
                <div class="grup">
                    <input type="text" name="Action" value="<?php echo $data['Action']; ?>" placeholder="" required>
                    <label for="action">Action</label>
                </div>
                <div class="grup">
                    <select name="Asman" value="<?php echo $data['Asman']; ?>" required><option value='SUMBAR'>SUMBAR</option> <option value='JAMBI'>JAMBI</option></select>
                    <label for="asman">Asman</label>
                </div>
                <div class="grup">
                    <select name="Kategori_Layanan" value="<?php echo $data['Kategori Layanan']; ?>" required><option value="SCADA NON REDUNDANT">SCADA NON REDUNDANT</option> <option value="NON SCADA">NON SCADA</option>
                    <label for="kategori_layanan">Kategori Layanan</label>
                </div>
                <div class="grup">
                    <input type="text" name="Unit_PLN_Pengguna" value="<?php echo $data['Unit PLN Pengguna']; ?>" placeholder="" required>
                    <label for="unit_pln_user">Unit_PLN_Pengguna</label>
                </div>
                <div class="grup">
                    <input type="text" name="Jenis_Gangguan" value="<?php echo $data['Jenis Gangguan']; ?>" placeholder="" required>
                    <label for="jenis_gangguan">Jenis Gangguan</label>
                </div>
                <div class="grup">
                    <input type="text" name="Detail_Gangguan" value="<?php echo $data['Detail Gangguan']; ?>" placeholder="" required>
                    <label for="detail_gangguan">Detail Gangguan</label>
                </div>
                <div class="grup">
                    <input type="text" name="Lokasi_Gangguan" value="<?php echo $data['Lokasi Gangguan']; ?>" placeholder="" required>
                    <label for="lokasi_gangguan">Lokasi Gangguan</label>
                </div>
                <button type="submit" name="submit">Simpan</button>
            </form>
            <br>
            
        </div>
    </body>
</html>