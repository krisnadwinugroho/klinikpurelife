<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['check']) && is_array($_POST['check'])) {
        $ids = implode(',', $_POST['check']);

        if (isset($_POST['delete'])) {
            $sql = "DELETE FROM poliklinik WHERE id IN ($ids)";
            if (mysqli_query($kon, $sql)) {
                echo '<div class="alert alert-success">Data berhasil dihapus.</div>';
            } else {
                echo '<div class="alert alert-danger">Error: ' . mysqli_error($kon) . '</div>';
            }
        } elseif (isset($_POST['update'])) {

            foreach ($_POST['check'] as $id) {

                $sql = "UPDATE poliklinik SET gedung = 'Updated' WHERE id = $id";
                mysqli_query($kon, $sql);
            }
            echo '<div class="alert alert-success">Data berhasil diperbarui.</div>';
        }
    } else {
        echo '<div class="alert alert-warning">Tidak ada data yang dipilih.</div>';
    }
}


header("Location: poliklinik.php");


mysqli_close($kon);
