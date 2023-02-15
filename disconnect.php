<?php
setcookie("pwd", "", time()-3600);
header("Location: http://localhost/php_exam/");
?>