<?php
include 'koneksi.php';
$pesan = ''; // Variabel untuk pesan status

// Cek apakah form disubmit (method POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Ambil data dari form
    $waktu_transaksi = $_POST['waktu_transaksi'];
    $keterangan = $_POST['keterangan'];
    $total = $_POST['total'];
    $pelanggan_id = $_POST['pelanggan_id'];

    // 2. Buat query SQL INSERT
    $query = "INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id) 
              VALUES (?, ?, ?, ?)";
    
    $stmt = $koneksi->prepare($query);

    if ($stmt === false) {
        $pesan = "Error mempersiapkan query: " . $koneksi->error;
    } else {
        // 3. Bind parameter dan eksekusi
        $stmt->bind_param('ssis', $waktu_transaksi, $keterangan, $total, $pelanggan_id);
        
        if ($stmt->execute()) {
            // 4. Jika berhasil, alihkan ke index.php
            header("Location: index.php?status=tambah_sukses");
            exit;
        } else {
            $pesan = "Error: Gagal menyimpan data. " . $stmt->error;
        }
        $stmt->close();
    }
}

// 5. Ambil data pelanggan untuk dropdown
$query_pelanggan = "SELECT id, nama FROM pelanggan ORDER BY nama ASC";
$result_pelanggan = $koneksi->query($query_pelanggan);

$koneksi->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Transaksi Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Tambah Transaksi Baru</h2>

        <?php if (!empty($pesan)): // Tampilkan pesan error jika ada ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $pesan; ?>
        </div>
        <?php endif; ?>

        <form action="tambah_transaksi.php" method="POST">
            <div class="mb-3">
                <label for="waktu_transaksi" class="form-label">Tanggal Transaksi</label>
                <input type="date" class="form-control" id="waktu_transaksi" name="waktu_transaksi" required>
            </div>
            
            <div class="mb-3">
                <label for="pelanggan_id" class="form-label">Nama Pelanggan</label>
                <select class="form-select" id="pelanggan_id" name="pelanggan_id" required>
                    <option value="">-- Pilih Pelanggan --</option>
                    <?php
                    // 6. Loop data pelanggan ke dalam <option>
                    if ($result_pelanggan->num_rows > 0) {
                        while ($row_pelanggan = $result_pelanggan->fetch_assoc()) {
                            echo '<option value="' . $row_pelanggan['id'] . '">' . $row_pelanggan['nama'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Contoh: Self pickup" required>
            </div>

            <div class="mb-3">
                <label for="total" class="form-label">Total (Rp)</label>
                <input type="number" class="form-control" id="total" name="total" placeholder="Contoh: 1500000" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>