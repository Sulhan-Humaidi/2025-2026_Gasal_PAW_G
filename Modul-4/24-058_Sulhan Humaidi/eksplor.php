<?php


// 1. Regular Expression (preg_match)
echo "<h3>1. preg_match (Cek format Nama)</h3>";
$pattern = "/^[a-zA-Z'-]+\$/";
$nama_benar = "Qomar";
$nama_salah = "Qomar123";

if (preg_match($pattern, $nama_benar)) {
    echo "'$nama_benar' -> Format Benar.\n";
}
if (!preg_match($pattern, $nama_salah)) {
    echo "'$nama_salah' -> Format Salah.\n";
}
echo "<hr>";


// 2. Fungsi String (trim & strtolower)
echo "<h3>2. Fungsi String (trim & strtolower)</h3>";
$input_kotor = "    Qomar@Email.COM    ";
$bersih_spasi = trim($input_kotor);
$bersih_total = strtolower($bersih_spasi);

echo "Input Asli: '$input_kotor'\n";
echo "Setelah trim: '$bersih_spasi'\n";
echo "Setelah strtolower: '$bersih_total'\n";
echo "<hr>";


// 3. Fungsi Filter (filter_var)
echo "<h3>3. filter_var (Cek Email)</h3>";
$email_benar = "ardy@gmail.com";
$email_salah = "ardy.com";

if (filter_var($email_benar, FILTER_VALIDATE_EMAIL)) {
    echo "'$email_benar' -> Format Email BENAR.\n";
}
if (!filter_var($email_salah, FILTER_VALIDATE_EMAIL)) {
    echo "'$email_salah' -> Format Email SALAH.\n";
}
echo "<hr>";


// 4. Fungsi Type Testing (is_numeric)
echo "<h3>4. is_numeric (Cek Angka)</h3>";
$angka = "12345";
$bukan_angka = "12345ABC";

if (is_numeric($angka)) {
    echo "'$angka' -> adalah Angka.\n";
}
if (!is_numeric($bukan_angka)) {
    echo "'$bukan_angka' -> BUKAN Angka.\n";
}
echo "<hr>";


// 5. Fungsi Date (checkdate)
echo "<h3>5. checkdate (Cek Tanggal Valid)</h3>";
$tgl_valid = checkdate(12, 25, 2024); // 25 Desember 2024
$tgl_invalid = checkdate(2, 30, 2024); // 30 Februari 2024

if ($tgl_valid) {
    echo "25-12-2024 -> Tanggal VALID.\n";
}
if (!$tgl_invalid) {
    echo "30-02-2024 -> Tanggal INVALID.\n";
}
echo "<hr>";

?>