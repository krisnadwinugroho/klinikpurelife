<?php
include "db.php";

$id = mysqli_real_escape_string($kon, $_POST['id']);
$nama_dokter = mysqli_real_escape_string($kon, $_POST['some_field']);
$spesialis = mysqli_real_escape_string($kon, $_POST['spesialis']);
$alamat = mysqli_real_escape_string($kon, $_POST['alamat']);
$no_telp = mysqli_real_escape_string($kon, $_POST['no_telp']);

$sql = "UPDATE dokter SET 
            nama_dokter = '$nama_dokter',
            spesialis = '$spesialis',
            alamat = '$alamat',
            no_telp = '$no_telp'
        WHERE id = '$id'";


if (mysqli_query($kon, $sql)) {
    header("Location: dokter.php");
    exit();
} else {

    echo "Error: " . $sql . "<br>" . mysqli_error($kon);
}

mysqli_close($kon);
