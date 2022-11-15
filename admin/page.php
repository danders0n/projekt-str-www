<!DOCTYPE HTML>
<html lang="pl">
<head>
    <title>Projekt zaliczeniowy</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Daj dlugopis bedzie opis">

    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="styles-admin.css">
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
    <form>
        <fieldset>
            <legend>Informacje:</legend>
            <div class="form">
                <label for="title">Tytuł:</label><br>
                <input type="text" id="title" name="title">
            </div>
            <div class="form">
                <label for="author">Autor:</label><br>
                <input type="text" id="author" name="author">
            </div>
            <div class="form">
                <label for="description">Opis:</label><br>
                <input type="text" id="description" name="description">
            </div>   
        </fieldset>
        <br>
        <fieldset>
            <legend>Edytor:</legend>
            <textarea name="message"></textarea>
        </fieldset>
        <br>
        <fieldset>
            <legend>Zatwierdz zmiany</legend>
            <input type="submit" value="Zapisz stronę">
        </fieldset>
    </form>
    </div>   
<?php include '../components/footer.php'; ?>