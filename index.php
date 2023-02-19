
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

<!-- bout de code qui gère l'affichage de la photo de profil et du nom de l'utilisateur -->
<a href="account.php?name=<?php echo $userConnected['username']; ?>"> 
    <p><?php echo $userConnected["username"]?></p>
    <img src="<?php echo $userConnected["pdp"]?>" width="5%" height="10%" alt="No_pdp">
</a>

<!-- bout de code qui fait office de bandeau -->
<div>
<a href="sell.php" role="button">Vente</a>
<a href="cart.php" role="button">Cart</a>
<a href="disconnect.php" role="button">Disconnect</a>
</div>
<!-- bout de code qui gère l'affichage de chaque article -->
<?php
$infoArticles = $mysqli->query("SELECT * FROM article ORDER BY datePublie DESC");

while ($infoArticle = $infoArticles->fetch_assoc()) {
    $id = $infoArticle["idAuteur"];
    $infoUser = $mysqli->query("SELECT username, pdp  FROM user WHERE id = '$id' ");
    $infoUser = $infoUser->fetch_assoc();
    ?>
    <!-- div qui gère l'affiche du nom et de la photo de profil du user qui a posté l'article -->
    <div >
        <a href="account.php?name=<?php echo $infoUser['username']; ?>">
            <p><?php echo $infoUser["username"]?></p>
            <img src="<?php echo $infoUser["pdp"]?>" width="3%" height="5%" alt="No_pdp">
        </a>
    </div>

    <!-- partie qui gère l'affichage du nom, du prix et de l'image de l'article -->
    <a href="detail.php?id=<?php echo $infoArticle['id']; ?>">
      <h3><?php echo $infoArticle['name']; ?></h3>
      <p><?php echo $infoArticle['prix'], "€"; ?></p>
      <img src="<?php echo $infoArticle['img'];?>" width="20%" height="20%"  alt="No_image">

    </a>
    <?php
}
?>



