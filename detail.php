<?php
$mysqli = new mysqli("localhost", "root", "", "php_exam_db");
if(isset($_COOKIE["pwd"])){
    $cookpass = $_COOKIE["pwd"];
    $trypwd = $mysqli->query("SELECT `mdp` FROM user WHERE `mdp` = '$cookpass'");
    if($trypwd->num_rows == 0){
        header("Location: http://localhost/php_exam/detailGuest.php");
    }else{
        $accountInfo = $mysqli->query("SELECT * FROM user WHERE `mdp` = '$cookpass'");
        $accountInfo = $accountInfo->fetch_assoc();
    }
}else{
    header("Location: http://localhost/php_exam/detailGuest.php");
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
    $articleId = $_GET["id"];
    $infoArticle = $mysqli->query("SELECT * FROM article WHERE id = '$articleId'");
    $infoArticle = $infoArticle->fetch_assoc();
    $id = $infoArticle["idAuteur"];
    $infoUser = $mysqli->query("SELECT username, pdp  FROM user WHERE id = '$id' ");
    $infoUser = $infoUser->fetch_assoc();
    if($accountInfo['id'] == $id){
    ?>
    <!-- bouton afficher dans le cas ou on est sur notre propre article permet de le modifié ou le suprimer -->
    <a href="edit.php?id=<?php echo $infoArticle['id']; ?>">
        <p>Edit Article</p>
    </a>   
    <a href="deleteArticle.php?id=<?php echo $infoArticle['id']; ?>">
        <p>Delete Article</p>
    </a>   
<?php
    }else{
    ?>
    <!-- bouton afficher dans le cas ou on est sur un article que l'on ne vend pas et dans ce cas on peux l'ajouter au panier -->
    <a href="addToCart.php?id=<?php echo $infoArticle['id']; ?>">
        <p>Add to cart</p>
    </a>
    <?php
    }
    ?>
    <!-- affiche le nom et la pdp de l'utilisateur qui vend l'article -->
    <div >
        <a href="account.php?name=<?php echo $infoUser['username']; ?>">
            <p><?php echo $infoUser["username"]?></p>
            <img src="<?php echo $infoUser["pdp"]?>" width="3%" height="5%" alt="No_pdp">
        </a>
    </div>
    <!-- affiche les information de l'article prix nom, description, date publication et image -->
    <div>
        <p><?php echo $infoArticle['name']; ?></p>
        <p><?php echo $infoArticle['prix'], "€"; ?></p>
        <img src="<?php echo $infoArticle['img'];?>" width="40%" height="40%"  alt="No_image">
        <p><?php echo $infoArticle['description']; ?></p>
        <p><?php echo $infoArticle['datePublie'];?></p>
    </div>  
    <?php
}else{
    header("Location: http://localhost/php_exam/index.php");
}

?>
