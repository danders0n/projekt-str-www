<div class="nav">
    <ol>
        <li><a href="index.php">Home</a></li>
        <li><a href="#">O nas</a></li>
        <li><a href="#">Projekty</a>
            <ul><?php
                    $path = "projects";
                    $dir = new DirectoryIterator($path);
                    foreach ($dir as $fileinfo) {
                        if ($fileinfo->isDir() && !$fileinfo->isDot()) {
                            echo '<li><a href="#">'.$fileinfo->getFilename().'</a></li>';
                        }
                    }
                ?></ul>
        </li>
        <li><a href="#">Kontakt</a></li>
        <li><a href="login.php">Zaloguj</a></li>
    <ol>
</div>