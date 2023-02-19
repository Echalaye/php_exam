<?php
$mysqli = new mysqli("localhost", "root", "", "php_exam_db"); // Connexion à la db "php_exam"

if(isset($_GET['id'])){
    $idArt = $_GET['id'];
    $infoArticle = $mysqli->query("SELECT * FROM article WHERE id = '$idArt'");
    $infoArticle = $infoArticle->fetch_assoc();
    $idAuteur = $infoArticle['idAuteur'];
    $userConnected = $mysqli->query("SELECT username, pdp FROM user WHERE id = '$idAuteur'");
    $userConnected = $userConnected->fetch_assoc();
}else{
    header("Location: http://localhost/php_exam/indexGuest.php");
}
?>
<!-- bout de code qui fait office de bandeau -->
<div>
<a href="indexGuest.php" role="button">Home</a>
<a href="login.php" role="button">Login / Register</a>
</div>


<!-- affiche le nom et la pdp de l'utilisateur qui vend l'article -->
<div >
    <a href="login.php">
        <p><?php echo $userConnected["username"]?></p>
        <img src="<?php echo $userConnected["pdp"]?>" width="3%" height="5%" alt="No_pdp">
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

