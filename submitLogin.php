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

        unset($_SESSION['invalid_password']);
        $answear->free_result();
        header('Location: about.php');
    }
    else{
        $_SESSION['invalid_password'] = '<span style="color:red">Invalid username or password.</span>';
        header('Location: login.php');
    }

    $conn->close();
}


?>