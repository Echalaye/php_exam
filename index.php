
<?php
$mysqli = new mysqli("localhost", "root", "", "php_exam_db"); // Connexion à la db "php_exam"
// si vous avez une erreur ici, remplacez le deuxième "root" par une string vide
if(isset($_COOKIE["pwd"])){
    $cookpass = $_COOKIE["pwd"];
    $trypwd = $mysqli->query("SELECT mdp FROM user WHERE mdp = $cookpass");
    if($trypwd->num_rows == 0){
        header("Location: http://localhost/php_exam/");
    }
}
$result = $mysqli->query("SELECT name FROM article"); // On utilise l'instance créée pour faire une requête bidon
$hello = "World";
?>
<h1>Hello <?php echo $hello ?> !</h1> 

<a href="vente.php" role="button">Vente</a>
<a href="disconnect.php" role="button">Disconnect</a>
