<!DOCTYPE HTML>
<html lang="pl">
<head>
    <title>Projekt zaliczeniowy</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Daj dlugopis bedzie opis">

    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="styles-admin.css">
</head>
<?php
    session_start(); // wazne, podobno... xdd

    include '../components/header.php';
    include '../components/nav.php';

    // jezeli zalogowany dodaj opcje admina
    if(isset($_SESSION['logged']) && ($_SESSION['logged'] == true)) {
        include 'nav-admin.php';
    } else {
        header("Location: ../index.php");
        exit();
    };
?>
    <div class="content">
    <?php
        if(isset($_SESSION['useradded'])) {
            echo '<div id="msg">Użytkownik dodany</div>';
            unset($_SESSION['useradded']);
        }
    ?>
        <div id="logs">
            <table>
                <caption><b>Wydarzenia:</b></caption>
                <tr>
                    <th>ID:</th>
                    <th>Typ:</th>
                    <th>Autor:</th>
                    <th>Wiadomość:</th>
                    <th>Czas:</th>
                </tr>
            <?php 
                require_once '../components/connect.php';

                $conn = new mysqli($GLOBALS['host'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
                if($conn->connect_errno!=0) {
                    throw new Exception(mysqli_connect_errno());
                } else {
                    $sql = 'SELECT id, type, author, msg, date FROM logs';
                    $result = $conn->query($sql);
                    if(!$result) throw new Exception($conn->error);

                    while($row = $result->fetch_assoc())
                    {
                        echo "\t\t\t\t<tr>\n\t\t\t\t\t<td>".$row["id"]."</td>\n";
                        echo "\t\t\t\t\t<td>".$row["type"]."</td>";
                        echo "\t\t\t\t\t<td>".$row["author"]."</td>";
                        echo "\t\t\t\t\t<td>".$row["msg"]."</td>";
                        echo "\n\t\t\t\t\t<td>".$row["date"]."</td>\n\t\t\t\t</tr>\n";
                    }
                    $conn->close();
                }
            ?>
            </table>
        </div>
        <div id="pages">
        <table>
                <caption><b>Lista dodanych projektów:</b></caption>
                <tr>
                    <th>ID:</th>
                    <th>Tytuł:</th>
                    <th>Autor:</th>
                    <th>Dodany:</th>
                </tr>
            <?php 
                require_once '../components/connect.php';

                $conn = new mysqli($GLOBALS['host'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
                if($conn->connect_errno!=0) {
                    throw new Exception(mysqli_connect_errno());
                } else {
                    $sql = 'SELECT id, title, author, date FROM projects';
                    $result = $conn->query($sql);
                    if(!$result) throw new Exception($conn->error);

                    while($row = $result->fetch_assoc())
                    {
                        echo "\t\t\t\t<tr>\n\t\t\t\t\t<td>".$row["id"]."</td>\n";
                        echo "\t\t\t\t\t<td>".$row["title"]."</td>";
                        echo "\t\t\t\t\t<td>".$row["author"]."</td>";
                        echo "\n\t\t\t\t\t<td>".$row["date"]."</td>\n\t\t\t\t</tr>\n";
                    }
                    $conn->close();
                }
            ?>
            </table>
        </div>
        <div id="users">
            <table>
                <caption><b>Lista użytkowników:</b></caption>
                <tr>
                    <th>ID:</th>
                    <th>Nazwa:</th>
                    <th>Dodany:</th>
                </tr>
            <?php 
                require_once '../components/connect.php';

                $conn = new mysqli($GLOBALS['host'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
                if($conn->connect_errno!=0) {
                    throw new Exception(mysqli_connect_errno());
                } else {
                    $sql = 'SELECT id, username, date FROM users';
                    $result = $conn->query($sql);
                    if(!$result) throw new Exception($conn->error);

                    while($row = $result->fetch_assoc())
                    {
                        echo "\t\t\t\t<tr>\n\t\t\t\t\t<td>".$row["id"]."</td>\n";
                        echo "\t\t\t\t\t<td>".$row["username"]."</td>";
                        echo "\n\t\t\t\t\t<td>".$row["date"]."</td>\n\t\t\t\t</tr>\n";
                    }
                    $conn->close();
                }
            ?>
            </table>
        </div>
    </div>
    <script>
        setTimeout(() => {
            const box = document.getElementById('msg');
            box.style.display = 'none';
        }, 5);
    </script>
<?php include '../components/footer.php'; ?>