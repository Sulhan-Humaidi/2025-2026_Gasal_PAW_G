<?php
// --- (BAGIAN 1: KONEKSI DATABASE) ---
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "penjualan"; // Database kamu

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// --- (BAGIAN 2: AMBIL DATA PELANGGAN) ---
// FIX: Menggunakan 'nama'
$sql_pelanggan = "SELECT id, nama FROM pelanggan"; 
$result_pelanggan = $conn->query($sql_pelanggan);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Transaksi</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 20px; }
        .container { max-width: 500px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%; padding: 8px; box-sizing: border-box; 
            border: 1px solid #ccc; border-radius: 4px;
        }
        .btn {
            background-color: #007bff; color: white; padding: 10px 15px;
            border: none; border-radius: 4px; cursor: pointer;
            font-size: 16px; width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tambah Data Transaksi (Master)</h2>
        <form action="proses_transaksi.php" method="POST">
            
            <div class="form-group">
                <label for="waktu_transaksi">Waktu Transaksi</label>
                <input type="date" id="waktu_transaksi" name="waktu_transaksi" 
                       min="<?php echo date('Y-m-d'); ?>" required>
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea id="keterangan" name="keterangan" rows="4" 
                          placeholder="Masukkan keterangan transaksi" minlength="3" required></textarea>
            </div>

            <div class="form-group">
                <label for="total">Total</label>
                <input type="number" id="total" name="total" value="0" readonly>
            </div>

            <div class="form-group">
                <label for="pelanggan_id">Pelanggan</label>
                <select id="pelanggan_id" name="pelanggan_id" required>
                    <option value="">-- Pilih Pelanggan --</option>
                    <?php
                    if ($result_pelanggan->num_rows > 0) {
                        while($row = $result_pelanggan->fetch_assoc()) {
                            // FIX: Menggunakan 'nama'
                            echo "<option value='" . $row["id"] . "'>" . $row["nama"] . "</option>";
                        }
                    } else {
                        echo "<option value='' disabled>Data pelanggan kosong</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn">Tambah Transaksi & Lanjut Isi Detail</button>
        </form>
    </div>
</body>
</html>
<?php
$conn->close();
?>