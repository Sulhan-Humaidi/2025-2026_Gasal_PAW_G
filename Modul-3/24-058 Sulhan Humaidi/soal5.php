<!DOCTYPE html>
<html>
<head>
    <title>Data Mahasiswa</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            font-family: sans-serif;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Tabel Data Mahasiswa</h2>

<?php
$students = array(
    array("Alex", "220401", "0812345678"),
    array("Bianca", "220402", "0812345687"),
    array("Candice", "220403", "0812345665"),
    array("David", "220404", "0812345611"),
    array("Ethan", "220405", "0812345622"),
    array("Fiona", "220406", "0812345633"),
    array("George", "220407", "0812345644"),
    array("Hannah", "220408", "0812345655")
);

echo "<table>";
echo "<tr>";
echo "<th>Name</th>";
echo "<th>NIM</th>";
echo "<th>Mobile</th>";
echo "</tr>";

for ($row = 0; $row < count($students); $row++) {
    echo "<tr>";
    for ($col = 0; $col < count($students[$row]); $col++) {
        echo "<td>" . $students[$row][$col] . "</td>";
    }
    echo "</tr>";
}

echo "</table>";
?>

</body>
</html>