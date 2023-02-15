
<?php
$mysqli = new mysqli("localhost", "root", "", "php_exam_db"); // Connexion à la db "php_exam"
// si vous avez une erreur ici, remplacez le deuxième "root" par une string vide
$result = $mysqli->query("SELECT name FROM article"); // On utilise l'instance créée pour faire une requête bidon
$hello = "World";
?>
<h1>Hello <?php echo $hello ?> !</h1> 
<h2>Guest</h2>
<a href="login.php" role="button">Login / Register</a>