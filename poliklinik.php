<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Data Poliklinik</title>
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

        .table-container {
            position: relative;
        }

        .table-buttons {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="content">

        <div class="container">
            <br>
            <h2>POLIKLINIK</h2>
            <h4>
                Data Poliklinik
            </h4>


            <form class="form-inline mb-3" method="GET" action="">
                <input class="form-control mr-sm-2" type="search" name="search" placeholder="Cari Nama Poli" aria-label="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                <a href="poliklinik.php" class="btn btn-outline-secondary my-2 my-sm-0 ml-2"><img src="images/refresh.png" alt="Refresh"></a>
                <a href="create.php" class="btn btn-primary ml-auto">Tambah Data</a>
            </form>

            <form method="POST" action="delete_update.php">
                <?php
                include "db.php";


                $results_per_page = 5;
                $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                $start_from = ($page - 1) * $results_per_page;


                $search = isset($_GET['search']) ? input($_GET['search']) : '';
                $sql = "SELECT * FROM poliklinik";
                if ($search) {
                    $sql .= " WHERE nama_poli LIKE '%$search%'";
                }
                $sql .= " ORDER BY id DESC LIMIT $start_from, $results_per_page";

                $hasil = mysqli_query($kon, $sql);
                $no = $start_from;


                $sql_total = "SELECT COUNT(*) AS total FROM poliklinik";
                if ($search) {
                    $sql_total .= " WHERE nama_poli LIKE '%$search%'";
                }
                $result_total = mysqli_query($kon, $sql_total);
                $total_records = mysqli_fetch_assoc($result_total)['total'];
                $total_pages = ceil($total_records / $results_per_page);
                ?>

                <div class="table-container">
                    <table class="my-3 table table-bordered">
                        <thead>
                            <tr class="table-primary">
                                <th>No</th>
                                <th>Nama Poli</th>
                                <th>Gedung</th>
                                <th><input type="checkbox" id="select-all"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($data = mysqli_fetch_array($hasil)) {
                                $no++;
                            ?>
                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo htmlspecialchars($data["nama_poli"]); ?></td>
                                    <td><?php echo htmlspecialchars($data["gedung"]); ?></td>
                                    <td><input type="checkbox" name="check[]" value="<?php echo $data['id']; ?>"></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="table-buttons">
                        <button type="submit" name="update" class="btn btn-warning">Update</button>
                        <button type="submit" name="delete" class="btn btn-danger ml-2">Delete</button>
                    </div>
                </div>


                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php
                        if ($page > 1) {
                            echo '<li class="page-item"><a class="page-link" href="poliklinik.php?page=' . ($page - 1) . '&search=' . $search . '">Previous</a></li>';
                        }
                        for ($i = 1; $i <= $total_pages; $i++) {
                            if ($i == $page) {
                                echo '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="poliklinik.php?page=' . $i . '&search=' . $search . '">' . $i . '</a></li>';
                            }
                        }
                        if ($page < $total_pages) {
                            echo '<li class="page-item"><a class="page-link" href="poliklinik.php?page=' . ($page + 1) . '&search=' . $search . '">Next</a></li>';
                        }
                        ?>
                    </ul>
                </nav>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('select-all').onclick = function() {
            var checkboxes = document.getElementsByName('check[]');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        }
    </script>
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