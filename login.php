<!DOCTYPE HTML>
<html lang="pl">
<head>
    <title>Projekt zaliczeniowy</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Daj dlugopis bedzie opis">

    <link rel="stylesheet" href="styles.css">
</head>
<?php
    session_start();

    include 'components/header.php';
    include 'components/nav.php';
    
    // jezeli zalogowany dodaj opcje admina
    if(isset($_SESSION['logged']) && ($_SESSION['logged'] == true)) {
        include 'admin/nav-admin.php';
    }
?>
<div class="content">
    <div class="login"">
        <form>
            Login:
            <input type="text" name="username" id="username" required>
            <br><br>
            Hasło:
            <input type="password" name="password" id="password" required>
            <br><br>
            <input type="submit" value="Zaloguj się">
        </form>
    </div>
</div>
<?php include 'components/footer.php'; ?>