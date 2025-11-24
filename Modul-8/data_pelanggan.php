<?php
// FILE: data_pelanggan.php (CRUD Pelanggan)
$pesan = "";

// LOGIKA CREATE
if (isset($_POST['tambah_pelanggan'])) {
    // Menggunakan nama kolom yang benar: nama, telp, alamat
    $nama = trim($_POST['nama_pelanggan']); // Variabel dari form
    $alamat = trim($_POST['alamat']);
    $telp = trim($_POST['telepon']); // Variabel dari form
    $jenis_kelamin = $_POST['jenis_kelamin'];

    // Query CREATE menggunakan nama kolom: nama, telp, alamat, jenis_kelamin
    $query_tambah = "INSERT INTO pelanggan (nama, alamat, telp, jenis_kelamin) VALUES ('$nama', '$alamat', '$telp', '$jenis_kelamin')";
    if (mysqli_query($koneksi, $query_tambah)) {
        $pesan = "<div class='alert alert-success'>Data pelanggan **$nama** berhasil ditambahkan!</div>";
    } else {
        $pesan = "<div class='alert alert-danger'>Gagal menambahkan data: " . mysqli_error($koneksi) . "</div>";
    }
}

// LOGIKA UPDATE
if (isset($_POST['edit_pelanggan'])) {
    $id_row = $_POST['id_row']; 
    $nama = trim($_POST['nama_pelanggan']);
    $alamat = trim($_POST['alamat']);
    $telp = trim($_POST['telepon']); 
    $jenis_kelamin = $_POST['jenis_kelamin'];
    
    // Query UPDATE menggunakan nama kolom: nama, telp, alamat, jenis_kelamin
    $query_edit = "UPDATE pelanggan SET nama='$nama', alamat='$alamat', telp='$telp', jenis_kelamin='$jenis_kelamin' WHERE id='$id_row'";
    if (mysqli_query($koneksi, $query_edit)) {
        $pesan = "<div class='alert alert-success'>Data pelanggan **$nama** berhasil diupdate!</div>";
    } else {
        $pesan = "<div class='alert alert-danger'>Gagal mengupdate data: " . mysqli_error($koneksi) . "</div>";
    }
}

// LOGIKA DELETE
if (isset($_GET['hapus_pelanggan'])) {
    $id_hapus = $_GET['hapus_pelanggan'];
    $query_hapus = "DELETE FROM pelanggan WHERE id='$id_hapus'";
    if (mysqli_query($koneksi, $query_hapus)) {
        $pesan = "<div class='alert alert-success'>Data pelanggan berhasil dihapus!</div>";
    } else {
        $pesan = "<div class='alert alert-danger'>Gagal menghapus data: " . mysqli_error($koneksi) . "</div>";
    }
    header("location: dashboard.php?page=pelanggan");
    exit();
}

// LOGIKA READ (ORDER BY id)
$query_tampil = "SELECT * FROM pelanggan ORDER BY id DESC";
$data_pelanggan = mysqli_query($koneksi, $query_tampil);
?>
<div class="row">
    <div class="col-12">
        <h3 class="mb-4">👥 Data Master Pelanggan</h3>
        <?php echo $pesan; ?>
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahPelanggan">+ Tambah Pelanggan Baru</button>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>J/K</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($data_pelanggan)) : ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['nama'] ?? ''); ?></td>
                                <td><?php echo $row['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?></td>
                                <td><?php echo htmlspecialchars($row['telp'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($row['alamat'] ?? ''); ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditPelanggan<?php echo $row['id']; ?>">Edit</button>
                                    <a href="dashboard.php?page=pelanggan&hapus_pelanggan=<?php echo $row['id']; ?>" onclick="return confirm('Yakin hapus?')" class="btn btn-sm btn-danger">Hapus</a>
                                </td>
                            </tr>
                            <div class="modal fade" id="modalEditPelanggan<?php echo $row['id']; ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning text-dark"><h5 class="modal-title">Edit Pelanggan: <?php echo htmlspecialchars($row['nama'] ?? ''); ?></h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                        <form method="POST" action="dashboard.php?page=pelanggan">
                                            <div class="modal-body">
                                                <input type="hidden" name="id_row" value="<?php echo $row['id']; ?>">
                                                <div class="mb-3"><label class="form-label">Nama Pelanggan</label><input type="text" class="form-control" name="nama_pelanggan" value="<?php echo htmlspecialchars($row['nama'] ?? ''); ?>" required></div>
                                                <div class="mb-3"><label class="form-label">Jenis Kelamin</label>
                                                    <select class="form-select" name="jenis_kelamin" required>
                                                        <option value="L" <?php echo ($row['jenis_kelamin'] ?? '') == 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                                                        <option value="P" <?php echo ($row['jenis_kelamin'] ?? '') == 'P' ? 'selected' : ''; ?>>Perempuan</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3"><label class="form-label">Telepon</label><input type="text" class="form-control" name="telepon" value="<?php echo htmlspecialchars($row['telp'] ?? ''); ?>"></div>
                                                <div class="mb-3"><label class="form-label">Alamat</label><textarea class="form-control" name="alamat"><?php echo htmlspecialchars($row['alamat'] ?? ''); ?></textarea></div>
                                            </div>
                                            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button><button type="submit" name="edit_pelanggan" class="btn btn-warning">Simpan Perubahan</button></div>
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
<div class="modal fade" id="modalTambahPelanggan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white"><h5 class="modal-title">Tambah Data Pelanggan</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form method="POST" action="dashboard.php?page=pelanggan">
                <div class="modal-body">
                    <div class="mb-3"><label for="nama_pelanggan" class="form-label">Nama Pelanggan</label><input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" required></div>
                    <div class="mb-3"><label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3"><label for="telepon" class="form-label">Telepon</label><input type="text" class="form-control" id="telepon" name="telepon"></div>
                    <div class="mb-3"><label for="alamat" class="form-label">Alamat</label><textarea class="form-control" id="alamat" name="alamat"></textarea></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button><button type="submit" name="tambah_pelanggan" class="btn btn-primary">Simpan Data</button></div>
            </form>
        </div>
    </div>
</div>