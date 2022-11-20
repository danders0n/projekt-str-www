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
    session_start();

    include '../components/header.php';
    include '../components/nav.php';

    // generates strings from forms into index.php
    function createPage($pageTitle, $pageAuthor, $pageDesc, $pageContent) {
        $str = "";

        // head generator
        $head_arr = array(
            "<!DOCTYPE HTML>\n<html lang=\"pl\">\n<head>\n\t<title>", 
            "</title>\n\t<meta charset=\"utf-8\">\n\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n\t<meta name=\"author\" content=\"",
            "\">\n\t<meta name=\"description\" content=\"",
            "\">\n\t<link rel=\"stylesheet\" href=\"/projekt-str-www/styles.css\">\n\t<link rel=\"stylesheet\" href=\"/projekt-str-www/admin/styles-admin.css\">\n</head>\n",
        );
        $head_str = '<?php session_start();?>'.$head_arr[0].$pageTitle.$head_arr[1].$pageAuthor.$head_arr[2].$pageDesc.$head_arr[3];
        // *************************************************************

        $logo_str = "<?php include \$_SERVER['DOCUMENT_ROOT'].\$_SESSION['abs_path'].'/components/header.php';?>";
        $nav_str = "<?php include \$_SERVER['DOCUMENT_ROOT'].\$_SESSION['abs_path'].'/components/nav.php';?>";

        $nav_admin_str = "<?php if(isset(\$_SESSION['logged']) && (\$_SESSION['logged'] == true)) {include \$_SERVER['DOCUMENT_ROOT'].\$_SESSION['abs_path'].'/admin/nav-admin.php';}?>";

        //content generator 
        $content_arr = array (
            "\t<div class=\"content\">\n",
            "\t</div>\n"
        );
        $content_str = $content_arr[0].$pageContent.$content_arr[1];
        // *************************************************************

        //footer generator
        $footer_str = "<?php include \$_SERVER['DOCUMENT_ROOT'].\$_SESSION['abs_path'].'/components/footer.php';?>";

        $str = $head_str.$logo_str.$nav_str.$nav_admin_str.$content_str.$footer_str;
        return $str;
    }
    // *************************************************************

    // if logged user add admin nav menu
    if(isset($_SESSION['logged']) && ($_SESSION['logged'] == true)) {
        include 'nav-admin.php';

        if ((isset($_POST['title'])) && (isset($_POST['author'])) && (isset($_POST['description'])) && (isset($_POST['content']))) {
            
            $title   = $_POST['title'];
            $author  = $_POST['author'];
            $desc    = $_POST['description'];
            $content = $_POST['content'];

            $str = $name = str_replace(' ', '_', $title);
        
            $pagePath = $_SERVER['DOCUMENT_ROOT'].$_SESSION['abs_path'].'/projects/'.$str;
            if(is_dir($pagePath)){
               echo '<br><center>Strona o takiej nazwie już istnienie!</center>'; 
            } else {
                mkdir($pagePath, 0777, true);

                //db entry
                require_once '../components/connect.php';

                $conn = new mysqli($GLOBALS['host'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
                if($conn->connect_errno!=0) {
                    throw new Exception(mysqli_connect_errno());
                } else {
                    // add into logs
                    $sql = "INSERT INTO logs (type, author, msg)
                            VALUES ('ADD_PROJECT', '".$author."', 'Project: ".$title." was added in: ".$pagePath."')";
                    $result = $conn->query($sql);
                    if(!$result) throw new Exception($conn->error);
                    
                    //add into projects lists
                    $sql = "INSERT INTO projects (title, author, directory)
                            VALUES ('".$title."', '".$author."', '".$pagePath."')";
                    $result = $conn->query($sql);
                    if(!$result) throw new Exception($conn->error);
                    

                    $conn->close();
                }
                // *********************** 
                
                $page = fopen($pagePath.'/index.php', 'w');
                fwrite($page, createPage($title, $author, $desc, $content));
                fclose($page);
                echo '<br><center>Strona utworzona!</center>'; 
                Header('Location: '.$_SERVER['PHP_SELF']);
            }
        }
    } else {
        header("Location: ../index.php");
        exit();
    };
?>
    <div class="content">
    <form action="page.php" method="post">
        <fieldset>
            <legend>Informacje:</legend>
            <div class="form">
                <label for="title">Tytuł:</label><br>
                <input type="text" id="title" name="title" value="project-01" required>
            </div>
            <div class="form">
                <label for="author">Autor:</label><br>
                <input type="text" id="author" name="author" value="admin" required>
            </div>
            <div class="form">
                <label for="description">Opis:</label><br>
                <input type="text" id="description" name="description" value="short desc">
            </div>   
        </fieldset>
        <br>
        <fieldset>
            <legend>Edytor:</legend>
            <textarea name="content"></textarea>
        </fieldset>
        <br>
        <fieldset>
            <legend>Zatwierdz zmiany</legend>
            <input type="submit" value="Zapisz stronę">
        </fieldset>
    </form>
    </div>   
<?php include '../components/footer.php'; ?>