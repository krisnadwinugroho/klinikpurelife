<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data Pasien</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-3">Update Data Pasien</h2>

        <?php

        include "db.php";


        function sanitize($data)
        {
            global $kon;
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return mysqli_real_escape_string($kon, $data);
        }


        if (isset($_GET['id'])) {
            $id = sanitize($_GET['id']);


            $sql = "SELECT * FROM pasien WHERE id = $id";
            $result = mysqli_query($kon, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
        ?>
                <form action="process_update_pasien.php" method="POST">

                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                    <div class="form-group">
                        <label for="nama_pasien">Nama Pasien:</label>
                        <input type="text" name="nama_pasien" value="<?php echo htmlspecialchars($row['nama_pasien']); ?>" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin:</label>
                        <select name="jenis_kelamin" class="form-control" required>
                            <option value="Laki-laki" <?php if ($row['jenis_kelamin'] == 'Laki-laki') echo 'selected'; ?>>
                                Laki-laki</option>
                            <option value="Perempuan" <?php if ($row['jenis_kelamin'] == 'Perempuan') echo 'selected'; ?>>
                                Perempuan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat:</label>
                        <textarea class="form-control" id="alamat" name="alamat" required><?php echo htmlspecialchars($row['alamat']); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="no_telp">Nomor Telepon:</label>
                        <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?php echo htmlspecialchars($row['no_telp']); ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="pasien.php" class="btn btn-secondary">Batal</a>
                </form>
        <?php
            } else {
                echo '<div class="alert alert-danger">Data pasien tidak ditemukan.</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Parameter ID tidak ditemukan.</div>';
        }


        mysqli_close($kon);
        ?>
    </div>
</body>

</html>