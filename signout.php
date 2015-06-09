<?php
session_start();
session_unset($_SESSION);
header("Location: http://www.anzzilla.linuxpl.info/news_p5//index.php");
exit();
?>