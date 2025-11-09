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

// --- (BAGIAN 2: CEK METODE POST) ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Ambil data dari form
    $transaksi_id = $_POST['transaksi_id'];
    $barang_id = $_POST['barang_id'];
    $qty = $_POST['qty'];

    // Validasi dasar
    if (empty($transaksi_id) || empty($barang_id) || empty($qty) || $qty <= 0) {
        $pesan_error = "Data tidak lengkap. Pastikan semua field terisi.";
        header("Location: tambah_detail.php?transaksi_id=" . $transaksi_id . "&status=gagal&pesan=" . urlencode($pesan_error));
        exit();
    }

    // Gunakan Database Transaction
    $conn->begin_transaction();

    try {
        // --- (LANGKAH 1: VALIDASI BARANG SUDAH ADA?) --- [TUGAS 1]
        $stmt_check_duplikat = $conn->prepare("SELECT COUNT(*) as count FROM transaksi_detail WHERE transaksi_id = ? AND barang_id = ?");
        $stmt_check_duplikat->bind_param("ii", $transaksi_id, $barang_id);
        $stmt_check_duplikat->execute();
        $result_check = $stmt_check_duplikat->get_result();
        $row_check = $result_check->fetch_assoc();
        $stmt_check_duplikat->close();
        
        if ($row_check['count'] > 0) {
            throw new Exception("Error: Barang ini sudah ada di dalam transaksi tersebut.");
        }

        // --- (LANGKAH 2: AMBIL HARGA SATUAN BARANG) ---
        $stmt_get_harga = $conn->prepare("SELECT harga FROM barang WHERE id = ?");
        $stmt_get_harga->bind_param("i", $barang_id);
        $stmt_get_harga->execute();
        $result_harga = $stmt_get_harga->get_result();
        
        if ($result_harga->num_rows == 0) {
            throw new Exception("Barang tidak ditemukan.");
        }
        
        $row_harga = $result_harga->fetch_assoc();
        $harga_satuan = $row_harga['harga'];
        $stmt_get_harga->close();

        // --- (LANGKAH 3: HITUNG HARGA TOTAL DETAIL) --- [TUGAS 1]
        $harga_total_detail = $harga_satuan * $qty;

        // --- (LANGKAH 4: INSERT KE TABEL 'transaksi_detail') ---
        $stmt_insert_detail = $conn->prepare("INSERT INTO transaksi_detail (transaksi_id, barang_id, qty, harga) VALUES (?, ?, ?, ?)");
        $stmt_insert_detail->bind_param("iiid", $transaksi_id, $barang_id, $qty, $harga_total_detail);
        $stmt_insert_detail->execute();
        $stmt_insert_detail->close();

        // --- (LANGKAH 5: UPDATE OTOMATIS KOLOM 'total' DI 'transaksi') --- [TUGAS 3]
        $stmt_update_master = $conn->prepare(
            "UPDATE transaksi SET total = (
                SELECT SUM(harga) 
                FROM transaksi_detail 
                WHERE transaksi_id = ?
            ) WHERE id = ?"
        );
        $stmt_update_master->bind_param("ii", $transaksi_id, $transaksi_id);
        $stmt_update_master->execute();
        $stmt_update_master->close();

        // --- (LANGKAH 6: JIKA SEMUA BERHASIL, COMMIT) ---
        $conn->commit();
        
        // Redirect kembali agar bisa nambah barang lagi
        header("Location: tambah_detail.php?transaksi_id=" . $transaksi_id . "&status=sukses");
        exit();

    } catch (Exception $e) {
        // --- (LANGKAH 7: JIKA ADA ERROR, ROLLBACK) ---
        $conn->rollback();
        $pesan_error = $e->getMessage();
        header("Location: tambah_detail.php?transaksi_id=" . $transaksi_id . "&status=gagal&pesan=" . urlencode($pesan_error));
        exit();
    }

} else {
    echo "Akses tidak sah.";
}

$conn->close();
?>