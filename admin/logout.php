<?php

$_SESSION['band-o-rama-admin'] = null;
setcookie ('band-o-rama-admin', false);

header ('Location: index.php');
exit;

?>