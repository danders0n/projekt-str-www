<?php

require_once "connect.php";

// Tworzenie polaczenia
$conn = new mysqli($servername, $username, $password);

// sprawdzanie polaczenia
if ($conn->connect_error!=0) {
    die("Connection failed: " . $conn->connect_error);
}
else{
    echo "Connected successfully";
    $username=$_POST['username'];
    $password=$_POST['password'];

//  sql = "SELECT * FROM nazwa_tabeli WHERE nazwa_kolumny1 = '$username' AND nazwa_kolumny2 = '$password'";
//  if ($answear=$conn->query($sql)){$users_no = $answear->num_rows};
//  if($users_no==1){}

    $conn->close();
}


?>