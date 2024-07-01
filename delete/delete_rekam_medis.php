<?php
include "db.php";


if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);


    $sql = "DELETE FROM rekam_medis WHERE id='$id'";
    $hasil = mysqli_query($kon, $sql);

    if ($hasil) {
        header("Location: rekam_medis.php");
    } else {
        echo "<div class='alert alert-danger'>Data gagal dihapus.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>ID tidak ditemukan.</div>";
    exit;
}
