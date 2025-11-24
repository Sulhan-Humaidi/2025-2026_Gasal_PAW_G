<?php
// FILE: dashboard.php (Halaman Utama)
session_start();
include 'koneksi.php'; // Ambil koneksi database

// Proteksi Halaman: Jika belum login, lempar ke index.php
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:index.php");
    exit();
}

$level = $_SESSION['level'];
$nama = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .jumbotron-custom {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 5rem 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .jumbotron-custom h1 {
            font-weight: 700;
        }
        .navbar-brand, .nav-link, .dropdown-item {
            font-weight: 500;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">📊 Sistem Penjualan</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Home</a>
                    </li>

                    <?php if ($level == "1") { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                Data Master
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="dashboard.php?page=barang">Data Barang</a></li>
                                <li><a class="dropdown-item" href="dashboard.php?page=supplier">Data Supplier</a></li>
                                <li><a class="dropdown-item" href="dashboard.php?page=pelanggan">Data Pelanggan</a></li>
                                <li><a class="dropdown-item" href="dashboard.php?page=user">Data User</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php?page=transaksi">Transaksi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php?page=laporan">Laporan</a>
                        </li>
                    
                    <?php } elseif ($level == "2") { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php?page=transaksi">Transaksi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php?page=laporan">Laporan</a>
                        </li>
                    <?php } ?>

                </ul>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger btn-sm text-white px-3" href="logout.php">LOGOUT (<?php echo $nama; ?>)</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php
        // Logika Switch Case untuk memuat halaman berdasarkan parameter 'page'
        if(isset($_GET['page'])){
            $page = $_GET['page'];

            switch ($page) {
                case 'barang':
                    // Hak Akses Level 1
                    if ($level == "1") { include "data_barang.php"; } else { echo "<div class='alert alert-danger text-center'>Akses Ditolak! Anda tidak memiliki izin.</div>"; }
                    break;
                case 'supplier':
                    // Hak Akses Level 1
                    if ($level == "1") { include "data_supplier.php"; } else { echo "<div class='alert alert-danger text-center'>Akses Ditolak! Anda tidak memiliki izin.</div>"; }
                    break;
                case 'pelanggan':
                    // Hak Akses Level 1
                    if ($level == "1") { include "data_pelanggan.php"; } else { echo "<div class='alert alert-danger text-center'>Akses Ditolak! Anda tidak memiliki izin.</div>"; }
                    break;
                case 'user':
                    // Hak Akses Level 1
                    if ($level == "1") { include "data_user.php"; } else { echo "<div class='alert alert-danger text-center'>Akses Ditolak! Anda tidak memiliki izin.</div>"; }
                    break;
                case 'transaksi':
                    include "transaksi.php"; // Akses Level 1 & 2
                    break;
                case 'laporan':
                    include "laporan.php"; // Akses Level 1 & 2
                    break;
                default:
                    echo "<div class='alert alert-danger text-center' role='alert'><h3>Maaf. Halaman tidak ditemukan!</h3></div>";
                    break;
            }
        } else {
            // Halaman Home Default
            ?>
            <div class="jumbotron-custom">
                <div class="container-fluid">
                    <h1 class="display-4">Selamat Datang, <?php echo $nama; ?>!</h1>
                    <p class="lead">Anda telah berhasil login. Ini adalah halaman utama dashboard penjualan Anda.</p>
                    <hr class="my-4 bg-light">
                    <p>Anda saat ini memiliki hak akses sebagai **Level <?php echo $level; ?>**.</p>
                </div>
            </div>
            <?php
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>