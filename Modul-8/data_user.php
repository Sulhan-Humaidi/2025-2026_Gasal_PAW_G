<?php
// FILE: data_user.php - Menangani CRUD Data User
$pesan = "";

// LOGIKA CREATE
if (isset($_POST['tambah_user'])) {
    $username = trim($_POST['username']);
    $password = md5(trim($_POST['password'])); 
    $nama = trim($_POST['nama']);
    $alamat = trim($_POST['alamat']);
    $hp = trim($_POST['hp']);
    $level = $_POST['level'];

    $cek_user = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'");
    if (mysqli_num_rows($cek_user) > 0) {
        $pesan = "<div class='alert alert-warning'>Username **$username** sudah digunakan.</div>";
    } else {
        $query_tambah = "INSERT INTO user (username, password, nama, alamat, hp, level) VALUES ('$username', '$password', '$nama', '$alamat', '$hp', '$level')";
        if (mysqli_query($koneksi, $query_tambah)) {
            $pesan = "<div class='alert alert-success'>Data user **$nama** berhasil ditambahkan!</div>";
        } else {
            $pesan = "<div class='alert alert-danger'>Gagal menambahkan data: " . mysqli_error($koneksi) . "</div>";
        }
    }
}

// LOGIKA UPDATE
if (isset($_POST['edit_user'])) {
    $id_user = $_POST['id_user'];
    $nama = trim($_POST['nama']);
    $alamat = trim($_POST['alamat']);
    $hp = trim($_POST['hp']);
    $level = $_POST['level'];
    $set_password = "";
    if (!empty($_POST['password'])) {
        $password = md5(trim($_POST['password']));
        $set_password = ", password='$password'";
    }
    $query_edit = "UPDATE user SET nama='$nama', alamat='$alamat', hp='$hp', level='$level' $set_password WHERE id_user='$id_user'";
    if (mysqli_query($koneksi, $query_edit)) {
        $pesan = "<div class='alert alert-success'>Data user **$nama** berhasil diupdate!</div>";
    } else {
        $pesan = "<div class='alert alert-danger'>Gagal mengupdate data: " . mysqli_error($koneksi) . "</div>";
    }
}

// LOGIKA DELETE
if (isset($_GET['hapus'])) {
    $id_user = $_GET['hapus'];
    $query_hapus = "DELETE FROM user WHERE id_user='$id_user'";
    if (mysqli_query($koneksi, $query_hapus)) {
        $pesan = "<div class='alert alert-success'>Data user berhasil dihapus!</div>";
    } else {
        $pesan = "<div class='alert alert-danger'>Gagal menghapus data: " . mysqli_error($koneksi) . "</div>";
    }
    header("location: dashboard.php?page=user");
    exit();
}

// LOGIKA READ
$query_tampil = "SELECT * FROM user ORDER BY id_user DESC";
$data_user = mysqli_query($koneksi, $query_tampil);
?>
<div class="row">
    <div class="col-12">
        <h3 class="mb-4">👤 Data Master User</h3>
        <?php echo $pesan; ?>
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahUser">+ Tambah User Baru</button>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>HP</th>
                                <th>Level</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($data_user)) : ?>
                            <tr>
                                <td><?php echo $row['id_user']; ?></td>
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                <td><?php echo htmlspecialchars($row['hp']); ?></td>
                                <td><?php echo $row['level'] == '1' ? 'Admin (Owner)' : 'Kasir'; ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditUser<?php echo $row['id_user']; ?>">Edit</button>
                                    <a href="dashboard.php?page=user&hapus=<?php echo $row['id_user']; ?>" onclick="return confirm('Yakin hapus?')" class="btn btn-sm btn-danger">Hapus</a>
                                </td>
                            </tr>
                            <div class="modal fade" id="modalEditUser<?php echo $row['id_user']; ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning text-dark">
                                            <h5 class="modal-title">Edit User: <?php echo $row['username']; ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="dashboard.php?page=user">
                                            <div class="modal-body">
                                                <input type="hidden" name="id_user" value="<?php echo $row['id_user']; ?>">
                                                <div class="mb-3"><label class="form-label">Username</label><input type="text" class="form-control" name="username" value="<?php echo $row['username']; ?>" readonly></div>
                                                <div class="mb-3"><label class="form-label">Nama Lengkap</label><input type="text" class="form-control" name="nama" value="<?php echo $row['nama']; ?>" required></div>
                                                <div class="mb-3"><label class="form-label">Password Baru (Kosongkan jika tidak diubah)</label><input type="password" class="form-control" name="password"></div>
                                                <div class="mb-3"><label class="form-label">Level Akses</label>
                                                    <select class="form-select" name="level" required>
                                                        <option value="1" <?php echo $row['level'] == '1' ? 'selected' : ''; ?>>1 (Admin)</option>
                                                        <option value="2" <?php echo $row['level'] == '2' ? 'selected' : ''; ?>>2 (Kasir)</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button><button type="submit" name="edit_user" class="btn btn-warning">Simpan Perubahan</button></div>
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
<div class="modal fade" id="modalTambahUser" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white"><h5 class="modal-title">Tambah Data User</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form method="POST" action="dashboard.php?page=user">
                <div class="modal-body">
                    <div class="mb-3"><label for="username" class="form-label">Username</label><input type="text" class="form-control" id="username" name="username" required></div>
                    <div class="mb-3"><label for="password" class="form-label">Password</label><input type="password" class="form-control" id="password" name="password" required></div>
                    <div class="mb-3"><label for="nama" class="form-label">Nama Lengkap</label><input type="text" class="form-control" id="nama" name="nama" required></div>
                    <div class="mb-3"><label for="level" class="form-label">Level Akses</label>
                        <select class="form-select" id="level" name="level" required>
                            <option value="1">1 (Admin/Owner)</option>
                            <option value="2">2 (Kasir)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button><button type="submit" name="tambah_user" class="btn btn-primary">Simpan User</button></div>
            </form>
        </div>
    </div>
</div>