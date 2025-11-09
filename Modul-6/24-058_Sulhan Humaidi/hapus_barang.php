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

// --- (BAGIAN 2: AMBIL ID DARI URL) ---
if (isset($_GET['id'])) {
    $barang_id = $_GET['id'];
} else {
    header("Location: index.php?status=gagal&pesan=ID Barang tidak ditemukan.");
    exit();
}

$status = "gagal";
$pesan = "";

$conn->begin_transaction();

try {
    // --- (BAGIAN 3: VALIDASI TUGAS 2) ---
    // Cek apakah barang_id sudah digunakan di tabel 'transaksi_detail'
    $stmt_check = $conn->prepare("SELECT COUNT(*) as count FROM transaksi_detail WHERE barang_id = ?");
    $stmt_check->bind_param("i", $barang_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row_check = $result_check->fetch_assoc();
    $stmt_check->close();

    if ($row_check['count'] > 0) {
        // JIKA BARANG SUDAH DIGUNAKAN [TUGAS 2]
        throw new Exception("Barang tidak dapat dihapus karena digunakan dalam transaksi detail");
        
    } else {
        // JIKA BARANG AMAN (BELUM DIGUNAKAN)
        $stmt_delete = $conn->prepare("DELETE FROM barang WHERE id = ?");
        $stmt_delete->bind_param("i", $barang_id);
        $stmt_delete->execute();
        
        if ($stmt_delete->affected_rows > 0) {
            $status = "sukses";
            $pesan = "Data barang berhasil dihapus.";
        } else {
            throw new Exception("Gagal menghapus data. Barang tidak ditemukan.");
        }
        $stmt_delete->close();
    }
    
    $conn->commit();

} catch (Exception $e) {
    $conn->rollback();
    $status = "gagal";
    $pesan = $e->getMessage();
}

// --- (BAGIAN 4: REDIRECT KEMBALI KE INDEX.PHP DENGAN PESAN) ---
$conn->close();
header("Location: index.php?status=" . $status . "&pesan=" . urlencode($pesan));
exit();

?>