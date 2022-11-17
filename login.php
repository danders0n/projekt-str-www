<?php
    include 'components/header.php';
    include 'components/nav.php';
	//ada tu byla
?>
<div class="content">
    <div class="login">
        <form action="submitLogin.php" method="post">
            Login:
            <input type="text" name="username" id="username" required>
            <br><br>
            Hasło:
            <input type="password" name="password" id="password" required>
            <br><br>
            <input type="submit" value="Zaloguj się">
        </form>
    </div>
</div>
<?php include 'components/footer.php'; ?>