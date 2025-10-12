<?php
//3.4.1
$height = array("Andy"=>"176", "Barry"=>"165", "Charlie"=>"170", "Qomar" => "180","Ardy" => "172","Yoga" => "168","Agus" => "175","Rafi" => "182");


echo "Isi array \$height saat ini:<br>";
foreach($height as $x => $x_value) {
  echo "Key=" . $x . ", Value=" . $x_value;
  echo "<br>";
}

echo "<hr>"; 


//3.4.2
$weight = array(
    "Andy" => "68",
    "Barry" => "60",
    "Charlie" => "65"
);

echo "Isi array \$weight:<br>";
foreach($weight as $key => $value) {
  echo "Key=" . $key . ", Value=" . $value;
  echo "<br>";
}
?>