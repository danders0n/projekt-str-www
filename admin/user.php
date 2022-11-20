<!DOCTYPE HTML>
<html lang="pl">
<head>
    <title>Projekt zaliczeniowy</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Daj dlugopis bedzie opis">

    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="styles-admin.css">

    <style>
        form {
            margin-left: 0 auto;
            margin-right: 0 auto;
        }
        .error {
            color:red;
            margin-top: 12px;
            margin-bottom: 12px;
        }
    </style>
</head>
<?php
    session_start();

    include '../components/header.php';
    include '../components/nav.php';

    
    // jezeli zalogowany dodaj opcje admina
    if(isset($_SESSION['logged']) && ($_SESSION['logged'] == true)) {
        include 'nav-admin.php';

        if(isset($_POST['username'])) {
            $valid = true;//flag

            //check username
            $username = $_POST['username'];
            if((strlen($username) < 3) || (strlen($username) > 13)){
                $valid = false;
                $_SESSION['err_username'] = "Nick musi posiadać od 3 do 13 znaków!";
            }

            if(ctype_alnum($username) == false) {
                $valid = false;
                $_SESSION['err_username'] = "Nick może składać się tylko z liter i cyfr (bez polskich znaków)!";
            }
            // *******************************

            //check password
            $password_1 = $_POST['password_1'];
            $password_2 = $_POST['password_2'];

            if(strlen($password_1) < 5 || strlen($password_1) > 26) {
                $valid = false;
                $_SESSION['err_password'] = "Hasło musi posiadać od 5 do 26 znaków!";
            }

            if($password_1 != $password_2) {
                $valid = false;
                $_SESSION['err_password'] = "Podane hasła nie są takie same!";
            }
            // *******************************

            $password = password_hash($password_1, PASSWORD_DEFAULT);
            //echo $password; exit();

            require_once '../components/connect.php';
            mysqli_report(MYSQLI_REPORT_STRICT);

            try {
                $conn = new mysqli($GLOBALS['host'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
                if($conn->connect_errno!=0) {
                    throw new Exception(mysqli_connect_errno());
                } else {
                    // check if username exist
                    $sql = "SELECT id FROM users WHERE username='$username'";
                    $result = $conn->query($sql);
                    if(!$result) throw new Exception($conn->error);

                    if(($result->num_rows) > 0) {
                        $valid = false;
                        $_SESSION['err_username'] = "Podana nazwa użytkownika jest już używana!";
                    }
                    // *******************************

                    // check if valid add user to db
                    if($valid == true){
                        //add into logs
                        $sql = "INSERT INTO logs (type, author, msg)
                        VALUES ('ADD_USER', '".$username."', 'User ".$username." was created')";
                        $result = $conn->query($sql);
                        if(!$result) throw new Exception($conn->error);
                        
                        //add into users
                        $sql = "INSERT INTO users (username, password)
                        VALUES ('".$username."', '".$password."')";
                        if($conn->query($sql)) {
                            $_SESSION['useradded'] = true;
                            header('Location: index.php');
                        } else {
                            throw new Exception(mysqli_connect_errno());
                        }
                    }
                    // *******************************

                    $conn->close();
                }
            }
            catch(Exception $err) {
                echo '<span style="color:red"> Błąd serwera!</span>';
                echo '<br> Dev info: '.$err;
            }
        }
    } else {
        header("Location: ../index.php");
        exit();
    };
?>
    <div class="content">
        <center>
        <h2>Dodaj użytkownia</h2><br>
        <form method="post">
            Nazwa: <br>
            <input type="text" id="username" name="username"><br><br>
            <?php 
                if(isset($_SESSION['err_username'])) {
                    echo '<div class="error">'.$_SESSION["err_username"].'</div>';
                    unset($_SESSION["err_username"]);
                }
            ?>
            Hasło:<br>
            <input type="password" id="password_1" name="password_1"><br><br>
            <?php 
                if(isset($_SESSION['err_password'])) {
                    echo '<div class="error">'.$_SESSION["err_password"].'</div>';
                    unset($_SESSION["err_password"]);
                }
            ?>
            Powtórz hasło:<br>
            <input type="password" id="password_2" name="password_2"><br><br>
            <input type="submit" value="Utwórz użytkownika">
        </form>
        </center>
    </div>  
<?php include '../components/footer.php'; ?>