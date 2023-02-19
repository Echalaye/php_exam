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

<!-- bout de code qui fait office de bandeau -->
<div>
<a href="index.php" role="button">Home</a>
<a href="sell.php" role="button">Vente</a>
<a href="cart.php" role="button">Cart</a>
<a href="disconnect.php" role="button">Disconnect</a>
</div>

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

<!-- formulaire pour ajouter la quantité que l'on veux d'argent a notre solde -->
<form action="addMoneyToSolde.php?id=<?php echo $accountId; ?>" method="post">
    <input type="number" name="moneyToAdd" placeholder="Select how many you want to add">
    <input type="submit" name="submit">
</form>