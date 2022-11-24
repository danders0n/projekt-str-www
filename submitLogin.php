<?php
/* czy dodane wszędzie, gdzie trzeba sprawdzenie, $_SESSION['logged'], czy zabraniać dostęp do stron jak niezalogowane (jak poniżej), 
czy wtedy tylko brak opcji admina? */

/* 
if(!isset($_SESSION['logged'])) {
    header('Location: about.php'); 
    exit();
} */

session_start();

if((!isset($_POST['username'])) || (!isset($_POST['password']))){
    header('Location: login.php');
    exit();
}

require_once "components/connect.php"; //halko halko gdzie ten pliczor policja

// Tworzenie polaczenia
$conn = new mysqli($host, $db_username, $db_password, $db_name);

// sprawdzanie polaczenia
if ($conn->connect_error!=0) {
    die("Connection failed: " . $conn->connect_error);
}
else{
    //echo "Connected successfully";
    $username=$_POST['username'];
    $password=$_POST['password'];

    // ochrona przed 'wstrzykiwaniem SQL'
    $username=htmlentities($username, ENT_QUOTES, "UTF-8");
    $password=htmlentities($password, ENT_QUOTES, "UTF-8");

    $answear = $conn->query(sprintf("SELECT username, password FROM users WHERE username = '%s'", 
    mysqli_real_escape_string($conn,$username)));

    if(!$answear) throw new Exception($conn->error);
    if ($answear)   {
        $users_no = $answear->num_rows;
        //echo $users_no;
        if($users_no==1){ // sprawdzanie, czy znajduje się (jedna) osoba o tych danych w DB

            $line = $answear->fetch_assoc();
            $hash = $line['password'];
            if (password_verify($password, $hash)) {
                echo "Haseła się zgadzają podobno...";
                $_SESSION['logged'] = true;

                $username = $line['username'];

                unset($_SESSION['err_login']);
                $answear->free_result();
                header('Location: index.php');
            } else {       
                $_SESSION['err_login'] = '<span style="color:red">Invalid username or password.</span>';
            header('Location: login.php');
            }
        } else { // jeśli nie, ustawiona zmienna invalid_password i przeniesienie do strony logowania
            $_SESSION['err_login'] = '<span style="color:red">Invalid username or password.</span>';
                header('Location: login.php');
        }
    }

    $conn->close();
}


?>