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
if(isset($_GET["id"])){
    $articleId = $_GET["id"];
    $infoArticle = $mysqli->query("SELECT * FROM article WHERE id = '$articleId'");
    $infoArticle = $infoArticle->fetch_assoc();
    $id = $infoArticle["idAuteur"];
    $infoUser = $mysqli->query("SELECT username, pdp  FROM user WHERE id = '$id' ");
    $infoUser = $infoUser->fetch_assoc();
    if($accountInfo['id'] == $id){
    ?>
    <a href="edit.php?id=<?php echo $infoArticle['id']; ?>">
        <p>Edit Article</p>
    </a>   
    <a href="deleteArticle.php?id=<?php echo $infoArticle['id']; ?>">
        <p>Delete Article</p>
    </a>   
<?php
    }else{
    ?>
    <a href="addToCart.php?id=<?php echo $infoArticle['id']; ?>">
        <p>Add to cart</p>
    </a>
    <?php
    }
    ?>
    <div >
        <a href="account.php?name=<?php echo $infoUser['username']; ?>">
            <p><?php echo $infoUser["username"]?></p>
            <img src="<?php echo $infoUser["pdp"]?>" width="3%" height="5%" alt="No_pdp">
        </a>
    </div>
    <div>
        <p><?php echo $infoArticle['name']; ?></p>
        <p><?php echo $infoArticle['prix'], "€"; ?></p>
        <img src="<?php echo $infoArticle['img'];?>" width="20%" height="20%"  alt="No_image">
        <p><?php echo $infoArticle['description']; ?></p>
        <p><?php echo $infoArticle['datePublie'];?></p>
    </div>  
    <?php
}else{
    header("Location: http://localhost/php_exam/index.php");
}

?>
