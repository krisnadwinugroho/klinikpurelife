<?php

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "user_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $sql = "DELETE FROM nama_obat WHERE id = $id";

    if ($conn->query($sql) === TRUE) {

        echo "Obat berhasil dihapus";
    } else {
        echo "Error: " . $conn->error;
    }


    $conn->close();
} else {
    echo "ID obat tidak ditemukan";
}
