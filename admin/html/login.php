<?php require_once ('html/header.php'); ?>

<h2>Log In</h2>

<form method="post" action="index.php">

<?php echo (! empty ($_POST['username'])) ? '<p>Invalid username or password. Please try again.' : ''; ?>

<p>Username:<br />
<input type="text" name="username" value="<?php echo $_POST['username']; ?>" /></p>

<p>Password:<br />
<input type="password" name="password" value="<?php echo $_POST['password']; ?>" /></p>

<p><input type="submit" value="Enter" /></p>

</form>

<p><a href="../">Visit your mobile site</a></p>

<?php require_once ('html/footer.php'); ?>