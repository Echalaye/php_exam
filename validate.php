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
$UserAccount = $mysqli->query("SELECT username, pdp FROM user WHERE mdp = '$cookpass'");
$userConnected = $UserAccount->fetch_assoc();
?>

<?php
    $userId = $userConnected['id'];
    $myMoney = $accountConnected["solde"];
    $totBuy = 0;
    $AllinfoMyCart = $mysqli->query("SELECT * FROM cart WHERE idUser = '$userId' ");
    while ($infoMyCart = $AllinfoMyCart->fetch_assoc()) {
        $idArticle = $infoMyCart['idArticle'];
        $prixArticle = $mysqli->query("SELECT prix FROM article WHERE id = '$idArticle'");
        $prixArticle = $prixArticle->fetch_assoc();
        $totBuy += $prixArticle['prix'] * $infoMyCart['quantity'];
    }
    
?>