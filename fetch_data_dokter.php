<?php

include "db.php";


$page = isset($_GET['page']) ? $_GET['page'] : 1;
$search = isset($_GET['search']) ? input($_GET['search']) : '';


$limit = 5;


$offset = ($page - 1) * $limit;


$sql = "SELECT * FROM dokter";
if ($search) {
    $sql .= " WHERE nama_dokter LIKE '%$search%'";
}
$sql .= " ORDER BY id ASC LIMIT $limit OFFSET $offset";

$result = mysqli_query($kon, $sql);


$response = array();


if (mysqli_num_rows($result) > 0) {
    $response['data'] = '<table class="my-3 table table-bordered">
                            <thead>
                                <tr class="table-primary">
                                    <th>No Id</th>
                                    <th>Nama Dokter</th>
                                    <th>Spesialis</th>
                                    <th>Alamat</th>
                                    <th>No Telp</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>';

    while ($data = mysqli_fetch_array($result)) {
        $response['data'] .= '<tr>
                                <td>' . sprintf('%04d', $data["id"]) . '</td>
                                <td>' . htmlspecialchars($data["nama_dokter"]) . '</td>
                                <td>' . htmlspecialchars($data["spesialis"]) . '</td>
                                <td>' . htmlspecialchars($data["alamat"]) . '</td>
                                <td>' . htmlspecialchars($data["no_telp"]) . '</td>
                                <td>
                                    <a href="update_dokter.php?id=' . $data['id'] . '" class="btn btn-warning" role="button">Update</a>
                                    <a href="#" class="btn btn-danger btn-delete" data-id="' . $data['id'] . '"><img src="images/delete.png" alt="Delete"></a>
                                </td>
                            </tr>';
    }

    $response['data'] .= '</tbody></table>';


    $sql_total = "SELECT COUNT(*) AS total FROM dokter";
    if ($search) {
        $sql_total .= " WHERE nama_dokter LIKE '%$search%'";
    }
    $result_total = mysqli_query($kon, $sql_total);
    $row_total = mysqli_fetch_assoc($result_total);
    $total_records = $row_total['total'];
    $total_pages = ceil($total_records / $limit);

    $response['pagination'] = '<ul class="pagination">';
    for ($i = 1; $i <= $total_pages; $i++) {
        $response['pagination'] .= '<li class="page-item"><a class="page-link" href="#" data-page-number="' . $i . '">' . $i . '</a></li>';
    }
    $response['pagination'] .= '</ul>';
} else {

    $response['data'] = '<div class="alert alert-info">Tidak ada data dokter yang ditemukan.</div>';
    $response['pagination'] = '';
}


echo json_encode($response);


function input($data)
{
    global $kon;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return mysqli_real_escape_string($kon, $data);
}
