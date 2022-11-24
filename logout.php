<?php
//wylogowanie 
session_start();

session_unset(); // zniszczenie sesji
header('Location: login.php');

// dodać przycisk logout <a href='logout.php'>Logout<\a> !!!!!!!!!!!
?>