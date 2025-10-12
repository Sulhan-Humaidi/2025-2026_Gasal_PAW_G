<?php
//3.2.1
$fruits = array("Avocado", "Blueberry", "Cherry");
$dataBaru = ["Dragonfruit", "Elderberry", "Fig", "Grape", "Honeydew"];

for ($i = 0; $i < count($dataBaru); $i++) {
    $fruits[] = $dataBaru[$i];
}

$arrlength = count($fruits);
echo "Panjang array \$fruits saat ini: " . $arrlength . "<br><br>";
echo "Isi array \$fruits:<br>";
for ($x = 0; $x < $arrlength; $x++) {
    echo $fruits[$x] . "<br>";
}

echo "<hr>";

//3.2.2
echo "--- Soal 3.2.2 ---<br>";
$veggies = array("Asparagus", "Broccoli", "Carrot");
$veggiesLength = count($veggies);

echo "Isi array \$veggies:<br>";
for ($x = 0; $x < $veggiesLength; $x++) {
    echo $veggies[$x] . "<br>";
}
?>
