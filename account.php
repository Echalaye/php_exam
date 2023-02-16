<?php
$mysqli = new mysqli("localhost", "root", "", "php_exam_db");
if(isset($_COOKIE["pwd"])){
    $cookpass = $_COOKIE["pwd"];
    $trypwd = $mysqli->query("SELECT `mdp` FROM user WHERE `mdp` = '$cookpass'");
    if($trypwd->num_rows == 0){
        header("Location: http://localhost/php_exam/indexGuest.php");
    }else{
        $accountInfo = $mysqli->query("SELECT * FROM user WHERE `mdp` = '$cookpass'");
    }
}else{
    header("Location: http://localhost/php_exam/indexGuest.php");
}
?>

<?php
if(isset($_GET["username"])){
    $nameTargetAccount = $_GET["username"];
    $pwdCompte = $mysqli->query("SELECT mdp FROM user WHERE username = '$nameTargetAccount'");
    if($pwdCompte->fetch_assoc() == $cookpass){
        $accountInfo = $mysqli->query("SELECT * FROM user WHERE mdp = $cookpass");
        $accountId = $accountInfo->fetch_assoc();
        $id = $accountId["id"];
        $articleInfo = $mysqli->query("SELECT * FROM article WHERE idAuteur = '$id'");
        $accountInvoice = $mysqli->query("SELECT * FROM invoice WHERE idUser = '$id'");
    }
}