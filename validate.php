<?php
$mysqli = new mysqli("localhost", "root", "", "php_exam_db"); // Connexion à la db "php_exam"
// si vous avez une erreur ici, remplacez le deuxième "root" par une string vide
if(isset($_COOKIE["pwd"])){
    $cookpass = $_COOKIE["pwd"];
    $trypwd = $mysqli->query("SELECT `mdp` FROM user WHERE `mdp` = '$cookpass'");
    if($trypwd->num_rows == 0){
        header("Location: http://localhost/php_exam/indexGuest.php");
    }
}else{
    header("Location: http://localhost/php_exam/indexGuest.php");
}
$UserAccount = $mysqli->query("SELECT * FROM user WHERE mdp = '$cookpass'");
$userConnected = $UserAccount->fetch_assoc();
?>

<?php
if(isset($_POST['city'])){
    $userId = $userConnected['id'];
    $myMoney = $userConnected["solde"];
    $totBuy = 0;
    $AllinfoMyCart = $mysqli->query("SELECT * FROM cart WHERE idUser = '$userId' ");
    while ($infoMyCart = $AllinfoMyCart->fetch_assoc()) {
        $idArticle = $infoMyCart['idArticle'];
        $infoArticle = $mysqli->query("SELECT * FROM article WHERE id = '$idArticle'");
        $infoArticle = $infoArticle->fetch_assoc();
        $totBuy += $infoArticle['prix'] * $infoMyCart['quantity'];
        $stockOfArt = $mysqli->query("SELECT stock FROM stock WHERE idArticle = '$idArticle'");
        $stockOfArt= $stockOfArt->fetch_assoc();
        $stockOfArt = $stockOfArt['stock'];
        if($stockOfArt - 1 > 0){
            $newStock = $stockOfArt - 1;
            $mysqli->query("UPDATE stock SET stock='$newStock' WHERE idArticle='$idArticle'");
        }else{
            $mysqli->query("DELETE FROM cart WHERE idUser = '$userId'");
            $mysqli->query("DELETE FROM stock WHERE idArticle = '$idArticle'");
            $mysqli->query("DELETE FROM article WHERE id = '$idArticle'");
        }

    }
    $mysqli->query("DELETE FROM cart WHERE idUser = '$userId'");
    $newSolde = $myMoney - $totBuy;
    $mysqli->query("UPDATE user SET solde ='$newSolde' WHERE id = '$userId'");
    $city = $_POST['city'];
    $postal = $_POST['postalCode'];
    $address = $_POST['address'];
    $date = date('d/m/Y h:i:s', time());
    $mysqli->query("INSERT INTO invoice(`idUser`,`dateTransaction` ,`price` ,`addInvoice` ,`villeInvoice` ,`postaleInvoice`) VALUES ('$userId', '$date', '$totBuy','$address','$city','$postal')");
    header("Location: http://localhost/php_exam/index.php");
}

?>

<form action="validate.php" method="post">
        <input type="text" name="address" placeholder="Enter your address." required>
        <input type="text" name="city" placeholder="Enter your city." required>
        <input type="number" name="postalCode" placeholder="Select your postal code." required>
        <input type="submit" name="submit">
</form>