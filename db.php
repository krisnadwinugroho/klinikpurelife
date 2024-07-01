<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";


$kon = new mysqli($servername, $username, $password, $dbname);


if ($kon->connect_error) {
    die("Koneksi gagal: " . $kon->connect_error);
}
