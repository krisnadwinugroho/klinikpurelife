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
    $email = sanitize($_POST['email'], $kon);


    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$hashed_password','$email')";
    if (mysqli_query($kon, $sql)) {

        session_start();
        $_SESSION['username'] = $username;

        header("Location: login.html");
        exit();
    } else {
        echo '<div class="alert alert-danger">Error: ' . mysqli_error($kon) . '</div>';
    }
}


mysqli_close($kon);
