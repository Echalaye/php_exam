<!-- <html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>
<link rel="stylesheet" type="text/css" href="account.css">

</head>

<body>
     -->

<?php
$mysqli = new mysqli("localhost", "root", "", "php_exam_db");
if(isset($_COOKIE["pwd"])){
    $cookpass = $_COOKIE["pwd"];
    $trypwd = $mysqli->query("SELECT `mdp` FROM user WHERE `mdp` = '$cookpass'");
    if($trypwd->num_rows == 0){
        header("Location: http://localhost/php_exam/indexGuest.php");
    }else{
        $accountInfo = $mysqli->query("SELECT * FROM user WHERE `mdp` = '$cookpass'");
    }
}else{
    header("Location: http://localhost/php_exam/indexGuest.php");
}
?>
<!-- bout de code qui fait office de bandeau -->
<div>
<a href="index.php" role="button">Home</a>
<a href="sell.php" role="button">Vente</a>
<a href="cart.php" role="button">Cart</a>
<a href="disconnect.php" role="button">Disconnect</a>
</div>
<!-- zone d''accès a notre compte -->
<?php
if(isset($_GET["name"])){
    $nameTargetAccount = $_GET["name"];
    $pwdCompte = $mysqli->query("SELECT mdp FROM user WHERE username = '$nameTargetAccount'");
    $pwdCompte = $pwdCompte->fetch_assoc();
    if($pwdCompte["mdp"] == $cookpass){
        $accountInfo = $mysqli->query("SELECT * FROM user WHERE mdp = '$cookpass'");
        $accountId = $accountInfo->fetch_assoc();
        $id = $accountId["id"];
        ?>
        <!-- affiche le nom et la pdp de l'utilisateur -->
        <div>
            <p><?php echo $accountId["username"]?></p>
            <img src="<?php echo $accountId["pdp"]?>" width="5%" height="10%" alt="No_pdp">
        </div>

        <!-- bouton qui affiche le solde actuel du compte et permet d'aller sur la page pour l'augmenter -->
        <a href="addMoneyToSolde.php?id=<?php echo $id; ?>">
            <p><?php echo $accountId["solde"], "€"?> augmenter votre solde</p>

        </a>

        <!-- bouton pour changer les info du compte -->
        <a href="changeUserInfo.php?name=<?php echo $accountId["username"]; ?>">
            <p>change your password</p>
            <p>change your email</p>
            <p>change your profile picture</p>
        </a>

        <!-- bouton pour aller sur la page ou on peux voir nos facture -->
        <a href="myInvoice.php?id=<?php echo $id; ?>">
            <p>Voir mes facture</p>
        </a>

        <!-- bout de code pour voir chaqu'un de nos article -->
        <?php
        $infoArticles = $mysqli->query("SELECT * FROM article WHERE idAuteur = '$id' ORDER BY datePublie DESC");
        $infoUser = $mysqli->query("SELECT username, pdp  FROM user WHERE id = '$id' ");
        $infoUser = $infoUser->fetch_assoc();
        while ($infoArticle = $infoArticles->fetch_assoc()) {
            ?>
            <!-- div pour afficher le nom et la pdp de celui qui a mit en ligne la photo -->
            <div>
                <p><?php echo $infoUser["username"]?></p>
                <img src="<?php echo $infoUser["pdp"]?>" width="3%" height="5%" alt="No_pdp">
            </div>

            <!-- zone qui affiche le nom, le prix et l'image de l'article et permet d'aller sur le détail de l'article -->
            <a href="detail.php?id=<?php echo $infoArticle['id']; ?>&name=<?php echo $infoArticle['name']; ?>">
            <h3><?php echo $infoArticle['name']; ?></h3>
            <p><?php echo $infoArticle['prix'], "€"; ?></p>
            <img src="<?php echo $infoArticle['img'];?>" width="20%" height="20%"  alt="No_image">
            </a>
            <?php
        }
        ?>
        <!-- zone d''accès a un compte qui n'est pas le notre -->
<?Php 
   
    }else{
      
        $accountInfo = $mysqli->query("SELECT * FROM user WHERE username = '$nameTargetAccount'");
        $accountId = $accountInfo->fetch_assoc();  
?>
        <!-- affiche le nom du compte que l'on regarde -->
        <div>
            <p><?php echo $accountId["username"]?></p>
            <img src="<?php echo $accountId["pdp"]?>" width="3%" height="5%" alt="No_pdp">
        </div>

        <!-- bout de code pour voir tout les article du compte ciblé -->
        <?php
        $id = $accountId['id'];
        $infoArticles = $mysqli->query("SELECT * FROM article WHERE idAuteur = '$id' ORDER BY datePublie DESC");
        $infoUser = $mysqli->query("SELECT username, pdp  FROM user WHERE id = '$id' ");
        $infoUser = $infoUser->fetch_assoc();
        while ($infoArticle = $infoArticles->fetch_assoc()) {
            ?>
            <!-- affiche la pdp et le nom de l'utilisateur qui a posté cette article -->
            <div>
                <p><?php echo $infoUser["username"]?></p>
                <img src="<?php echo $infoUser["pdp"]?>" width="5%" height="10%" alt="No_pdp">
            </div>

            <!-- affiche le nom la photo et le prix de l'article et permet d'acceder a la page détail de l'article si on clique dessus -->
            <a href="detail.php?id=<?php echo $infoArticle['id']; ?>&name=<?php echo $infoArticle['name']; ?>">
            <h3><?php echo $infoArticle['name']; ?></h3>
            <p><?php echo $infoArticle['prix'], "€"; ?></p>
            <img src="<?php echo $infoArticle['img'];?>" width="20%" height="20%"  alt="No_image">
            </a>
            <?php
        }
        ?>
<?php
    }
}else{
    header("Location: http://localhost/php_exam/index.php");
}
?>


<!-- 
</body>

</html> -->