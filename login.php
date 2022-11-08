<?php
    include 'common/header.php';
    include 'common/nav.php';
?>
<div class="content">
    <div class="login" style="margin: auto; width: 512px; height: 256px; border: 1px solid;">
        <h2>Login</h2>
        <form>
            <input type="text" name="username" id="username" required>
            <input type="password" name="password" id="password" required>
            <input type="submit" value="Login">
        </form>
    </div>
</div>
<?php include 'common/footer.php'; ?>