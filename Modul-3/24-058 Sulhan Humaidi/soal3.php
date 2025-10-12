<?php
//3.3.1
$height = array("Andy"=>"176", "Barry"=>"165", "Charlie"=>"170", "Qomar" => "180","Ardy" => "172","Yoga" => "168","Agus" => "175","Rafi" => "182");



$nilaiTerakhir = end($height);
echo "Nilai dengan indeks terakhir adalah: " . $nilaiTerakhir;
echo "<br>";


//3.3.2
unset($height['Rafi']);

$nilaiTerakhirSetelahHapus = end($height);
echo "Setelah data dihapus, nilai dengan indeks terakhir adalah: " . $nilaiTerakhirSetelahHapus;
echo "<br>";


//3.3.3
$weight = array(
    "Syaifi" => "68",
    "Adel" => "60",
    "Arez" => "65"
);

$keys = array_keys($weight);
$keyKedua = $keys[1];

echo "Data ke-2 dari array \$weight adalah". $keyKedua." dengan nilai ". $weight[$keyKedua];
?>