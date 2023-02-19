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
?>

<?php
if($userConnected["username"] == "admin"){
    header("Location: http://localhost/php_exam/index.php");
}
?>

<?php
if(isset($_GET['name'])){
    $name = $_GET['name'];
    $userId = $mysqli->query("SELECT id FROM user WHERE username = '$name'");
    $userId = $userId->fetch_assoc();
    $userId = $userId['id'];
    $mysqli->query("DELETE FROM cart WHERE idUser = '$userId'");
    // $ArticleUser = 
}else{
    header("Location: http://localhost/php_exam/index.php");
}