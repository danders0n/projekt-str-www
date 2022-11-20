<!DOCTYPE HTML>
<html lang="pl">
<head>
    <title>Projekt zaliczeniowy</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Daj dlugopis bedzie opis">

    <link rel="stylesheet" href="styles.css">
</head>
<style type='text/css'>
form > table > td > fieldset {
    
    float: left;
    width: 50%;
}
</style>
<?php
    require_once 'components/connect.php';
    //unset($_POST['db_host'], $_POST['db_username'], $_POST['db_password'], $_POST['db_name']);

    //check if webside have access to db
    //if((isset($host)) && (isset($db_username)) && (isset($db_name))) {
        //header("Location: index.php");
       // exit();
   // }

    session_start();

    include 'components/header.php';
    include 'components/nav.php';
?>
    <div class="content">
    <?php
        //create db for webpage
        if ((isset($_POST['db_host'])) && (isset($_POST['db_username'])) && (isset($_POST['db_password'])) && (isset($_POST['db_name']))) {

            $GLOBALS['host'] = $_POST['db_host'];
            $GLOBALS['db_username'] = $_POST['db_username'];
            $GLOBALS['db_password'] = $_POST['db_password'];
            $GLOBALS['db_name'] = $_POST['db_name'];

            $admin_username = $_POST['admin_username'];
            $admin_password = $_POST['admin_password'];

            $conn = new mysqli($GLOBALS['host'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } else {
                echo "Connection SUCCESSFUL<br>";
                
                // create table USERS
                $sql = "CREATE TABLE IF NOT EXISTS users (
                    id INT(16) AUTO_INCREMENT PRIMARY KEY, 
                    username VARCHAR(255) NOT NULL, 
                    password VARCHAR(255) NOT NULL, 
                    date DATETIME DEFAULT CURRENT_TIMESTAMP)";

                if($conn->query($sql) === TRUE) {
                    echo "Creating table 'users' SUCCESSFUL<br>";
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
                    echo "Creating table 'projects' SUCCESSFUL<br>";
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
                    echo "Creating table 'logs' SUCCESSFUL<br>";
                }else{ 
                    echo "Error creating table 'logs': " . $conn->error;
                }
                // *********************************************

                // create first account
                $sql = "INSERT INTO users (username, password)
                VALUES ('".$admin_username."', '".$admin_password."')";

                if($conn->query($sql) === TRUE) {
                    echo "Creating first user SUCCESSFUL<br>";
                }else{ 
                    echo "Error creating first user: " . $conn->error;
                }
                // *********************************************

                //creating first logs
                $sql = "INSERT INTO logs (type, author, msg)
                VALUES ('INSTALL', 'SYSTEM', 'User: ".$admin_username." was created.')";

                if($conn->query($sql) === TRUE) {
                    echo "Creating first log SUCCESSFUL<br>";
                }else{ 
                    echo "Error creating first log: " . $conn->error;
                }
                // *********************************************

            }
            $conn->close();
        }            
        //header("Location: login.php");
        //exit();
    ?>
        <center>
            <form action="install.php" method="post">
                <table> 
                    <td>
                        <fieldset>
                            <legend>BAZA DANYCH:</legend>
                            <label for="db_host">HOST:</label><br>
                                <input type="text" id="db_host" name="db_host" value="localhost" required><br><br>
                            <label for="db_username">NAZWA UŻYTKOWNIKA:</label><br>
                                <input type="text" id="db_username" name="db_username" value="projekt_str_www" required><br><br>
                            <label for="db_password">HASŁO UŻYTKOWNIKA:</label><br>
                            <input type="password" id="db_password" name="db_password" value="projekt_str_www" required><br><br>
                            <label for="db_name">NAZWA BAZY DANYCH:</label><br>
                                <input type="text" id="db_name" name="db_name" value="projekt_str_www" required><br><br>
                        </fieldset>
                    </td> 
                    <td>
                        <fieldset>
                            <legend>KONTO ADMINISTRATORA:</legend>
                            <label for="admin_username">NAZWA:</label><br>
                                <input type="text" id="admin_username" name="admin_username"  value="admin" required><br><br>
                            <label for="admin_pass">HASŁO:</label><br>
                                <input type="password" id="admin_password" name="admin_password" required><br><br>
                        </fieldset>
                        <div style="text-align: center;">
                            <input type="submit" value="Instaluj">
                        </div>
                    </td>
                </table>    
            </form>
        </center>
    </div>
<?php include 'components/footer.php'; ?>