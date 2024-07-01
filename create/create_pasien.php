<!DOCTYPE html>
<html>

<head>
    <title>Input Data Pasien</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <?php

        include "db.php";


        function input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }


        if ($_SERVER["REQUEST_METHOD"] == "POST") {


            $id = input($_POST["id"]);
            $nama_pasien = input($_POST["nama_pasien"]);
            $jenis_kelamin = input($_POST["jenis_kelamin"]);
            $alamat = input($_POST["alamat"]);
            $no_telp = input($_POST["no_telp"]);


            $sql = "INSERT INTO pasien (id, nama_pasien, jenis_kelamin, alamat, no_telp) 
                    VALUES ('$id', '$nama_pasien', '$jenis_kelamin', '$alamat', '$no_telp')";


            $hasil = mysqli_query($kon, $sql);


            if ($hasil) {
                header("Location: pasien.php");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Data Gagal disimpan.</div>";
            }
        }
        ?>
        <h2>Input Data Pasien</h2>

        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">

            <div class="form-group">
                <label>Nama Pasien:</label>
                <input type="text" name="nama_pasien" class="form-control" placeholder="Masukkan Nama Pasien" required />
            </div>
            <div class="form-group">
                <label>Jenis Kelamin:</label>
                <select name="jenis_kelamin" class="form-control" required>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label>Alamat:</label>
                <textarea name="alamat" class="form-control" rows="5" placeholder="Masukkan Alamat" required></textarea>
            </div>
            <div class="form-group">
                <label>No Telp:</label>
                <input type="text" name="no_telp" class="form-control" placeholder="Masukkan No Telp" required />
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

</html>