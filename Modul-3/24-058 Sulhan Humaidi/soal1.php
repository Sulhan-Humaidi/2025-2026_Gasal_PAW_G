<?php
//3.1.1
$fruits = array("Avocado", "Blueberry", "Cherry");

array_push($fruits, "Dragonfruit", "Elderberry", "Fig", "Grape", "Honeydew");

echo "Nilai dengan indeks tertinggi setelah ditambah adalah: " . $fruits[7];
echo "<br>";

//3.1.2
array_splice($fruits, 3, 1);

echo "Nilai dengan indeks tertinggi setelah dihapus adalah: " . $fruits[6];
echo "<br>";
//3.1.3
$veggies = array("Asparagus", "Broccoli", "Carrot");

echo "Isi dari array \$veggies adalah: <br>";
foreach ($veggies as $veg) {
    echo "- " . $veg . "<br>";
}
?>