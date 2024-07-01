<?php

include "db.php";

function sanitize($data)
{
    global $kon;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return mysqli_real_escape_string($kon, $data);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = sanitize($_POST['id']);
    $nama_pasien = sanitize($_POST['nama_pasien']);
    $jenis_kelamin = sanitize($_POST['jenis_kelamin']);
    $alamat = sanitize($_POST['alamat']);
    $no_telp = sanitize($_POST['no_telp']);

    $sql = "UPDATE pasien SET nama_pasien = '$nama_pasien', jenis_kelamin = '$jenis_kelamin', alamat = '$alamat', no_telp = '$no_telp' WHERE id = $id";

    if (mysqli_query($kon, $sql)) {

        header("Location: pasien.php");
        exit();
    } else {
        echo '<div class="alert alert-danger">Gagal melakukan update data pasien: ' . mysqli_error($kon) . '</div>';
    }
} else {

    header("Location: pasien.php");
    exit();
}


mysqli_close($kon);
