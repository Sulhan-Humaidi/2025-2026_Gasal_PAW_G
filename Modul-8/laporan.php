<?php
?>

<div class="row">
    <div class="col-12">
        <h3 class="mb-4">🧾 Halaman Laporan Penjualan</h3>
        
        <div class="alert alert-primary" role="alert">
            Halaman ini menyediakan fitur pencarian dan tampilan laporan penjualan (misalnya berdasarkan tanggal, bulan, atau tahun).
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">Filter Laporan</div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label class="form-label">Dari Tanggal</label>
                            <input type="date" class="form-control" name="tgl_awal">
                        </div>
                        <div class="col-md-5 mb-3">
                            <label class="form-label">Sampai Tanggal</label>
                            <input type="date" class="form-control" name="tgl_akhir">
                        </div>
                        <div class="col-md-2 d-flex align-items-end mb-3">
                            <button type="submit" class="btn btn-info w-100 text-white">Tampilkan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">Hasil Laporan Penjualan (Contoh)</div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Transaksi</th>
                            <th>Kode Transaksi</th>
                            <th>Total Belanja</th>
                            <th>Kasir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" class="text-center">Silakan masukkan filter tanggal untuk menampilkan data.</td>
                        </tr>
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>