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

// --- (BAGIAN 2: CEK JIKA METODE ADALAH POST) ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // --- (BAGIAN 3: AMBIL DATA DARI FORM) ---
    $waktu_transaksi = $_POST['waktu_transaksi'];
    $keterangan = $_POST['keterangan'];
    $total = $_POST['total']; // 0
    $pelanggan_id = $_POST['pelanggan_id']; // Asumsi foreign key 'pelanggan_id'

    // --- (BAGIAN 4: QUERY INSERT DATA MASTER) ---
    $stmt = $conn->prepare("INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id) VALUES (?, ?, ?, ?)");
    // Asumsi: waktu(s), keterangan(s), total(i), pelanggan_id(i)
    $stmt->bind_param("ssii", $waktu_transaksi, $keterangan, $total, $pelanggan_id);

    // --- (BAGIAN 5: EKSEKUSI DAN REDIRECT) ---
    if ($stmt->execute()) {
        // Ambil ID transaksi baru
        $transaksi_id_baru = $conn->insert_id;
        
        // Redirect ke halaman tambah detail sambil membawa ID baru
        // Ini 'smart flow' agar dropdown di hal. detail langsung terisi
        header("Location: tambah_detail.php?transaksi_id=" . $transaksi_id_baru);
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Akses tidak sah.";
}
$conn->close();
?>