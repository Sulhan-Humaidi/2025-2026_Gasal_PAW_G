<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "store";

$koneksi = mysqli_connect($servername,$username,$password,$database);

if (!$koneksi) {
    die("koneksi gagal: ". mysqli_connect_error());
}

$nama = "";
if (isset($_GET['id']) && !empty($_GET['id'])) {
    
    $id = $_GET['id'];
    
    
    $sql = "DELETE FROM supplier WHERE id = ?";
    
    if ($stmt = mysqli_prepare($koneksi, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error: Gagal menghapus data. " . mysqli_error($koneksi);
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: Kueri tidak valid. " . mysqli_error($koneksi);
    }
    
} else {
    header("Location: index.php");
    exit();
}
mysqli_close($koneksi);
?>