<?php

include "db.php";


function sanitize($data, $kon)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return mysqli_real_escape_string($kon, $data);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = sanitize($_POST['username'], $kon);
    $password = sanitize($_POST['password'], $kon);


    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($kon, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {

        session_start();
        $_SESSION['username'] = $username;


        header("Location: welcome.php");
        exit();
    } else {
        echo '<div class="alert alert-danger">Invalid username or password.</div>';
    }
}


mysqli_close($kon);
