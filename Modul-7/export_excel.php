<?php
include 'koneksi.php'; 

$tgl_mulai = $_GET['tgl_mulai'];
$tgl_selesai = $_GET['tgl_selesai'];

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan_penjualan.xls"); 

$query_rekap = "SELECT DATE_FORMAT(waktu_transaksi, '%d-%b-%y') as tanggal, SUM(total) as total_harian
                FROM transaksi 
                WHERE waktu_transaksi BETWEEN ? AND ?
                GROUP BY waktu_transaksi ORDER BY waktu_transaksi ASC";
$stmt_rekap = $koneksi->prepare($query_rekap);
$stmt_rekap->bind_param('ss', $tgl_mulai, $tgl_selesai);
$stmt_rekap->execute();
$result_rekap = $stmt_rekap->get_result();

$query_total = "SELECT COUNT(DISTINCT pelanggan_id) as jumlah_pelanggan, SUM(total) as jumlah_pendapatan 
                FROM transaksi 
                WHERE waktu_transaksi BETWEEN ? AND ?";
$stmt_total = $koneksi->prepare($query_total);
$stmt_total->bind_param('ss', $tgl_mulai, $tgl_selesai);
$stmt_total->execute();
$result_total = $stmt_total->get_result();
$data_total = $result_total->fetch_assoc();

?>
<h3>Rekap Laporan Penjualan <?php echo $tgl_mulai; ?> sampai <?php echo $tgl_selesai; ?></h3> 

<table border="1">
    <thead>
        <tr>
            <th>No</th> 
            <th>Total</th> 
            <th>Tanggal</th> 
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; while ($row = $result_rekap->fetch_assoc()): ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $row['total_harian']; ?></td> 
            <td><?php echo $row['tanggal']; ?></td> 
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<br>
<table border="1">
    <thead>
        <tr>
            <th>Jumlah Pelanggan</th> 
            <th>Jumlah Pendapatan</th> 
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $data_total['jumlah_pelanggan']; ?> Orang</td> 
            <td><?php echo $data_total['jumlah_pendapatan']; ?></td>
        </tr>
    </tbody>
</table>