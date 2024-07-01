<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Rekam Medis</title>
    <link rel="icon" href="title_icon.png" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #3366ff;
            color: white;
            padding: 15px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .sidebar h2 {
            text-align: center;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            margin: 5px 0;
            border-radius: 3px;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #007B5F;
        }

        .content {
            flex: 1;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .content h2 {
            margin-top: 0;
        }
    </style>
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="content">

        <div class="container">
            <br>
            <h2>REKAM MEDIS</h2>
            <h4>
                Data Rekam Medis
            </h4>


            <form class="form-inline mb-3" method="GET" action="">
                <input class="form-control mr-sm-2" type="search" name="search" placeholder="Cari Nama Pasien" aria-label="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                <a href="rekam_medis.php" class="btn btn-outline-secondary my-2 my-sm-0 ml-2"><img src="images/refresh.png" alt="Refresh"></a>
                <a href="create.php" class="btn btn-primary ml-auto">Tambah Data</a>
            </form>

            <?php
            include "db.php";


            if (isset($_GET['id'])) {
                $id = htmlspecialchars($_GET["id"]);

                $sql = "DELETE FROM rekam_medis WHERE id='$id'";
                $hasil = mysqli_query($kon, $sql);


                if ($hasil) {
                    header("Location: rekam_medis.php");
                } else {
                    echo "<div class='alert alert-danger'> Data Gagal dihapus.</div>";
                }
            }

            function input($data)
            {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }


            $search = isset($_GET['search']) ? input($_GET['search']) : '';
            $sort = isset($_GET['sort']) ? input($_GET['sort']) : 'DESC';
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $limit = 5;
            $offset = ($page - 1) * $limit;

            $sql = "SELECT * FROM rekam_medis";
            if ($search) {
                $sql .= " WHERE nama_pasien LIKE '%$search%'";
            }
            $sql .= " ORDER BY tanggal_periksa $sort LIMIT $limit OFFSET $offset";

            $hasil = mysqli_query($kon, $sql);


            $sql_count = "SELECT COUNT(*) as total FROM rekam_medis";
            if ($search) {
                $sql_count .= " WHERE nama_pasien LIKE '%$search%'";
            }
            $result_count = mysqli_query($kon, $sql_count);
            $total_record = mysqli_fetch_array($result_count)['total'];
            $total_page = ceil($total_record / $limit);
            $no = $offset;
            ?>

            <table class="my-3 table table-bordered">
                <thead>
                    <tr class="table-primary">
                        <th>No</th>
                        <th><a href="?sort=<?php echo $sort == 'ASC' ? 'DESC' : 'ASC'; ?>">Tanggal Periksa</a></th>
                        <th>Nama Pasien</th>
                        <th>Keluhan</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($data = mysqli_fetch_array($hasil)) {
                        $no++;
                    ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo htmlspecialchars($data["tanggal_periksa"]); ?></td>
                            <td><?php echo htmlspecialchars($data["nama_pasien"]); ?></td>
                            <td><?php echo htmlspecialchars($data["keluhan"]); ?></td>
                            <td>
                                <a href="update_rekam_medis.php?id=<?php echo htmlspecialchars($data['id']); ?>" class="btn btn-warning" role="button">Update</a>
                                <a href="delete_rekam_medis.php?id=<?php echo htmlspecialchars($data['id']); ?>" class="btn btn-danger" role="button"><img src="images/delete.png" alt="Delete"></a>
                            </td>

                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>


            <nav>
                <ul class="pagination">
                    <?php if ($page > 1) : ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>&sort=<?php echo $sort; ?>&search=<?php echo $search; ?>">Previous</a>
                        </li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $total_page; $i++) : ?>
                        <li class="page-item <?php if ($i == $page) echo 'active'; ?>"><a class="page-link" href="?page=<?php echo $i; ?>&sort=<?php echo $sort; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <?php if ($page < $total_page) : ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>&sort=<?php echo $sort; ?>&search=<?php echo $search; ?>">Next</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</body>

</html>