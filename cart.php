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
if(isset($_GET['idArt'])){
    if(isset($_GET['add1'])){
        $idArtCart = $_GET['idArt'];
        $quantity = $mysqli->query("SELECT stock FROM stock WHERE idArticle = '$idArtCart'");
        $quantity = $quantity->fetch_assoc();
        $quantity = $quantity['stock'];
        $UserID = $accountInfo['id'];
        $ArticleCart = $mysqli->query("SELECT quantity FROM cart WHERE idUser = '$UserID' AND idArticle = '$idArtCart'");
        $newQuant = $ArticleCart->fetch_assoc();
        $newQuant = $newQuant['quantity'];
        if($newQuant + 1 <= $quantity){
            $newQuant += 1;
            $mysqli->query("UPDATE cart SET quantity = '$newQuant' WHERE idUser = '$UserID' AND idArticle = '$idArtCart'");
        }
    }elseif(isset($_GET['less1'])){
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
    }elseif(isset($_GET['delete'])){
        $idArtCart = $_GET['idArt'];
        $UserID = $accountInfo['id'];
        $mysqli->query("DELETE FROM cart WHERE idUser = '$UserID' AND idArticle = '$idArtCart'");
    }
}
?>
<!-- bout de code qui fait office de bandeau -->
<div>
<a href="index.php" role="button">Home</a>
<a href="sell.php" role="button">Vente</a>
<a href="disconnect.php" role="button">Disconnect</a>
</div>

<!-- bouton pour valider l'achat -->
<a href="validate.php">
    <p>Buy</p>
</a>

<!--  partie qui gère l'affichage de chaque article de notre panier -->
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
                <!-- partie qui affiche le nom et la photo de profil du user qui a publié l'article -->
                <a href="account.php?name=<?php echo $infoUser['username']; ?>">
                    <p><?php echo $infoUser["username"]?></p>
                    <img src="<?php echo $infoUser["pdp"]?>" width="1.5%" height="3%" alt="No_pdp">
                </a>
            <!-- partie qui affiche l'article son nom son image et son prix -->
            <a href="detail.php?id=<?php echo $infoArticle['id']; ?>">
            <h3><?php echo $infoArticle['name']; ?></h3>
            <p><?php echo $infoArticle['prix'], "€"; ?></p>
            <img src="<?php echo $infoArticle['img'];?>" width="10%" height="10%"  alt="No_image">
            </a>
            <!-- bouton pour augmenter la quantité d'article acheter de cette article -->
            <a href="cart.php?add1=1&idArt=<?php echo $infoArticle['id']; ?>">
                <p>more</p>
            </a>

            <!-- affichage de la quantité que l'on va acheter de cette article -->
            <p><?php echo $ArticleCart['quantity']?></p>

            <!-- bouton pour augmenter la quantité d'article acheter de cette article -->
            <a href="cart.php?less1=1&idArt=<?php echo $infoArticle['id']; ?>">
                <p>less</p>
            </a>

            <!-- supprimer l'article de notre panier -->
            <a href="cart.php?delete=1&idArt=<?php echo $infoArticle['id']; ?>">
                <p>Delete</p>
            </a>

        </div>
        <?php
        }
    }
?>

<!-- affichage du total que l'on va payer et de combien on a sur notre compte -->
<p>Total : <?php echo $moneyTot?>€</p>
<p>You have <?php echo $accountInfo["solde"]?>€ on your account</p>
