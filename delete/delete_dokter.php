<?php

include "db.php";


if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET["id"]);


    $sql = "DELETE FROM dokter WHERE id='$id'";
    $hasil = mysqli_query($kon, $sql);


    $response = array();


    if ($hasil) {
        $response['status'] = 'success';
        $response['message'] = 'Data dokter berhasil dihapus.';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Terjadi kesalahan saat menghapus data dokter.';
    }


    echo json_encode($response);
} else {

    $response['status'] = 'error';
    $response['message'] = 'ID dokter tidak ditemukan.';
    echo json_encode($response);
}
