<?php
$mysqli = new mysqli("localhost", "root", "", "php_exam_db");
if(isset($_COOKIE["pwd"])){
    $cookpass = $_COOKIE["pwd"];
    $trypwd = $mysqli->query("SELECT `mdp` FROM user WHERE `mdp` = '$cookpass'");
    if($trypwd->num_rows == 0){
        header("Location: http://localhost/php_exam/indexGuest.php");
    }else{
        $accountInfo = $mysqli->query("SELECT * FROM user WHERE `mdp` = '$cookpass'");
        $accountInfo = $accountInfo->fetch_assoc();
    }
}else{
    header("Location: http://localhost/php_exam/indexGuest.php");
}
?>

<?php
    if(isset($_GET['id'])){
        $articleId = $_GET['id'];
        $userId = $accountInfo['id'];
        $infoPanier = $mysqli->query("SELECT * FROM cart WHERE idArticle = '$articleId'");
        if($infoPanier->num_rows == 0){
            $mysqli->query("INSERT INTO cart(idUser, idArticle,quantity) VALUES ('$userId','$articleId', 1)");
            header("Location: http://localhost/php_exam/index.php");
        }else{
            echo "You Already have this article in your cart";

            ?>
            <!-- affiche sur l'écran l'erreur avec un bouton pour retourner au menu (erreur = on a déjà l'article dans notre panier) -->
            <a href="index.php">Return to home</a>
            <?php
        }
    }else{
        header("Location: http://localhost/php_exam/index.php");
    }
?>
