<?php
/* czy dodane wszędzie, gdzie trzeba sprawdzenie, $_SESSION['logged'], czy zabraniać dostęp do stron jak niezalogowane (jak poniżej), 
czy wtedy tylko brak opcji admina? */

/* 
if(!isset($_SESSION['logged'])) {
    header('Location: about.php'); 
    exit();
} */
require_once "connect.php"; //halko halko gdzie ten pliczor policja

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
    if($users_no==1){ // sprawdzanie, czy znajduje się (jedna) osoba o tych danych w DB

        $_SESSION['logged'] = true;

        $line = $answear->fetch_assoc();
        $username = $line['username'];

        unset($_SESSION['invalid_password']);
        $answear->free_result();
        header('Location: about.php');
    }
    else{ // jeśli nie, ustawiona zmienna invalid_password i przeniesienie do strony logowania
        $_SESSION['invalid_password'] = '<span style="color:red">Invalid username or password.</span>';
        header('Location: login.php');
    }

    $conn->close();
}


?>