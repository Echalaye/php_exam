
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
$hello = "World";
?>

<a href="account.php?username=<?php echo $userConnected['username']; ?>"> 
<a><?php echo $userConnected["username"]?></a>
<br>
<img src="<?php echo $userConnected["pdp"]?>" width="5%" height="10%" alt="No_pdp">
<a>
<a href="sell.php" role="button">Vente</a>
<a href="disconnect.php" role="button">Disconnect</a>

<?php
$infoArticles = $mysqli->query("SELECT * FROM article ORDER BY datePublie DESC");
while ($infoArticle = $infoArticles->fetch_assoc()) {
    ?>
    <a href="detail.php?id=<?php echo $infoArticle['id']; ?>&name=<?php echo $infoArticle['name']; ?>">
      <h3><?php echo $infoArticle['name']; ?></h3>
      <img src="<?php echo $infoArticle['img'];?>" width="20%" height="20%"  alt="No_image">
    </a>
    <?php
}
?>



