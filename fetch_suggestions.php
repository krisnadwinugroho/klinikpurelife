<?php
include "db.php";

$query = isset($_GET['query']) ? $_GET['query'] : '';

$sql = "SELECT DISTINCT nama_pasien FROM pasien WHERE nama_pasien LIKE '%$query%' LIMIT 5";
$result = mysqli_query($kon, $sql);

$output = '';
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= '<a href="#" class="list-group-item list-group-item-action">' . $row['nama_pasien'] . '</a>';
    }
    echo $output;
} else {
    echo '<div class="list-group-item">No suggestions</div>';
}
