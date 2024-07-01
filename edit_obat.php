<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];


    $sql = "SELECT * FROM nama_obat WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        echo "<form action='proses_edit_obat.php' method='POST'>";
        echo "Nama Obat: <input type='text' name='nama' value='" . $row["nama"] . "'><br>";
        echo "Keterangan: <input type='text' name='deskripsi' value='" . $row["deskripsi"] . "'><br>";
        echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
        echo "<input type='submit' value='Simpan'>";
        echo "</form>";
    } else {
        echo "Obat tidak ditemukan";
    }
} else {
    echo "ID obat tidak ditemukan";
}


$conn->close();
