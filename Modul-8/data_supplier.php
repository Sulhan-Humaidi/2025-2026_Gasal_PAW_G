<?php
// FILE: data_supplier.php
$pesan = "";

// LOGIKA CREATE
if (isset($_POST['tambah_supplier'])) {
    // Menggunakan nama kolom yang benar: nama, telp, alamat
    $nama = trim($_POST['nama_supplier']); // Variabel dari form
    $alamat = trim($_POST['alamat']);
    $telp = trim($_POST['telepon']); // Variabel dari form

    // Query CREATE menggunakan nama kolom: nama, telp, alamat
    $query_tambah = "INSERT INTO supplier (nama, alamat, telp) VALUES ('$nama', '$alamat', '$telp')";
    if (mysqli_query($koneksi, $query_tambah)) {
        $pesan = "<div class='alert alert-success'>Data supplier **$nama** berhasil ditambahkan!</div>";
    } else {
        $pesan = "<div class='alert alert-danger'>Gagal menambahkan data: " . mysqli_error($koneksi) . "</div>";
    }
}

// LOGIKA UPDATE
if (isset($_POST['edit_supplier'])) {
    $id_row = $_POST['id_row']; 
    $nama = trim($_POST['nama_supplier']);
    $alamat = trim($_POST['alamat']);
    $telp = trim($_POST['telepon']); 
    
    // Query UPDATE menggunakan nama kolom: nama, telp, alamat
    $query_edit = "UPDATE supplier SET nama='$nama', alamat='$alamat', telp='$telp' WHERE id='$id_row'";
    if (mysqli_query($koneksi, $query_edit)) {
        $pesan = "<div class='alert alert-success'>Data supplier **$nama** berhasil diupdate!</div>";
    } else {
        $pesan = "<div class='alert alert-danger'>Gagal mengupdate data: " . mysqli_error($koneksi) . "</div>";
    }
}

// LOGIKA DELETE
if (isset($_GET['hapus_supplier'])) {
    $id_hapus = $_GET['hapus_supplier'];
    $query_hapus = "DELETE FROM supplier WHERE id='$id_hapus'";
    if (mysqli_query($koneksi, $query_hapus)) {
        $pesan = "<div class='alert alert-success'>Data supplier berhasil dihapus!</div>";
    } else {
        $pesan = "<div class='alert alert-danger'>Gagal menghapus data: " . mysqli_error($koneksi) . "</div>";
    }
    header("location: dashboard.php?page=supplier");
    exit();
}

// LOGIKA READ (ORDER BY id)
$query_tampil = "SELECT * FROM supplier ORDER BY id DESC";
$data_supplier = mysqli_query($koneksi, $query_tampil);
?>
<div class="row">
    <div class="col-12">
        <h3 class="mb-4">🚚 Data Master Supplier</h3>
        <?php echo $pesan; ?>
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahSupplier">+ Tambah Supplier Baru</button>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>ID</th>
                                <th>Nama Supplier</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($data_supplier)) : ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['nama'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($row['alamat'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($row['telp'] ?? ''); ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditSupplier<?php echo $row['id']; ?>">Edit</button>
                                    <a href="dashboard.php?page=supplier&hapus_supplier=<?php echo $row['id']; ?>" onclick="return confirm('Yakin hapus?')" class="btn btn-sm btn-danger">Hapus</a>
                                </td>
                            </tr>
                            <div class="modal fade" id="modalEditSupplier<?php echo $row['id']; ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning text-dark"><h5 class="modal-title">Edit Supplier: <?php echo htmlspecialchars($row['nama'] ?? ''); ?></h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                        <form method="POST" action="dashboard.php?page=supplier">
                                            <div class="modal-body">
                                                <input type="hidden" name="id_row" value="<?php echo $row['id']; ?>">
                                                <div class="mb-3"><label class="form-label">Nama Supplier</label><input type="text" class="form-control" name="nama_supplier" value="<?php echo htmlspecialchars($row['nama'] ?? ''); ?>" required></div>
                                                <div class="mb-3"><label class="form-label">Alamat</label><textarea class="form-control" name="alamat" required><?php echo htmlspecialchars($row['alamat'] ?? ''); ?></textarea></div>
                                                <div class="mb-3"><label class="form-label">Telepon</label><input type="text" class="form-control" name="telepon" value="<?php echo htmlspecialchars($row['telp'] ?? ''); ?>"></div>
                                            </div>
                                            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button><button type="submit" name="edit_supplier" class="btn btn-warning">Simpan Perubahan</button></div>
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
<div class="modal fade" id="modalTambahSupplier" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white"><h5 class="modal-title">Tambah Data Supplier</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form method="POST" action="dashboard.php?page=supplier">
                <div class="modal-body">
                    <div class="mb-3"><label for="nama_supplier" class="form-label">Nama Supplier</label><input type="text" class="form-control" id="nama_supplier" name="nama_supplier" required></div>
                    <div class="mb-3"><label for="alamat" class="form-label">Alamat</label><textarea class="form-control" id="alamat" name="alamat" required></textarea></div>
                    <div class="mb-3"><label for="telepon" class="form-label">Telepon</label><input type="text" class="form-control" id="telepon" name="telepon"></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button><button type="submit" name="tambah_supplier" class="btn btn-primary">Simpan Data</button></div>
            </form>
        </div>
    </div>
</div>