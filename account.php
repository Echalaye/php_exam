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

<?php
if(isset($_GET["name"])){
    $nameTargetAccount = $_GET["name"];
    $pwdCompte = $mysqli->query("SELECT mdp FROM user WHERE username = '$nameTargetAccount'");
    $pwdCompte = $pwdCompte->fetch_assoc();
    if($pwdCompte["mdp"] == $cookpass){
        $accountInfo = $mysqli->query("SELECT * FROM user WHERE mdp = '$cookpass'");
        $accountId = $accountInfo->fetch_assoc();
        $id = $accountId["id"];
        // $accountInvoice = $mysqli->query("SELECT * FROM invoice WHERE idUser = '$id'");
        ?>
        <div>
            <p><?php echo $accountId["username"]?></p>
            <img src="<?php echo $accountId["pdp"]?>" width="5%" height="10%" alt="No_pdp">
        </div>

        <a href="addMoneyToSolde.php?id=<?php echo $id; ?>">
            <p><?php echo $accountId["solde"], "€"?> augmenter votre solde</p>

        </a>

        <a href="changeUserInfo.php?id=<?php echo $id; ?>">
            <p>change your password</p>
            <p>change your email</p>
            <p>change your profile picture</p>
        </a>

        <a href="myInvoice.php?id=<?php echo $id; ?>">
            <p>Voir mes facture</p>
        </a>

        <?php
        $infoArticles = $mysqli->query("SELECT * FROM article WHERE idAuteur = '$id' ORDER BY datePublie DESC");
        $infoUser = $mysqli->query("SELECT username, pdp  FROM user WHERE id = '$id' ");
        $infoUser = $infoUser->fetch_assoc();
        while ($infoArticle = $infoArticles->fetch_assoc()) {
            ?>
            <div>
                <p><?php echo $infoUser["username"]?></p>
                <img src="<?php echo $infoUser["pdp"]?>" width="3%" height="5%" alt="No_pdp">
            </div>
            <a href="detail.php?id=<?php echo $infoArticle['id']; ?>&name=<?php echo $infoArticle['name']; ?>">
            <h3><?php echo $infoArticle['name']; ?></h3>
            <p><?php echo $infoArticle['prix'], "€"; ?></p>
            <img src="<?php echo $infoArticle['img'];?>" width="20%" height="20%"  alt="No_image">
            </a>
            <?php
        }
        ?>
<?Php    
    }else{
      
        $accountInfo = $mysqli->query("SELECT * FROM user WHERE username = '$nameTargetAccount'");
        $accountId = $accountInfo->fetch_assoc();  
?>
        <div>
            <p><?php echo $accountId["username"]?></p>
            <img src="<?php echo $accountId["pdp"]?>" width="3%" height="5%" alt="No_pdp">
        </div>

        <?php
        $id = $accountId['id'];
        $infoArticles = $mysqli->query("SELECT * FROM article WHERE idAuteur = '$id' ORDER BY datePublie DESC");
        $infoUser = $mysqli->query("SELECT username, pdp  FROM user WHERE id = '$id' ");
        $infoUser = $infoUser->fetch_assoc();
        while ($infoArticle = $infoArticles->fetch_assoc()) {
            ?>
            <div>
                <p><?php echo $infoUser["username"]?></p>
                <img src="<?php echo $infoUser["pdp"]?>" width="5%" height="10%" alt="No_pdp">
            </div>
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
}
?>