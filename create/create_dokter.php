<!DOCTYPE html>
<html>

<head>
    <title>Input Data Dokter</title>
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


            $nama_dokter = input($_POST["nama_dokter"]);
            $spesialis = input($_POST["spesialis"]);
            $alamat = input($_POST["alamat"]);
            $no_telp = input($_POST["no_telp"]);


            $sql = "INSERT INTO dokter (nama_dokter, spesialis, alamat, no_telp) 
                    VALUES ('$nama_dokter', '$spesialis', '$alamat', '$no_telp')";


            $hasil = mysqli_query($kon, $sql);


            if ($hasil) {
                header("Location: welcome.php");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Data Gagal disimpan: " . mysqli_error($kon) . "</div>";
            }
        }
        ?>
        <h2>Input Data Dokter</h2>

        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <div class="form-group">
                <label>Nama Dokter:</label>
                <input type="text" name="nama_dokter" class="form-control" placeholder="Masukkan Nama Dokter" required />
            </div>
            <div class="form-group">
                <label>Spesialis:</label>
                <input type="text" name="spesialis" class="form-control" placeholder="Masukkan Spesialis" required />
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