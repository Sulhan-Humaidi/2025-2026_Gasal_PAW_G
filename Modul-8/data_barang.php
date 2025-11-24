<?php
// FILE: data_barang.php
$pesan = "";

// LOGIKA CREATE
if (isset($_POST['tambah_barang'])) {
    $nama = trim($_POST['nama_barang']);
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];
    $kode = trim($_POST['kode_barang']);
    $supplier_id = $_POST['supplier_id'];

    // Query CREATE menggunakan nama kolom yang benar
    $query_tambah = "INSERT INTO barang (nama_barang, stok, harga, kode_barang, supplier_id) 
                     VALUES ('$nama', '$stok', '$harga', '$kode', '$supplier_id')";
    if (mysqli_query($koneksi, $query_tambah)) {
        $pesan = "<div class='alert alert-success'>Data barang **$nama** berhasil ditambahkan!</div>";
    } else {
        $pesan = "<div class='alert alert-danger'>Gagal menambahkan data: " . mysqli_error($koneksi) . "</div>";
    }
}

// LOGIKA UPDATE
if (isset($_POST['edit_barang'])) {
    $id_row = $_POST['id_row']; 
    $nama = trim($_POST['nama_barang']);
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];
    $kode = trim($_POST['kode_barang']);
    $supplier_id = $_POST['supplier_id'];
    
    // Query UPDATE menggunakan nama kolom yang benar
    $query_edit = "UPDATE barang SET nama_barang='$nama', stok='$stok', harga='$harga', kode_barang='$kode', supplier_id='$supplier_id' WHERE id='$id_row'";
    if (mysqli_query($koneksi, $query_edit)) {
        $pesan = "<div class='alert alert-success'>Data barang **$nama** berhasil diupdate!</div>";
    } else {
        $pesan = "<div class='alert alert-danger'>Gagal mengupdate data: " . mysqli_error($koneksi) . "</div>";
    }
}

// LOGIKA DELETE
if (isset($_GET['hapus_barang'])) {
    $id_hapus = $_GET['hapus_barang'];
    $query_hapus = "DELETE FROM barang WHERE id='$id_hapus'";
    if (mysqli_query($koneksi, $query_hapus)) {
        $pesan = "<div class='alert alert-success'>Data barang berhasil dihapus!</div>";
    } else {
        $pesan = "<div class='alert alert-danger'>Gagal menghapus data: " . mysqli_error($koneksi) . "</div>";
    }
    header("location: dashboard.php?page=barang");
    exit();
}

// LOGIKA READ
$query_tampil = "SELECT * FROM barang ORDER BY id DESC";
$data_barang = mysqli_query($koneksi, $query_tampil);

// Ambil data supplier untuk dropdown di form
$query_supplier = mysqli_query($koneksi, "SELECT id, nama FROM supplier ORDER BY nama ASC");
?>
<div class="row">
    <div class="col-12">
        <h3 class="mb-4">📦 Data Master Barang</h3>
        <?php echo $pesan; ?>
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahBarang">+ Tambah Barang Baru</button>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Stok</th>
                                <th>Harga Jual</th>
                                <th>Supplier ID</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($data_barang)) : ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['kode_barang'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($row['nama_barang'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($row['stok'] ?? ''); ?></td>
                                <td>Rp <?php echo number_format($row['harga'] ?? 0, 0, ',', '.'); ?></td>
                                <td><?php echo htmlspecialchars($row['supplier_id'] ?? ''); ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditBarang<?php echo $row['id']; ?>">Edit</button>
                                    <a href="dashboard.php?page=barang&hapus_barang=<?php echo $row['id']; ?>" onclick="return confirm('Yakin hapus?')" class="btn btn-sm btn-danger">Hapus</a>
                                </td>
                            </tr>
                            <div class="modal fade" id="modalEditBarang<?php echo $row['id']; ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning text-dark"><h5 class="modal-title">Edit Barang: <?php echo htmlspecialchars($row['nama_barang'] ?? ''); ?></h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                        <form method="POST" action="dashboard.php?page=barang">
                                            <div class="modal-body">
                                                <input type="hidden" name="id_row" value="<?php echo $row['id']; ?>">
                                                <div class="mb-3"><label class="form-label">Kode Barang</label><input type="text" class="form-control" name="kode_barang" value="<?php echo htmlspecialchars($row['kode_barang'] ?? ''); ?>"></div>
                                                <div class="mb-3"><label class="form-label">Nama Barang</label><input type="text" class="form-control" name="nama_barang" value="<?php echo htmlspecialchars($row['nama_barang'] ?? ''); ?>" required></div>
                                                <div class="mb-3"><label class="form-label">Stok</label><input type="number" class="form-control" name="stok" value="<?php echo htmlspecialchars($row['stok'] ?? 0); ?>" required></div>
                                                <div class="mb-3"><label class="form-label">Harga Jual</label><input type="number" class="form-control" name="harga" value="<?php echo htmlspecialchars($row['harga'] ?? 0); ?>" step="any" required></div>
                                                <div class="mb-3"><label class="form-label">Supplier</label>
                                                    <select class="form-select" name="supplier_id" required>
                                                        <option value="">-- Pilih Supplier --</option>
                                                        <?php 
                                                        // Reset pointer dan loop lagi untuk dropdown edit
                                                        mysqli_data_seek($query_supplier, 0); 
                                                        while($sup = mysqli_fetch_assoc($query_supplier)): 
                                                        ?>
                                                            <option value="<?php echo $sup['id']; ?>" 
                                                                <?php echo ($row['supplier_id'] == $sup['id']) ? 'selected' : ''; ?>>
                                                                <?php echo htmlspecialchars($sup['nama']); ?>
                                                            </option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button><button type="submit" name="edit_barang" class="btn btn-warning">Simpan Perubahan</button></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalTambahBarang" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white"><h5 class="modal-title">Tambah Data Barang</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form method="POST" action="dashboard.php?page=barang">
                <div class="modal-body">
                    <div class="mb-3"><label for="kode_barang" class="form-label">Kode Barang</label><input type="text" class="form-control" id="kode_barang" name="kode_barang"></div>
                    <div class="mb-3"><label for="nama_barang" class="form-label">Nama Barang</label><input type="text" class="form-control" id="nama_barang" name="nama_barang" required></div>
                    <div class="mb-3"><label for="stok" class="form-label">Stok</label><input type="number" class="form-control" id="stok" name="stok" required></div>
                    <div class="mb-3"><label for="harga" class="form-label">Harga Jual</label><input type="number" class="form-control" id="harga" name="harga" step="any" required></div>
                    <div class="mb-3"><label for="supplier_id" class="form-label">Supplier</label>
                        <select class="form-select" id="supplier_id" name="supplier_id" required>
                            <option value="">-- Pilih Supplier --</option>
                            <?php 
                            // Reset pointer dan loop lagi untuk dropdown tambah
                            mysqli_data_seek($query_supplier, 0); 
                            while($sup = mysqli_fetch_assoc($query_supplier)): 
                            ?>
                                <option value="<?php echo $sup['id']; ?>"><?php echo htmlspecialchars($sup['nama']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button><button type="submit" name="tambah_barang" class="btn btn-primary">Simpan Data</button></div>
            </form>
        </div>
    </div>
</div>