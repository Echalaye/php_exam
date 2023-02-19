
<?php
$mysqli = new mysqli("localhost", "root", "", "php_exam_db"); // Connexion à la db "php_exam"
// si vous avez une erreur ici, remplacez le deuxième "root" par une string vide
$result = $mysqli->query("SELECT name FROM article"); // On utilise l'instance créée pour faire une requête bidon
$hello = "World";
?>
<h2>Guest</h2>
<a href="login.php" role="button">Login / Register</a>

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
    <a href="detailGuest.php?id=<?php echo $infoArticle['id']; ?>">
      <h3><?php echo $infoArticle['name']; ?></h3>
      <p><?php echo $infoArticle['prix'], "€"; ?></p>
      <img src="<?php echo $infoArticle['img'];?>" width="20%" height="20%"  alt="No_image">

    </a>
    <?php
}
?>