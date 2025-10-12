<?php
//3.6.1
$fruits = ["Apple", "Blueberry"];
echo "Array Awal:\n";
print_r($fruits);
array_push($fruits, "Cherry", "Dragonfruit");
echo "\nArray Setelah array_push():\n";
print_r($fruits);
echo "<hr>";

//3.6.2
$hewan_darat = ["Sapi", "Kambing"];
$hewan_laut = ["Ikan", "Cumi-cumi"];
$semua_hewan = array_merge($hewan_darat, $hewan_laut);
echo "Hasil Gabungan Array:\n";
print_r($semua_hewan);
echo "<hr>";

//3.6.3
$user = ["nama" => "Budi", "umur" => 25, "kota" => "Jakarta"];
echo "Array Asosiatif Awal:\n";
print_r($user);
$user_values = array_values($user);
echo "\nArray Setelah array_values():\n";
print_r($user_values);
echo "<hr>";

//3.6.4
$scores = ["Alex" => 80, "Bianca" => 95, "Candice" => 75];
$nilai_dicari = 95;
$key_ditemukan = array_search($nilai_dicari, $scores);
echo "Mencari nilai " . $nilai_dicari . "...\n";
echo "Nilai ditemukan pada key: " . $key_ditemukan . "\n";
echo "<hr>";

//3.6.5
$numbers_filter = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
echo "Array Angka Awal:\n";
print_r($numbers_filter);
$angka_genap = array_filter($numbers_filter, function($angka) {
    return $angka % 2 == 0;
});
echo "\nArray Setelah difilter (hanya angka genap):\n";
print_r($angka_genap);
echo "<hr>";

//3.6.6
// sort()
$cars = ["Volvo", "BMW", "Toyota"];
echo "<b>Array Awal (untuk sort):</b>\n";
print_r($cars);
sort($cars);
echo "<b>Hasil sort():</b>\n";
print_r($cars);
echo "\n";

// rsort()
$numbers_sort = [4, 6, 2, 22, 11];
echo "<b>Array Awal (untuk rsort):</b>\n";
print_r($numbers_sort);
rsort($numbers_sort);
echo "<b>Hasil rsort():</b>\n";
print_r($numbers_sort);
echo "\n";

// asort()
$ages_asort = ["Peter"=>"35", "Ben"=>"37", "Joe"=>"43"];
echo "<b>Array Awal (untuk asort):</b>\n";
print_r($ages_asort);
asort($ages_asort);
echo "<b>Hasil asort() (urut berdasarkan nilai):</b>\n";
print_r($ages_asort);
echo "\n";

// ksort()
$ages_ksort = ["Peter"=>"35", "Ben"=>"37", "Joe"=>"43"];
echo "<b>Array Awal (untuk ksort):</b>\n";
print_r($ages_ksort);
ksort($ages_ksort);
echo "<b>Hasil ksort() (urut berdasarkan kunci):</b>\n";
print_r($ages_ksort);

?>