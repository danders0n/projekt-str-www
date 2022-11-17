<?php
function getProjectList(){
    
}
?>
<div class="nav">
    <ol>
        <li><a href=<?php echo $_SESSION['abs_path']."/index.php"; ?>>Home</a></li>
        <li><a href=<?php echo $_SESSION['abs_path']."/about.php"; ?>>O nas</a></li>
        <li><a href="#">Projekty</a>
            <ul><?php
                $path = $_SERVER['DOCUMENT_ROOT'].$_SESSION['abs_path'].'/projects';
                $dir  = new DirectoryIterator($path);
                foreach ($dir as $fileinfo) {
                    if ($fileinfo->isDir() && !$fileinfo->isDot()) {
                        $dirName = $fileinfo->getFilename();
                        echo "\n\t\t\t\t<li><a href=\"".$_SESSION['abs_path']."/projects/".$dirName."\">".$dirName."</a></li>\n\t\t\t";
                    }
                }
            ?></ul>
        </li>
        <li><a href=<?php echo $_SESSION['abs_path']."/contact.php"; ?>>Kontakt</a></li>
        <li><?php
            if(isset($_SESSION['logged']) && ($_SESSION['logged'] == true)) {
                echo '<a href="logout.php">Wyloguj</a>';
            } else {
                echo '<a href="login.php">Zaloguj</a>';
            }
        ?></li>
    <ol>
</div>