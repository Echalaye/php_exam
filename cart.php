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
if(isset($_GET['idArt'])){
    if(isset($_GET['add1'])){
        $idArtCart = $_GET['idArt'];
        $quantity = $mysqli->query("SELECT stock FROM stock WHERE idArticle = '$idArtCart'");
        $quantity = $quantity->fetch_assoc();
        $quantity = $quantity['stock'];
        $accountInfo = $accountInfo->fetch_assoc();
        $UserID = $accountInfo['id'];
        $ArticleCart = $mysqli->query("SELECT quantity FROM cart WHERE idUser = '$UserID' AND idArticle = '$idArtCart'");
        $newQuant = $ArticleCart->fetch_assoc();
        $newQuant = $newQuant['quantity'];
        if($newQuant + 1 <= $quantity){
            $newQuant += 1;
            $mysqli->query("UPDATE cart SET quantity = '$newQuant' WHERE idUser = '$UserID' AND idArticle = '$idArtCart'");
        }
    }elseif(isset($_GET['less1'])){
        $accountInfo = $accountInfo->fetch_assoc();
        $idArtCart = $_GET['idArt'];
        $UserID = $accountInfo['id'];
        $ArticleCart = $mysqli->query("SELECT quantity FROM cart WHERE idUser = '$UserID' AND idArticle = '$idArtCart'");
        $newQuant = $ArticleCart->fetch_assoc();
        $newQuant = $newQuant['quantity'];
        if($newQuant - 1 > 0 ){
            $newQuant -= 1;
            $mysqli->query("UPDATE cart SET quantity = '$newQuant' WHERE idUser = '$UserID' AND idArticle = '$idArtCart'");
        }else{
            $mysqli->query("DELETE FROM cart WHERE idUser = '$UserID' AND idArticle = '$idArtCart'");
        }
    }
}
?>
<a href="validate.php">
    <p>Buy</p>
</a>
<?php
    $UserID = $accountInfo['id'];
    $ArticlesCart = $mysqli->query("SELECT * FROM cart WHERE idUser = '$UserID'");
    $moneyTot = 0;
    while ($ArticleCart = $ArticlesCart->fetch_assoc()) {
        $id = $ArticleCart["idArticle"];
        $infoArticles = $mysqli->query("SELECT * FROM article WHERE id = '$id'");
        while ($infoArticle = $infoArticles->fetch_assoc()) {
            $idArt = $infoArticle["idAuteur"];
            $infoUser = $mysqli->query("SELECT username, pdp  FROM user WHERE id = '$idArt' ");
            $infoUser = $infoUser->fetch_assoc();
            $moneyTot += $infoArticle['prix'];
            ?>
            <div >
                <a href="account.php?name=<?php echo $infoUser['username']; ?>">
                    <p><?php echo $infoUser["username"]?></p>
                    <img src="<?php echo $infoUser["pdp"]?>" width="1.5%" height="3%" alt="No_pdp">
                </a>
            <a href="detail.php?id=<?php echo $infoArticle['id']; ?>">
            <h3><?php echo $infoArticle['name']; ?></h3>
            <p><?php echo $infoArticle['prix'], "€"; ?></p>
            <img src="<?php echo $infoArticle['img'];?>" width="10%" height="10%"  alt="No_image">
            </a>
            <a href="cart.php?add1=1&idArt=<?php echo $infoArticle['id']; ?>">
                <p>more</p>
            </a>
            <p><?php echo $ArticleCart['quantity']?></p>
            <a href="cart.php?less1=1&idArt=<?php echo $infoArticle['id']; ?>">
                <p>less</p>
            </a>
        </div>
        <?php
        }
    }
?>

<p>Total : <?php echo $moneyTot?>€</p>
<p>You have <?php echo $accountInfo["solde"]?>€ on your account</p>
