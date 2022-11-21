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

    $sql = "SELECT username, password FROM users WHERE username = '$username' AND password = '$password'";
    if ($answear=$conn->query($sql)){
        $users_no = $answear->num_rows;
    }
    if($users_no==1){
        $line = $answear->fetch_assoc();
        $username = $line['username'];

        $answear->free_result();
        //header('Location: ...')
    }
    else{
        // brak osoby o tym loginie i haśle
    }

    $conn->close();
}


?>