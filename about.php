<?php
    session_start(); // wazne, podobno... xdd

    include 'components/header.php';
    include 'components/nav.php';
    if(isset($_SESSION['logged']) && ($_SESSION['logged'] == true)) {
        include 'components\panel.php';
    }
?>
About
<?php include 'components/footer.php'; ?>