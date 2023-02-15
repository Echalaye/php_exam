
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
$infoArticle = $mysqli->query("SELECT * FROM article"); // On utilise l'instance créée pour faire une requête bidon
$infoArticle = $infoArticle->fetch_assoc();
$UserAccount = $mysqli->query("SELECT username FROM user WHERE mdp = '$cookpass'");
$nameConnected = $UserAccount->fetch_assoc();
$hello = "World";
?>
<h1>Hello <?php echo $hello ?> !</h1> 
<a><?php echo $nameConnected["username"]?></a>
<a href="vente.php" role="button">Vente</a>
<a href="disconnect.php" role="button">Disconnect</a>


<a href="detail.php?id=<?php echo $infoArticle['id']; ?>&name=<?php echo $infoArticle['name']; ?>">

  <h3><?php echo $infoArticle['name']; ?></h3>
  <img src="<?php echo $infoArticle['img']; ?>" alt="No_image">


</a>


