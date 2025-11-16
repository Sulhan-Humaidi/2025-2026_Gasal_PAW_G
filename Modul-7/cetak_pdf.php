<?php
require 'vendor/autoload.php'; 
require 'koneksi.php'; 

use Dompdf\Dompdf;
use Dompdf\Options;

$tgl_mulai = $_GET['tgl_mulai'];
$tgl_selesai = $_GET['tgl_selesai'];

$query_rekap = "SELECT DATE_FORMAT(waktu_transaksi, '%d Nov %Y') as tanggal, SUM(total) as total_harian
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

$html = '
<style>
    body { font-family: sans-serif; font-size: 12px; }
    table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
    h1, h3 { text-align: center; }
</style>
';

$html .= '<h1>Rekap Laporan Penjualan</h1>';
$html .= '<p style="text-align: center;">Periode: ' . $tgl_mulai . ' sampai ' . $tgl_selesai . '</p>';

$html .= '<h3>Rekap Harian</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>';
$no = 1;
while ($row = $result_rekap->fetch_assoc()) {
    $html .= '<tr>
                <td>' . $no++ . '</td>
                <td>' . $row['tanggal'] . '</td>
                <td>Rp' . number_format($row['total_harian'], 0, ',', '.') . '</td>
            </tr>';
}
$html .= '</tbody></table>';

$html .= '<h3>Total Keseluruhan</h3>
        <table style="width: 50%; margin: auto;">
            <thead>
                <tr>
                    <th>Jumlah Pelanggan</th>
                    <th>Jumlah Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>' . $data_total['jumlah_pelanggan'] . ' Orang</td>
                    <td>Rp' . number_format($data_total['jumlah_pendapatan'], 0, ',', '.') . '</td>
                </tr>
            </tbody>
        </table>';

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('defaultFont', 'Arial');
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("laporan_penjualan.pdf", ["Attachment" => 1]); 

?>