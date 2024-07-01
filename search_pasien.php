<?php
include "db.php";

function input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$search = isset($_GET['search']) ? input($_GET['search']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

$sql_count = "SELECT COUNT(*) as total FROM pasien";
if ($search) {
    $sql_count .= " WHERE nama_pasien LIKE '%$search%'";
}
$result_count = mysqli_query($kon, $sql_count);
$row_count = mysqli_fetch_assoc($result_count);
$total_rows = $row_count['total'];
$total_pages = ceil($total_rows / $limit);


$sql = "SELECT * FROM pasien";
if ($search) {
    $sql .= " WHERE nama_pasien LIKE '%$search%'";
}
$sql .= " ORDER BY id DESC LIMIT $limit OFFSET $offset";

$hasil = mysqli_query($kon, $sql);
$no = $offset + 1;
?>

<table class="my-3 table table-bordered">
    <thead>
        <tr class="table-primary">
            <th>No Id</th>
            <th>Nama Pasien</th>
            <th>Jenis Kelamin</th>
            <th>Alamat</th>
            <th>No Telp</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($data = mysqli_fetch_array($hasil)) {
        ?>
            <tr>
                <td><?php echo sprintf('%04d', $data["id"]); ?></td>
                <td><?php echo htmlspecialchars($data["nama_pasien"]); ?></td>
                <td><?php echo htmlspecialchars($data["jenis_kelamin"]); ?></td>
                <td><?php echo htmlspecialchars($data["alamat"]); ?></td>
                <td><?php echo htmlspecialchars($data["no_telp"]); ?></td>
                <td>
                    <a href="update.php?id=<?php echo htmlspecialchars($data['id']); ?>" class="btn btn-warning" role="button">Update</a>
                    <a href="pasien.php?id=<?php echo $data['id']; ?>" class="btn btn-danger" role="button"><img src="images/delete.png" alt="Delete"></a>
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
            <li class="page-item"><a class="page-link" href="#" data-page="<?php echo $page - 1; ?>">Previous</a></li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>"><a class="page-link" href="#" data-page="<?php echo $i; ?>"><?php echo $i; ?></a></li>
        <?php endfor; ?>

        <?php if ($page < $total_pages) : ?>
            <li class="page-item"><a class="page-link" href="#" data-page="<?php echo $page + 1; ?>">Next</a></li>
        <?php endif; ?>
    </ul>
</nav>