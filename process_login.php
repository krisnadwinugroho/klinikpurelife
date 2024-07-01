<?php
include "db.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $email = mysqli_real_escape_string($kon, $email);
    $password = mysqli_real_escape_string($kon, $password);

    $hashed_password = md5($password);

    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$hashed_password'";
    $result = mysqli_query($kon, $sql);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['email'] = $email;
        header('Location: dashboard.php');
    } else {
        header('Location: login.php?error=Invalid email or password');
    }
} else {
    header('Location: login.php');
}

mysqli_close($kon);
