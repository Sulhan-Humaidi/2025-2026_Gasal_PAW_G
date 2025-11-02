<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "store";

$koneksi = mysqli_connect($servername,$username,$password,$database);

if (!$koneksi) {
    die("koneksi gagal: ". mysqli_connect_error());
}
$nama = "";
$telp = "";
$alamat = "";
$errors = []; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama = htmlspecialchars($_POST['nama']);
    $telp = htmlspecialchars($_POST['telp']);
    $alamat = htmlspecialchars($_POST['alamat']);

    if (empty($nama)) {
        $errors[] = "Nama tidak boleh kosong";
    } elseif (!preg_match("/^[a-zA-Z\s]*$/", $nama)) {
        $errors[] = "Nama hanya boleh berisi huruf dan spasi";
    }

    if (empty($telp)) {
        $errors[] = "Telepon tidak boleh kosong";
    } elseif (!preg_match("/^[0-9]*$/", $telp)) {
        $errors[] = "Telepon hanya boleh berisi angka (0-9)";
    }

    if (empty($alamat)) {
        $errors[] = "Alamat tidak boleh kosong";
    } elseif (!preg_match('/[A-Za-z]/', $alamat) || !preg_match('/[0-9]/', $alamat)) {
        $errors[] = "Alamat harus alfanumerik (mengandung huruf dan angka)";
    }

    if (empty($errors)) {
        
        $sql = "INSERT INTO supplier (nama, telp, alamat) VALUES (?, ?, ?)";
        
        if ($stmt = mysqli_prepare($koneksi, $sql)) {
            mysqli_stmt_bind_param($stmt, "sss", $nama, $telp, $alamat);
            
            if (mysqli_stmt_execute($stmt)) {
                header("Location: index.php");
                exit();
            } else {
                $errors[] = "Gagal menyimpan ke database: " . mysqli_error($koneksi);
            }
            mysqli_stmt_close($stmt);
        } else {
             $errors[] = "Kueri SQL gagal disiapkan: " . mysqli_error($koneksi);
        }
        
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Supplier</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2 { color: #333; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input[type="text"] { width: 300px; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .btn { color: white; padding: 10px 20px; text-decoration: none; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; margin-right: 10px; }
        .btn-simpan { background-color: #5cb85c; }
        .btn-batal { background-color: #d9534f; }
        .error-box {
            background-color: #f2dede;
            color: #a94442;
            border: 1px solid #ebccd1;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <h2>Tambah Data Master Supplier Baru</h2>

    <?php
    if (!empty($errors)) {
        echo '<div class="error-box">';
        echo '<strong>Validasi Gagal:</strong>';
        echo '<ul>';
        foreach ($errors as $error) {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul>';
        echo '</div>';
    }
    ?>

    <form action="tambah.php" method="POST">
        
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" placeholder="Nama" value="<?php echo $nama; ?>">
        </div>
        
        <div class="form-group">
            <label for="telp">Telp</label>
            <input type="text" id="telp" name="telp" placeholder="telp" value="<?php echo $telp; ?>">
        </div>
        
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" id="alamat" name="alamat" placeholder="alamat" value="<?php echo $alamat; ?>">
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-simpan">Simpan</button>
            <a href="index.php" class="btn btn-batal">Batal</a>
        </div>
    </form>

</body>
</html>