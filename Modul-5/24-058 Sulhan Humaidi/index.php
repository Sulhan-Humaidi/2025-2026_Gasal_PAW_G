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
$query = "SELECT * FROM supplier";
$hasil = mysqli_query($koneksi,$query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Data Master supplier</h2>
    <a href = "tambah.php">Tambah Data </a>
    <br>
    <table border = "1">
        <tr bgcolor = "Green">
            <th>NO</th>
            <th>Nama</th>
            <th>Telp</th>
            <th>Alamat</th>
            <th>Tindakan</th>
        </tr>
        <?php 
        $no = 1;
        while ($data = mysqli_fetch_assoc($hasil)){
            ?>
            <tr>
                <td><?php echo $no++;?></td>
                <td><?php echo $data['nama']?></td>
                <td><?php echo $data['telp']?></td>
                <td><?php echo $data['alamat']?></td>>
                <td>
                   
                <a href="edit.php?id=<?php echo $data['id']; ?>" 
                 class="btn btn-edit">Edit</a>
    
                <a href="#" 
                onclick="konfirmasiHapus(<?php echo $data['id']; ?>)" 
                class="btn btn-hapus">Hapus</a>
                </td>
            </tr>
        <?php 
        }
        ?>

    </table>
   <script>
    function konfirmasiHapus(idSupplier) {
        var setuju = confirm("Anda yakin akan menghapus supplier ini?");
        if (setuju == true) {
            window.location.href = "hapus.php?id=" + idSupplier;
        } 
    }
    </script>
    
</body>
</html>