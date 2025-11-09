<?php
// --- (BAGIAN 1: KONEKSI DATABASE) ---
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "penjualan"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// --- (BAGIAN 2: AMBIL ID TRANSAKSI (JIKA ADA DARI URL)) ---
$transaksi_id_terpilih = null;
if (isset($_GET['transaksi_id'])) {
    $transaksi_id_terpilih = $_GET['transaksi_id'];
}

// --- (BAGIAN 3: AMBIL DATA BARANG (UNTUK DROPDOWN)) ---
$sql_barang = "SELECT id, nama_barang FROM barang";
$result_barang = $conn->query($sql_barang);

// --- (BAGIAN 4: AMBIL DATA TRANSAKSI (UNTUK DROPDOWN)) ---
$sql_transaksi = "SELECT id, keterangan FROM transaksi ORDER BY id DESC";
$result_transaksi = $conn->query($sql_transaksi);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Detail Transaksi</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 20px; }
        .container { max-width: 500px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input,
        .form-group select {
            width: 100%; padding: 8px; box-sizing: border-box; 
            border: 1px solid #ccc; border-radius: 4px;
        }
        .btn {
            background-color: #007bff; color: white; padding: 10px 15px;
            border: none; border-radius: 4px; cursor: pointer;
            font-size: 16px; width: 100%;
        }
        .alert { padding: 10px; border-radius: 4px; margin-bottom: 15px; }
        .alert-sukses { background-color: #d4edda; color: #155724; }
        .alert-gagal { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="container">
        <?php if(isset($_GET['status'])): ?>
            <?php if($_GET['status'] == 'sukses'): ?>
                <div class="alert alert-sukses">Barang berhasil ditambahkan!</div>
            <?php elseif($_GET['status'] == 'gagal'): ?>
                <div class="alert alert-gagal"><?php echo urldecode($_GET['pesan']); ?></div>
            <?php endif; ?>
        <?php endif; ?>

        <h2>Tambah Detail Transaksi</h2>
        
        <form action="proses_detail.php" method="POST">
            
            <div class="form-group">
                <label for="barang_id">Pilih Barang</label>
                <select id="barang_id" name="barang_id" required>
                    <option value="">-- Pilih Barang --</option>
                    <?php
                    if ($result_barang->num_rows > 0) {
                        while($row_b = $result_barang->fetch_assoc()) {
                            echo "<option value='" . $row_b["id"] . "'>" . $row_b["nama_barang"] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="transaksi_id">ID Transaksi</label>
                <select id="transaksi_id" name="transaksi_id" required>
                    <option value="">-- Pilih ID Transaksi --</option>
                    <?php
                    if ($result_transaksi->num_rows > 0) {
                        while($row_t = $result_transaksi->fetch_assoc()) {
                            // Cek apakah ID ini sama dengan yang dikirim dari URL
                            $selected = ($row_t["id"] == $transaksi_id_terpilih) ? 'selected' : '';
                            echo "<option value='" . $row_t["id"] . "' " . $selected . ">";
                            echo "ID: " . $row_t["id"] . " (" . $row_t["keterangan"] . ")";
                            echo "</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="qty">Quantity</label>
                <input type="number" id="qty" name="qty" 
                       placeholder="Masukkan jumlah barang" min="1" value="1" required>
            </div>

            <button type="submit" class="btn">Tambah Detail Transaksi</button>
        </form>
        <br>
        <a href="index.php">Kembali ke Halaman Utama</a>
    </div>
</body>
</html>
<?php
$conn->close();
?>