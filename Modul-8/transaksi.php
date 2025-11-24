<?php

?>

<div class="row">
    <div class="col-12">
        <h3 class="mb-4">💰 Halaman Transaksi Penjualan</h3>
        
        <div class="alert alert-info" role="alert">
            Halaman ini adalah tempat Kasir/Admin memproses penjualan.
            Diperlukan integrasi dengan Data Barang dan Data Pelanggan.
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">Input Penjualan Baru</div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Cari Barang</label>
                            <input type="text" class="form-control" placeholder="Ketik nama atau kode barang...">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Jumlah Beli</label>
                            <input type="number" class="form-control" value="1">
                        </div>
                        <div class="col-md-6 d-flex align-items-end mb-3">
                            <button type="submit" class="btn btn-success w-100">Tambah ke Keranjang</button>
                        </div>
                    </div>
                </form>
                
                <hr>

                <h5>Keranjang Belanja</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" class="text-center">Belum ada barang di keranjang.</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>TOTAL KESELURUHAN</strong></td>
                            <td colspan="2"><strong>Rp 0.00</strong></td>
                        </tr>
                    </tfoot>
                </table>

                <button class="btn btn-lg btn-success w-100 mt-3">PROSES PEMBAYARAN & SIMPAN TRANSAKSI</button>
            </div>
        </div>

    </div>
</div>