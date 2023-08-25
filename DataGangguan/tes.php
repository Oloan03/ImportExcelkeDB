<!DOCTYPE html>
<html>
<head>
    <title>Data Table</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:last-child {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php
    // Langkah 1: Hubungkan ke Database
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "datagangguan";

    $conn = mysqli_connect($host, $username, $password, $database);

    if (!$conn) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    // Langkah 2: Ambil Data dan Eksekusi Perintah SQL
    $sql = "SELECT * FROM data";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error: " . mysqli_error($conn));
    }

    // Langkah 4: Hitung Jumlah Data pada Setiap Kolom
    $jumlahKolom = mysqli_num_fields($result);
    $jumlahDataKolom = array_fill(0, $jumlahKolom, 0);

    while ($row = mysqli_fetch_row($result)) {
        for ($i = 0; $i < $jumlahKolom; $i++) {
            $jumlahDataKolom[$i] += $row[$i];
        }
    }

    // Langkah 5: Tampilkan Data pada Tabel HTML
    echo "<table>";
    while ($row = mysqli_fetch_row($result)) {
        echo "<tr>";
        for ($i = 0; $i < $jumlahKolom; $i++) {
            echo "<td>" . $row[$i] . "</td>";
        }
        echo "</tr>";
    }
    echo "<tr>";
    for ($i = 0; $i < $jumlahKolom; $i++) {
        echo "<td>" . $jumlahDataKolom[$i] . "</td>";
    }
    echo "</tr>";
    echo "</table>";

    // Langkah 6: Tutup Koneksi
    mysqli_close($conn);
    ?>


    <table>
        <tr>
            <!-- Ganti "Nama Kolom 1", "Nama Kolom 2", dst. dengan nama kolom sesuai tabel Anda -->
            <th>Nama Kolom 1</th>
            <th>Nama Kolom 2</th>
            <th>Nama Kolom 3</th>
            <th>Nama Kolom 4</th>
            <th>Nama Kolom 5</th>
        </tr>
        <?php
        // ... (Kode PHP dari contoh sebelumnya)
        ?>
    </table>
</body>
</html>
