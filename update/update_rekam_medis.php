<?php
include "db.php";


if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);

    $sql = "SELECT * FROM rekam_medis WHERE id='$id'";
    $result = mysqli_query($kon, $sql);
    $data = mysqli_fetch_array($result);

    if (!$data) {
        echo "<div class='alert alert-danger'>Data tidak ditemukan.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>ID tidak ditemukan.</div>";
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tanggal_periksa = input($_POST["tanggal_periksa"]);
    $nama_pasien = input($_POST["nama_pasien"]);
    $keluhan = input($_POST["keluhan"]);

    $sql = "UPDATE rekam_medis SET
                tanggal_periksa='$tanggal_periksa',
                nama_pasien='$nama_pasien',
                keluhan='$keluhan'
            WHERE id='$id'";

    $hasil = mysqli_query($kon, $sql);

    if ($hasil) {
        header("Location: rekam_medis.php");
    } else {
        echo "<div class='alert alert-danger'>Data gagal diupdate.</div>";
    }
}

function input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Update Rekam Medis</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <h2>Update Data Rekam Medis</h2>

        <?php if ($data) : ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id; ?>" method="post">
                <div class="form-group">
                    <label for="tanggal_periksa">Tanggal Periksa:</label>
                    <input type="date" class="form-control" id="tanggal_periksa" name="tanggal_periksa" value="<?php echo htmlspecialchars($data['tanggal_periksa']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="nama_pasien">Nama Pasien:</label>
                    <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" value="<?php echo htmlspecialchars($data['nama_pasien']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="keluhan">Keluhan:</label>
                    <textarea class="form-control" id="keluhan" name="keluhan" required><?php echo htmlspecialchars($data['keluhan']); ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="rekam_medis.php" class="btn btn-secondary">Batal</a>
            </form>
        <?php endif; ?>
    </div>
</body>

</html>