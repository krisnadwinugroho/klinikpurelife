<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="title_icon.png" type="image/png">
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

        .search-suggestion {
            position: absolute;
            background-color: white;
            border: 1px solid #ddd;
            z-index: 999;
            max-height: 200px;
            overflow-y: auto;
            width: calc(100% - 22px);
            display: none;
        }

        .search-suggestion a {
            display: block;
            padding: 10px;
            color: #333;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .search-suggestion a:hover {
            background-color: #f0f0f0;
        }
    </style>

<body>

    <?php include 'sidebar.php'; ?>
    <div class="content">
        <h2>Welcome Back, <?php echo $_SESSION['username']; ?>!</h2>
        <p>"The first wealth is health." - Ralph Waldo Emerson</p>

    </div>
</body>

</html>