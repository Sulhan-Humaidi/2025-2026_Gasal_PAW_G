<?php
// --- KONEKSI DATABASE ---
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "penjualan"; // Database kamu

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// --- AMBIL SEMUA DATA UNTUK DITAMPILKAN ---

// 1. Data Barang (FIX: Menggunakan 'supplier.nama')
$sql_barang = "SELECT barang.*, supplier.nama AS nama_supplier 
               FROM barang 
               LEFT JOIN supplier ON barang.supplier_id = supplier.id";
$result_barang = $conn->query($sql_barang);

// 2. Data Transaksi (FIX: Menggunakan 'pelanggan.nama')
$sql_transaksi = "SELECT transaksi.*, pelanggan.nama AS nama_pelanggan 
                  FROM transaksi 
                  LEFT JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id";
$result_transaksi = $conn->query($sql_transaksi);

// 3. Data Transaksi Detail
$sql_detail = "SELECT transaksi_detail.*, barang.nama_barang 
               FROM transaksi_detail 
               LEFT JOIN barang ON transaksi_detail.barang_id = barang.id";
$result_detail = $conn->query($sql_detail);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengelolaan Master Detail</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2 { border-bottom: 2px solid #007bff; padding-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        
        .button-container { margin-bottom: 20px; }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            font-size: 16px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            margin-right: 10px;
        }
        .btn-secondary { background-color: #6c757d; }
        .btn-delete {
            background-color: #dc3545;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>

    <h1>Pengelolaan Master Detail</h1>

    <div class="button-container">
        <a href="tambah_transaksi.php" class="btn">Tambah Transaksi (Master)</a>
        <a href="tambah_detail.php" class="btn btn-secondary">Tambah Transaksi Detail</a>
    </div>
    <hr>

    <h2>Barang</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Nama Supplier</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_barang->num_rows > 0): ?>
                <?php while($row = $result_barang->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['kode_barang']; ?></td>
                        <td><?php echo $row['nama_barang']; ?></td>
                        <td><?php echo $row['harga']; ?></td>
                        <td><?php echo $row['stok']; ?></td>
                        <td><?php echo $row['nama_supplier']; ?></td> 
                        <td>
                            <a href="hapus_barang.php?id=<?php echo $row['id']; ?>" 
                               class="btn-delete" 
                               onclick="return confirm('Apakah anda yakin ingin menghapus data ini?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="7">Data barang kosong</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h2>Transaksi</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Waktu Transaksi</th>
                <th>Keterangan</th>
                <th>Total</th>
                <th>Nama Pelanggan</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_transaksi->num_rows > 0): ?>
                <?php while($row = $result_transaksi->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['waktu_transaksi']; ?></td>
                        <td><?php echo $row['keterangan']; ?></td>
                        <td><?php echo $row['total']; ?></td>
                        <td><?php echo $row['nama_pelanggan']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5">Data transaksi kosong</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h2>Transaksi Detail</h2>
    <table>
        <thead>
            <tr>
                <th>Transaksi ID</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Qty</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_detail->num_rows > 0): ?>
                <?php while($row = $result_detail->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['transaksi_id']; ?></td>
                        <td><?php echo $row['nama_barang']; ?></td>
                        <td><?php echo $row['harga']; ?></td>
                        <td><?php echo $row['qty']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4">Data detail transaksi kosong</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

<script>
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    const pesan = urlParams.get('pesan');

    if (status) {
        alert(pesan);
        window.history.replaceState({}, document.title, window.location.pathname);
    }
</script>

</body>
</html>

<?php
// Tutup semua result dan koneksi
$result_barang->close();
$result_transaksi->close();
$result_detail->close();
$conn->close();
?>