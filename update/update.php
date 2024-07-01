<!DOCTYPE html>
<html>

<head>
    <title>Form Pendaftaran Obat</title>
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


        if (isset($_GET['id'])) {
            $id = input($_GET["id"]);

            $sql = "SELECT * FROM nama_obat WHERE id=$id";
            $hasil = mysqli_query($kon, $sql);
            $data = mysqli_fetch_assoc($hasil);
        }


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = htmlspecialchars($_POST["id"]);
            $nama = input($_POST["nama"]);
            $deskripsi = input($_POST["deskripsi"]);

            $sql = "UPDATE nama_obat SET
            nama='$nama',
            deskripsi='$deskripsi'
            WHERE id=$id";


            $hasil = mysqli_query($kon, $sql);


            if ($hasil) {
                header("Location:welcome.php");
            } else {
                echo "<div class='alert alert-danger'> Data Gagal disimpan.</div>";
            }
        }
        ?>
        <h2>Update Data Obat</h2>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Nama Obat:</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukan Nama Obat" value="<?php echo $data['nama']; ?>" required />
            </div>
            <div class="form-group">
                <label>Deskripsi:</label>
                <textarea name="deskripsi" class="form-control" rows="5" placeholder="Masukan Deskripsi" required><?php echo $data['deskripsi']; ?></textarea>
            </div>
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

</html>