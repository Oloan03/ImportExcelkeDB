<!DOCTYPE html>
<html>
    <head>
        <title>Tambahkan Data Baru </title>
        <link rel="stylesheet" href="style.scss">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </head>
    <body>
        <div class="add-form">
            <a href="index.php"><i class="material-icons">arrow_back</i></a>
            <span class="title">Tambah data</span>
            <form method="post" class="form" action="process_add.php">
                <div class="grup">
                    <input type="text" name="No Tiket" required>
                    <label for="tiket">No Tiket</label>
                </div>
                <div class="grup">
                    <input type="text" name="Nama Service" required>
                    <label for="service">Service Name</label>
                </div>
                <div class="grup">
                    <input type="number" name="SID"required>
                    <label for="sid">SID</label>
                </div>
                <div class="grup">
                    <select name="Produk" required><option value='IP VPN'>IP VPN</option> <option value='INTERNET'>INTERNET</option> <option value='Clear Channel'>Clear Channel</option> <option value='METRONET'>METRONET</option><option value='VSAT IP'>VSAT IP</option></select>
                    <label for="produk">Produk</label>
                </div>
                <div class="grup">
                    <input type="text" name="Bandwith" required>
                    <label for="bandwith">Bandwith</label>
                </div>
                <div class="grup">
                    <input type="datetime" name="Tiket Open" required>
                    <label for="tiket_open">Tiket Open</label>
                </div>
                <div class="grup">
                    <input type="datetime" name="Tiket Close" required>
                    <label for="tiket_close">Tiket Close</label>
                </div>
                <div class="grup">
                    <input type="number" name="Stop_Clock_Durasi" required>
                    <label for="stop_clock_durasi">Stop Clock Durasi</label>
                </div>
                <div class="grup">
                    <input type="time" name="Durasi_Jam"required>
                    <label for="durasi_jam">Durasi Jam</label>
                </div>
                <div class="grup">
                    <input type="number" name="Durasi_Menit" required>
                    <label for="durasi_menit">Durasi Menit</label>
                </div>
                <div class="grup">
                    <input type="text" name="Penyebab" required>
                    <label for="penyebab">Penyebab</label>
                </div>
                <div class="grup">
                    <input type="text" name="Action" required>
                    <label for="action">Action</label>
                </div>
                <div class="grup">
                    <select name="Asman" required> <option value="SUMBAR">SUMBAR</option> <option value="JAMBI">JAMBI</option></select>
                    <label for="asman">Asman</label>
                </div>
                <div class="grup">
                    <select name="Kategori Layanan" required> <option value='SCADA NON REDUNDANT'>SCADA NON REDUNDANT</option> <option value='NON SCADA'>NON SCADA</option></select>
                    <label for="kategori_layanan">Kategori Layanan</label>
                </div>
                <div class="grup">
                    <input type="text" name="Unit PLN Pengguna" required>
                    <label for="unit_pln_user">Unit PLN Pengguna</label>
                </div>
                <div class="grup">
                    <input type="text" name="Jenis Gangguan" required>
                    <label for="jenis_gangguan">Jenis Gangguan</label>
                </div>
                <div class="grup">
                    <input type="text" name="Detail Gangguan" required>
                    <label for="detail_gangguan">Detail Gangguan</label>
                </div>
                <div class="grup">
                    <input type="text" name="Lokasi Gangguan" required>
                    <label for="lokasi_gangguan">Lokasi Gangguan</label>
                </div>
                <button type="submit" name="submit"><i class="material-icons">add_circle_outline</i>Tambah</button>
            </form>
        </div>
    </body>
</html>