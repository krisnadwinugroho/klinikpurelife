<!DOCTYPE html>
<html>

<head>
    <title>Daftar Obat</title>
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

            $nama = input($_POST["nama"]);
            $deskripsi = input($_POST["deskripsi"]);


            $sql = "INSERT INTO nama_obat (nama, deskripsi) VALUES ('$nama', '$deskripsi')";


            $hasil = mysqli_query($kon, $sql);


            if ($hasil) {
                header("Location:welcome.php");
            } else {
                echo "<div class='alert alert-danger'> Data Gagal disimpan.</div>";
            }
        }
        ?>
        <h2>Input Data Obat</h2>

        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <div class="form-group">
                <label>Nama Obat:</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukan Nama Obat" required />
            </div>
            <div class="form-group">
                <label>Keterangan:</label>
                <textarea name="deskripsi" class="form-control" rows="5" placeholder="Masukan Keterangan" required></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

</html>