<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Data Obat</title>
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
            <h2>OBAT</h2>
            <h4>
                Data Obat
            </h4>


            <form class="form-inline mb-3" method="GET" action="">
                <input class="form-control mr-sm-2" type="search" name="search" placeholder="Cari Nama Obat" aria-label="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">

                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                <a href="obat.php" class="btn btn-outline-secondary my-2 my-sm-0 ml-2"><img src="images/refresh.png" alt="Refresh"></a>
                <a href="create.php" class="btn btn-primary ml-auto">Tambah Data</a>
            </form>

            <?php
            include "db.php";

            if (isset($_GET['id'])) {
                $id = htmlspecialchars($_GET["id"]);

                $sql = "DELETE FROM nama_obat WHERE id='$id'";
                $hasil = mysqli_query($kon, $sql);


                if ($hasil) {
                    header("Location: obat.php");
                } else {
                    echo "<div class='alert alert-danger'> Data Gagal dihapus.</div>";
                }
            }

            $limit = 5;
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($page - 1) * $limit;

            $search = isset($_GET['search']) ? input($_GET['search']) : '';
            $sql = "SELECT * FROM nama_obat";
            if ($search) {
                $sql .= " WHERE nama LIKE '%$search%'";
            }
            $sql .= " ORDER BY id DESC LIMIT $limit OFFSET $offset";

            $hasil = mysqli_query($kon, $sql);
            $no = $offset;

            $sql_total = "SELECT COUNT(*) AS total FROM nama_obat";
            if ($search) {
                $sql_total .= " WHERE nama LIKE '%$search%'";
            }
            $result_total = mysqli_query($kon, $sql_total);
            $row_total = mysqli_fetch_assoc($result_total);
            $total_pages = ceil($row_total['total'] / $limit);
            ?>

            <table class="my-3 table table-bordered">
                <thead>
                    <tr class="table-primary">
                        <th>No</th>
                        <th>Nama Obat</th>
                        <th>Keterangan</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($data = mysqli_fetch_array($hasil)) {
                        $no++;
                    ?>
                        <tr>
                            <td><?php echo $no + $offset; ?></td>
                            <td><?php echo htmlspecialchars($data["nama"]); ?></td>
                            <td><?php echo htmlspecialchars($data["deskripsi"]); ?></td>
                            <td>
                                <a href="update.php?id=<?php echo htmlspecialchars($data['id']); ?>" class="btn btn-warning" role="button">Update</a>
                                <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id=<?php echo $data['id']; ?>" class="btn btn-danger" role="button"><img src="images/delete.png" alt="Delete"></a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>


            <nav>
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1) : ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo $search; ?>">Previous</a></li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                        <li class="page-item <?php if ($i == $page) echo 'active'; ?>"><a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a></li>
                    <?php endfor; ?>
                    <?php if ($page < $total_pages) : ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo $search; ?>">Next</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</body>

</html>

<?php
function input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>