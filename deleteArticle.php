<?php
$mysqli = new mysqli("localhost", "root", "", "php_exam_db");
if(isset($_COOKIE["pwd"])){
    $cookpass = $_COOKIE["pwd"];
    $trypwd = $mysqli->query("SELECT `mdp` FROM user WHERE `mdp` = '$cookpass'");
    if($trypwd->num_rows == 0){
        header("Location: http://localhost/php_exam/indexGuest.php");
    }else{
        $accountInfo = $mysqli->query("SELECT * FROM user WHERE `mdp` = '$cookpass'");
        $accountInfo = $accountInfo->fetch_assoc();
    }
}else{
    header("Location: http://localhost/php_exam/indexGuest.php");
}
?>
<?php
if(isset($_GET['id'])){
    $idArt = $_GET['id'];
    $mysqli->query("DELETE FROM cart WHERE idArticle = '$idArt'");
    $mysqli->query("DELETE FROM stock WHERE idArticle = '$idArt'");
    $mysqli->query("DELETE FROM article WHERE id = '$idArt'");
    header("Location: http://localhost/php_exam/index.php");
}else{
    header("Location: http://localhost/php_exam/index.php");
}