<?php
    session_start();

    if(file_exists('components/connect.php')) {
        //header("Location: index.php");
        //exit();
    }
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
    <title>Instalacja</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Daj dlugopis bedzie opis">

    <link rel="stylesheet" href="styles.css">
</head>
<style>
.wrapper {
    padding-top:40px; 
    padding-bottom:40px;
}
.logo {
    font-size: 32px;
}
.content {
    border: 1px solid;
    width: 1024px;
    margin-top: 40px;
    margin-left: auto;
    margin-right: auto;
    padding: 12px;
    text-align: center;
}
th, td{
    margin-left: auto;
    margin-right: auto;
    text-align: left;
    padding-left: 16px;
}
p {
text-align: center;
}
</style>
<body>
<div class="wrapper">
    <div class="logo"> 
        INSTALACJA<br>
        <?php
        switch ($_GET['step']) {
            case 1:
                echo "Krok: 1/5"; // welcome screen
                break;
            case 2:
                echo "Krok: 2/5"; // db settings
                break;
            case 3:
                echo "Krok: 3/5"; // db test
                break;
            case 4:
                echo "Krok: 4/5"; // admin account, webside name
                break;
            case 5:
                echo "Krok: 5/5"; // goodbye screen
                break;
            default:
                echo "Nieoczekiwany błąd"; // error handler
        }
        ?>
    </div>
    <div class="content">
    <?php
        switch ($_GET['step']) {
            case 1: // Welcome Screen
    ?>
                <!-- case 1 - Welcome Screen --> 
                Witaj w procesie instalacji!<br><br>
                Jeżeli widzisz tą stronę to znaczy, że uruchamiasz ją po raz pierwszy i nie zostało wykrytę połączenie do bazy danych.<br><br>
                Aby rozpocząć instalacje kliknij przycisk poniżej. Powodzenia... przyda Ci się.
                <form action="new-install.php" method="get">
                    <input type="number"  name="step" value="2" style="visibility: hidden;"><br>
                    <input type="submit" value="Rozpocznij"/>
                </form>
                <!-- case 1 - Welcome Screen -->  
    <?php
                break;
            case 2: // DB Settings
                if(isset($_SESSION['err_db_conn'])) {
                    echo '<span style="color:red"> Błąd serwera!<br>';
                    echo $_SESSION['err_db_conn'].'</span>';
                }
    ?>
                <!-- case 2 DB Settings --> 
                <form method="post" action="new-install.php?step=3">
                    <p>Wprowadź dane potrzebne do łączenia się z bazą danych. Jeśli ich nie posiadasz, możesz je otrzymać od administratora swojego serwera.</p>
                    <table>
                        <tr>
                            <th><label for="db_name">Nazwa bazy danych</label></th>
                            <td><input name="db_name" id="db_name" type="text" placeholder="Nazwa" autofocus/></td>
                            <td>Nazwa bazy danych która ma być używana przez WordPressa.</td>
                        </tr>
                        <tr>
                            <th><label for="db_usr">Nazwa użytkownika</label></th>
                            <td><input name="db_usr" id="db_usr" type="text" placeholder="Użytkownik" /></td>
                            <td> Nazwa użytkownika bazy danych.</td>
                        </tr>
                        <tr>
                            <th><label for="db_pwd">Hasło</label></th>
                            <td><input name="db_pwd" id="db_pwd" type="text" placeholder="Hasło" /></td>
                            <td>Hasło bazy danych.</td>
                        </tr>
                        <tr>
                            <th><label for="db_host">Adres serwera bazy danych</label></th>
                            <td><input name="db_host" id="db_host" type="text" placeholder="localhost" /></td>
                            <td>Jeśli <code>localhost</code> nie zadziała, postaraj się uzyskać informację od swojego hostingodawcy.</td>
                        </tr>
                    </table>
                    <p><input name="submit" type="submit" value="Wyślij" /></p>
                </form>
                <!-- case 2 DB Settings -->
    <?php
                break;
            case 3: // DB Connection Test

                // crete compoments/connect.php file
                $file = fopen("components/connect.php", "w") or die("Unable to open file!");
                $str = '<?php $host = "'.$_POST['db_host'].'"; $db_username = "'.$_POST["db_usr"].'"; $db_password = "'.$_POST["db_pwd"].'"; $db_name = "'.$_POST["db_name"].'"; ?>';
                fwrite($file, $str);
                fclose($file);
                // *********************************************

                require_once 'components/connect.php';

                try {
                    $conn = new mysqli($host, $db_username,$db_password, $db_name);
                    if($conn->connect_errno!=0) {
                        throw new Exception(mysqli_connect_errno());
                    } else {
                        echo "Połączenie do bazy danych: <p style=\"color:green; font-weight: bold;\">POMYŚLNE</p>";

                        // create table USERS
                        $sql = "CREATE TABLE IF NOT EXISTS users (
                            id INT(16) AUTO_INCREMENT PRIMARY KEY, 
                            username VARCHAR(255) NOT NULL, 
                            password VARCHAR(255) NOT NULL, 
                            date DATETIME DEFAULT CURRENT_TIMESTAMP)";

                        if($conn->query($sql) === TRUE) {
                            echo "Creating table 'users'; SUCCESSFUL<br>";
                        }else{ 
                            echo "Error creating table 'users': " . $conn->error;
                        }
                        // *********************************************

                        // create table PROJECTS
                        $sql = "CREATE TABLE IF NOT EXISTS projects (
                            id INT(16) AUTO_INCREMENT PRIMARY KEY, 
                            title VARCHAR(255) NOT NULL, 
                            author VARCHAR(255) NOT NULL,
                            directory VARCHAR(255) NOT NULL,
                            date DATETIME DEFAULT CURRENT_TIMESTAMP)";

                        if($conn->query($sql) === TRUE) {
                            echo "Creating table 'projects': SUCCESSFUL<br>";
                        }else{ 
                            echo "Error creating table 'projects': " . $conn->error;
                        }
                        // *********************************************

                        // create table LOGS
                        $sql = "CREATE TABLE IF NOT EXISTS logs (
                            id INT(16) AUTO_INCREMENT PRIMARY KEY, 
                            type VARCHAR(255) NOT NULL, 
                            author VARCHAR(255) NOT NULL,
                            msg VARCHAR(255) NOT NULL,
                            date DATETIME DEFAULT CURRENT_TIMESTAMP)";

                        if($conn->query($sql) === TRUE) {
                            echo "Creating table 'logs': SUCCESSFUL<br><br>";
                        }else{ 
                            echo "Error creating table 'logs': " . $conn->error;
                        }
                        // *********************************************

                        $conn->close();
                    }
                }
                catch(Exception $err) {
                    $_SESSION['err_db_conn'] = "Nie udało się nawiązać połączenia do bazy danych";
                    Header("Location: new-install.php?step=2");
                }
    ?>
                <!-- case 3 DB Connection Test -->
                Strona pomyślnie podłączyła się do bazy danych i utworzyła potrzebne tabele. Gratulacje idzie Ci smerfastycznie!
                <form action="new-install.php" method="get">
                    <input type="number"  name="step" value="4" style="visibility: hidden;"><br>
                    <input type="submit" value="Dalej"/>
                </form>
                <!-- case 3 DB Connection Test -->
    <?php
                break;
            case 4: // Admin Account, Webside Name
                require_once 'components/connect.php';
    ?>
                <!-- case 4 DB Admin Account, Webside Name -->
                <form method="post" action="new-install.php?step=5">
                    <p>Wprowadź dane potrzebne aby zakończyć instalacje witryny.</p>
                    <table>
                        <tr>
                            <th><label for="website_name">Nazwa witryny</label></th>
                            <td><input name="website_name" id="website_name" type="text" placeholder="Nazwa witryny" /></td>
                            <td> Nazwa witrny, bedzie widoczna w tytule, stopce i karcie przeglądarki.</td>
                        </tr>
                        <tr>
                            <th><label for="admin_usr">Nazwa konta</label></th>
                            <td><input name="admin_usr" id="admin_usr" type="text" placeholder="admin" /></td>
                            <td>
                            <?php 
                            if(isset($_SESSION['err_admin_usr'])) {
                                echo "\t<span style=\"color:red\">".$_SESSION["err_admin_usr"]."</span>\n";
                                unset($_SESSION["err_admin_usr"]);
                            } else {
                                echo "\tNazwa użytkownika, którego będzisz używał do logowania i dodawania nowych kont.\n";
                            }
                            ?>
                            </td>
                        </tr>

                        <tr>
                            <th><label for="admin_pwd_1">Hasło</label></th>
                            <td><input name="admin_pwd_1" id="admin_pwd_1" type="text" placeholder="haslo" /></td>
                            <td>
                            <?php 
                            if(isset($_SESSION['err_admin_pwd'])) {
                                echo "\t<span style=\"color:red\">".$_SESSION["err_admin_pwd"]."</span>\n";
                                unset($_SESSION["err_admin_pwd"]);
                            } else {
                                echo "\tHasło użytkownika.\n";
                            }
                            ?>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="admin_pwd_2">Powtórz hasło</label></th>
                            <td><input name="admin_pwd_2" id="admin_pwd_2" type="text" placeholder="haslo" /></td>
                            <td>
                            <?php 
                            if(isset($_SESSION['err_admin_pwd'])) {
                                echo "\t<span style=\"color:red\">".$_SESSION["err_admin_pwd"]."</span>\n";
                                unset($_SESSION["err_admin_pwd"]);
                            } else {
                                echo "\tHasło użytkownika.\n";
                            }
                            ?>
                            </td>
                        </tr>
                    </table>
                    <p><input name="submit" type="submit" value="Zainstaluj" /></p>
                </form>
                <!-- case 4 DB Admin Account, Webside Name -->
    <?php
                break;
            case 5: // Goodbye Page
                if(isset($_POST['admin_usr'])) {
                    $valid = true;  //flag
        
                    //check username
                    $username = $_POST['admin_usr'];
                    if((strlen($username) < 3) || (strlen($username) > 13)){
                        $valid = false;
                        $_SESSION['err_admin_usr'] = "Nick musi posiadać od 3 do 13 znaków!";
                        header("Location: new-install.php?step=4");
                    }
        
                    if(ctype_alnum($username) == false) {
                        $valid = false;
                        $_SESSION['err_admin_usr'] = "Nick może składać się tylko z liter i cyfr (bez polskich znaków)!";
                        header("Location: new-install.php?step=4");
                    }
                    // *******************************
                    
                    // check if username exist
                    require_once 'components/connect.php';
                    $conn = new mysqli($host, $db_username,$db_password, $db_name);
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    } else {
                        $sql = "SELECT id FROM users WHERE username='$username'";
                        $result = $conn->query($sql);
                        if(!$result) throw new Exception($conn->error);

                        if(($result->num_rows) > 0) {
                            $valid = false;
                            $_SESSION['err_admin_usr'] = "Podana nazwa użytkownika jest już używana!";
                            header("Location: new-install.php?step=4");
                        }
                        $conn->close();
                    }
                    // *******************************
        
                    //check password
                    $password_1 = $_POST['admin_pwd_1'];
                    $password_2 = $_POST['admin_pwd_2'];
        
                    if(strlen($password_1) < 5 || strlen($password_1) > 26) {
                        $valid = false;
                        $_SESSION['err_admin_pwd'] = "Hasło musi posiadać od 5 do 26 znaków!";
                        header("Location: new-install.php?step=4");
                    }
        
                    if($password_1 != $password_2) {
                        $valid = false;
                        $_SESSION['err_admin_pwd'] = "Podane hasła nie są takie same!";
                        header("Location: new-install.php?step=4");
                    }
                    // *******************************

                    $password = password_hash($password_1, PASSWORD_DEFAULT);

                    // check if valid add user to db
                    if($valid == true){
                        require_once 'components/connect.php';
                        $conn = new mysqli($host, $db_username,$db_password, $db_name);
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        } else {
                            //add install into logs
                            $sql = "INSERT INTO logs (type, author, msg)
                            VALUES ('INSTALL', 'SYSTEM', 'Webpage was installed.')";
                            $result = $conn->query($sql);
                            if(!$result) throw new Exception($conn->error);

                            //add user into logs
                            $sql = "INSERT INTO logs (type, author, msg)
                            VALUES ('INSTALL', 'SYSTEM', 'User ".$username." was created.')";
                            $result = $conn->query($sql);
                            if(!$result) throw new Exception($conn->error);
                            
                            //add into users
                            $sql = "INSERT INTO users (username, password)
                            VALUES ('".$username."', '".$password."')";
                            if($conn->query($sql)) {
                                header('Location: new-install.php?step=5');
                            } else {
                                throw new Exception(mysqli_connect_errno());
                            }
                            $conn->close();
                        }
                    }
                }
                // *******************************
                
    ?>
                <!-- case 5 Goodbye Page -->
                <p>Gratulacje!</p>
                Wygląda na to że instalacja Ci się udała, zotaniesz teraz przeniesony do strony logowania, baw się dobrze...
                <form action="login.php" method="post">
                    <input style="visibility: hidden;"><br>
                    <input type="submit" value="Zakończ"/>
                </form>
                <!-- case 5 Goodbye Page -->
    <?php
                break;
            default:
                echo "Nieoczekiwany błąd! Bye..."; // Error Handler
        }
    ?>
</div>
</body>
</html>