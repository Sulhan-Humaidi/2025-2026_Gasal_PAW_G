<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Master Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Data Master Transaksi</h2>
        
        <a href="tambah_transaksi.php" class="btn btn-success">Tambah Transaksi</a>
        <a href="report_transaksi.php" class="btn btn-primary">Lihat Laporan Penjualan</a> 
        
        <table class="table table-bordered mt-3">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>ID Transaksi</th> 
                    <th>Waktu Transaksi</th> 
                    <th>Nama Pelanggan</th> 
                    <th>Keterangan</th> 
                    <th>Total</th> 
                    <th>Tindakan</th> 
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT t.id, t.waktu_transaksi, p.nama, t.keterangan, t.total
                          FROM transaksi t
                          JOIN pelanggan p ON t.pelanggan_id = p.id 
                          ORDER BY t.id ASC";
                
                $result = $koneksi->query($query);
                if (!$result) {
                    die("Error Query: " . $koneksi->error);
                }

                $no = 1;
                while ($row = $result->fetch_assoc()):
                ?>
                <tr>
                
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row['id']; ?></td> 
                    <td><?php echo $row['waktu_transaksi']; ?></td>
                    <td><?php echo $row['nama']; ?></td> <td><?php echo $row['keterangan']; ?></td>
                    <td>Rp<?php echo number_format($row['total'], 0, ',', '.'); ?></td>
                    <td>
                        <a href="detail_transaksi.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">Lihat Detail</a>
                        <a href="hapus_transaksi.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>