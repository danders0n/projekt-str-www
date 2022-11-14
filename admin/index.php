<!DOCTYPE HTML>
<html lang="pl">
<head>
    <title>Projekt zaliczeniowy</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Daj dlugopis bedzie opis">

    <link rel="stylesheet" href="../styles.css">
</head>
<?php
    session_start(); // wazne, podobno... xdd

    include '../components/header.php';
    include '../components/nav.php';

    // jezeli zalogowany dodaj opcje admina
    if(isset($_SESSION['logged']) && ($_SESSION['logged'] == true)) {
        include 'nav-admin.php';
    } else {
        header("Location: ../index.php");
        exit();
    };
?>
    <div class="content">
       Admin Panel
    </div>
<?php include '../components/footer.php'; ?>