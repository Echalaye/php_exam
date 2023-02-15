<?php
$test = "nique";
$test2 = "ta mère";
if(isset($_GET["id"])){
    $test = $_GET["id"];
    $test2 = $_GET["name"];
}

?>
<h1><?php echo $test?></h1>
<h2><?php echo $test2?></h2>