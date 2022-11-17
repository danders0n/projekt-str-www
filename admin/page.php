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

    // generates strings from forms into index.html
    function createPage($pageTitle, $pageAuthor, $pageDesc, $pageContent) {
        $str = "";

        // head generator
        $head_arr = array(
            "<!DOCTYPE HTML>\n<html lang=\"pl\">\n<head>\n\t<title>", 
            "</title>\n\t<meta charset=\"utf-8\">\n\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n\t<meta name=\"author\" content=\"",
            "\">\n\t<meta name=\"description\" content=\"",
            "\">\n\t<link rel=\"stylesheet\" href=\"/projekt-str-www/styles.css\">\n\t<link rel=\"stylesheet\" href=\"/projekt-str-www//admin/styles-admin.css\">\n</head>\n",
        );
        $head_str = $head_arr[0].$pageTitle.$head_arr[1].$pageAuthor.$head_arr[2].$pageDesc.$head_arr[3];
        // *************************************************************

        // logo generator
        $logo_arr = array(
            "<body>\n<div class=\"wrapper\">\n\t<div class=\"header\">\n\t\t<div class=\"logo\">\n\t\t\t",
            "\n\t\t</div>\n\t</div>\n"
        );
        $logo_str = $logo_arr[0]."LOGO".$logo_arr[1];
        // *************************************************************

        //nav generator
        $nav_arr = array(
            "\t<div class=\"nav\">\n\t\t<ol>\n\t\t\t<li><a href=/projekt-str-www/index.php>Home</a></li>\n\t\t\t<li><a href=/projekt-str-www/about.php>O nas</a></li>\n",
            "\t\t\t<li>\n\t\t\t\t<a href=\"#\">Projekty</a>\n\t\t\t\t<ul>\n",
            "\t\t\t\t</ul>\n\t\t\t</li>\n\t\t\t<li><a href=/projekt-str-www/contact.php>Kontakt</a></li>\n\t\t\t<li>",
            "</li>\n",
            "\t\t<ol>\n\t</div>\n"
        );
        $nav_str = $nav_arr[0].$nav_arr[1]."\t\t\t\t\tGet some\n".$nav_arr[2]."placeholder".$nav_arr[3].$nav_arr[4];
        // *************************************************************

        //TODO: 
        // 1. if logged user generate admin menu 
        // 2. convert text into html marks
        // 3. create appropriate login/logout in nav menu

        //content generator 
        $content_arr = array (
            "\t<div class=\"content\">\n",
            "\t</div>\n"
        );
        $content_str = $content_arr[0].$pageContent.$content_arr[1];
        // *************************************************************

        //footer generator
        $footer_arr = array (
            "\t<div class=\"footer\">\n\t\t\t",
            "\n\t</div>\n</div>\n</body>\n</html>"
        );
        $footer_str = $footer_arr[0]."Tytuł Strony © 2023<br>Co dzień z pamiątką nudnych postaci i zdarzeń. Wracam do samotności, do książek - [do] marzeń.".$footer_arr[1];
        // *************************************************************

        $str = $head_str.$logo_str.$nav_str.$content_str.$footer_str;
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
        
            $pagePath = $root.$abs_path.'/projects/'.$title;
            if(is_dir($pagePath)){
               echo '<br><center>Strona o takiej nazwie już istnienie!</center>'; 
            } else {
                mkdir($pagePath, 0777, true);
                
                $page = fopen($pagePath.'/index.html', 'w');
                fwrite($page, createPage($title, $author, $desc, $content));
                fclose($page);
                echo '<br><center>Strona utworzona!</center>'; 
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