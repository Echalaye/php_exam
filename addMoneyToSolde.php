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
if(isset($_GET["id"])){
    $accountId = $_GET["id"];
    $infoAccount = $mysqli->query("SELECT * FROM user WHERE id = '$accountId'");
    if(isset($_POST["moneyToAdd"])){
        $actualMoney = $mysqli->query("SELECT solde FROM user WHERE id = '$accountId'");
        $actualMoney = $actualMoney->fetch_assoc();
        $actualMoney = $actualMoney["solde"];
        $totalMoney = $actualMoney + $_POST["moneyToAdd"];
        $mysqli->query("UPDATE user SET solde = '$totalMoney' WHERE id = '$accountId'");
        header("Location: http://localhost/php_exam/account.php");
    }
}else{
    header("Location: http://localhost/php_exam/index.php");
}
?>

<form action="addMoneyToSolde.php?id=<?php echo $accountId; ?>" method="post">
    <input type="number" name="moneyToAdd" placeholder="Select how many you want to add">
    <input type="submit" name="submit">
</form>