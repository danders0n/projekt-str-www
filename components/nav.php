<div class="nav">
    <ol>
        <li><a href=<?php echo $abs_path."/index.php"; ?>>Home</a></li>
        <li><a href=<?php echo $abs_path."/about.php"; ?>>O nas</a></li>
        <li><a href="#">Projekty</a>
            <ul><?php  
                ?></ul>
        </li>
        <li><a href=<?php echo $abs_path."/contact.php"; ?>>Kontakt</a></li>
        <li><?php
            if(isset($_SESSION['logged']) && ($_SESSION['logged'] == true)) {
                echo '<a href="logout.php">Wyloguj</a>';
            } else {
                echo '<a href="login.php">Zaloguj</a>';
            }
        ?></li>
    <ol>
</div>