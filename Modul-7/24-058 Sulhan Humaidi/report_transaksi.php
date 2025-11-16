<?php
include 'koneksi.php'; 

$tgl_mulai = isset($_GET['tgl_mulai']) ? $_GET['tgl_mulai'] : '';
$tgl_selesai = isset($_GET['tgl_selesai']) ? $_GET['tgl_selesai'] : '';

$data_rekap = [];
$data_total = ['jumlah_pelanggan' => 0, 'jumlah_pendapatan' => 0];
$chart_labels = [];
$chart_data = [];

if (!empty($tgl_mulai) && !empty($tgl_selesai)) {
    $query_rekap = "SELECT 
                        waktu_transaksi as tanggal, 
                        SUM(total) as total_harian
                    FROM 
                        transaksi 
                    WHERE 
                        waktu_transaksi BETWEEN ? AND ?
                    GROUP BY 
                        waktu_transaksi
                    ORDER BY 
                        tanggal ASC";
    
    $stmt_rekap = $koneksi->prepare($query_rekap);
    $stmt_rekap->bind_param('ss', $tgl_mulai, $tgl_selesai);
    $stmt_rekap->execute();
    $result_rekap = $stmt_rekap->get_result();
    
    while ($row = $result_rekap->fetch_assoc()) {
        $data_rekap[] = $row;
        $chart_labels[] = date('d Nov Y', strtotime($row['tanggal'])); 
        $chart_data[] = $row['total_harian'];
    }

    $query_total = "SELECT 
                        COUNT(DISTINCT pelanggan_id) as jumlah_pelanggan, 
                        SUM(total) as jumlah_pendapatan 
                    FROM 
                        transaksi 
                    WHERE 
                        waktu_transaksi BETWEEN ? AND ?";
    
    $stmt_total = $koneksi->prepare($query_total);
    $stmt_total->bind_param('ss', $tgl_mulai, $tgl_selesai);
    $stmt_total->execute();
    $result_total = $stmt_total->get_result();
    $data_total = $result_total->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Laporan Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-4">
        <h3>Rekap Laporan Penjualan</h3> 
        <a href="index.php" class="btn btn-secondary mb-3">&lt; Kembali</a> 

        <form method="GET" action="" class="mb-3 p-3 bg-light border rounded">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="tgl_mulai" class="form-control" value="<?php echo $tgl_mulai; ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="tgl_selesai" class="form-control" value="<?php echo $tgl_selesai; ?>" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100">Tampilkan</button> 
                </div>
            </div>
        </form>

        <?php if (!empty($data_rekap)): ?>
            <hr>
            <div id="laporan-area">
                <h4>
                    Rekap Laporan Penjualan <?php echo $tgl_mulai; ?> sampai <?php echo $tgl_selesai; ?> 
                </h4>

                <a href="cetak_pdf.php?tgl_mulai=<?php echo $tgl_mulai; ?>&tgl_selesai=<?php echo $tgl_selesai; ?>" class="btn btn-warning" target="_blank">Cetak</a> 
                <a href="export_excel.php?tgl_mulai=<?php echo $tgl_mulai; ?>&tgl_selesai=<?php echo $tgl_selesai; ?>" class="btn btn-info">Excel</a> 

                <div style="width: 80%; margin: 20px auto;">
                    <canvas id="myChart"></canvas>
                </div>

                <h5 class="mt-4">Rekap Harian</h5>
                <table class="table table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th> 
                            <th>Tanggal</th> 
                            <th>Total</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($data_rekap as $row): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo date('d Nov Y', strtotime($row['tanggal'])); ?></td>
                            <td>Rp<?php echo number_format($row['total_harian'], 0, ',', '.'); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <h5 class="mt-4">Total Keseluruhan</h5>
                <table class="table table-bordered" style="width: 400px;">
                    <thead class="table-primary">
                        <tr>
                            <th>Jumlah Pelanggan</th> 
                            <th>Jumlah Pendapatan</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $data_total['jumlah_pelanggan']; ?> Orang</td> 
                            <td>Rp<?php echo number_format($data_total['jumlah_pendapatan'], 0, ',', '.'); ?></td> 
                        </tr>
                    </tbody>
                </table>
            </div>

            <script>
                const ctx = document.getElementById('myChart');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($chart_labels); ?>,
                        datasets: [{
                            label: 'Total',
                            data: <?php echo json_encode($chart_data); ?>,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: { scales: { y: { beginAtZero: true } } }
                });
            </script>
        <?php elseif (!empty($tgl_mulai)): ?>
            <hr>
            <div class="alert alert-warning">Tidak ada data untuk rentang tanggal yang dipilih.</div>
        <?php endif; ?>
    </div>
</body>
</html>