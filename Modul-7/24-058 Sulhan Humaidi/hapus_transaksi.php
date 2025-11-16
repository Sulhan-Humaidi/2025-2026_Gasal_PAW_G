<?php
include 'koneksi.php';

// 1. Ambil ID dari URL
if (isset($_GET['id'])) {
    $id_transaksi = $_GET['id'];

    // 2. Buat query SQL DELETE
    // Kita menggunakan prepared statement untuk keamanan
    $query = "DELETE FROM transaksi WHERE id = ?";
    $stmt = $koneksi->prepare($query);
    
    if ($stmt === false) {
        die("Error mempersiapkan query: " . $koneksi->error);
    }

    // 3. Bind ID ke query dan eksekusi
    $stmt->bind_param('s', $id_transaksi); // 's' karena ID Anda bisa jadi string (seperti 'PLG-A')

    if ($stmt->execute()) {
        // 4. Jika berhasil, kembali ke halaman utama
        header("Location: index.php?status=hapus_sukses");
        exit;
    } else {
        // 5. Jika gagal, tampilkan error
        echo "Error: Gagal menghapus data. " . $stmt->error;
    }

    $stmt->close();
} else {
    // Jika tidak ada ID di URL, kembali ke index
    header("Location: index.php");
    exit;
}

$koneksi->close();
?>