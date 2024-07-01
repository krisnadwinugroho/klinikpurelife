<?php
include "db.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];


    $sql_delete = "DELETE FROM pasien WHERE id = '$id'";
    $result_delete = mysqli_query($kon, $sql_delete);

    if ($result_delete) {

        mysqli_query($kon, "ALTER TABLE pasien AUTO_INCREMENT = 1");


        $response['status'] = 'success';
        $response['message'] = 'Data pasien berhasil dihapus.';
    } else {

        $response['status'] = 'error';
        $response['message'] = 'Gagal menghapus data pasien.';
    }
} else {

    $response['status'] = 'error';
    $response['message'] = 'ID pasien tidak ditemukan.';
}


echo json_encode($response);
