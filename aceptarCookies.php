<?php
setcookie("cookies_aceptadas", "1", time() + 10, "/");
header("Location: mainPage.php");
exit;
?>
