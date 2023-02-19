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
// $nameUser = $userConnected["username"];
// if( $nameUser == "admin"){
//     header("Location: http://localhost/php_exam/index.php");
// }
?>

<?php
if(isset($_GET['name'])){
    $name = $_GET['name'];
    $userId = $mysqli->query("SELECT id FROM user WHERE username = '$name'");
    $userId = $userId->fetch_assoc();
    $userId = $userId['id'];
    $mysqli->query("DELETE FROM cart WHERE idUser = '$userId'");
    $mysqli->query("DELETE FROM invoice WHERE idUser = '$userId'"); 
    $ArticlesUser = $mysqli->query("SELECT id FROM article WHERE idAuteur = '$userId'");
    while($ArticleUser = $ArticlesUser->fetch_assoc()){
        $id = $ArticlesUser['id'];
        $mysqli->query("DELETE FROM stock WHERE idArticle = '$id");
        $mysqli->query("DELETE FROM article WHERE id = '$id'");
    }
    $mysqli->query("DELETE FROM user WHERE id = '$userId'");
    header("Location: http://localhost/php_exam/tabUserAdmin.php");
}else{
    header("Location: http://localhost/php_exam/index.php");
}