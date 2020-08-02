<?php 
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags   -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel = "stylesheet" href = "css/libs.min.css"> 
    <link rel = "stylesheet" href = "css/main.min.css"> 
</head>

<body>

    <div class="blog-masthead">
        <div class="container">
            <nav class="nav">
                <a class="nav-link active" href="index.php">Стена</a>
                <a class="nav-link <?php if ((isset($_SESSION["mail"]))){echo 'd-none';}?>" href="reg.php">Зарегистрироваться</a>
                <a class="nav-link <?php if ((isset($_SESSION["mail"]))){echo 'd-none';}?>" href="login.php">Войти</a>
                <span class="nav-link ml-auto <?php if (!(isset($_SESSION["mail"]))){echo 'd-none';}?>"><?php echo "@".$_SESSION["name"]; ?></span>
                <a class="nav-link <?php if (!(isset($_SESSION["mail"]))){echo 'd-none';}?>" href="exit.php">Выйти</a>
            </nav>
        </div>
    </div>