
<!-- bout de code qui fait office de bandeau -->
<div>
<a href="indexGuest.php" role="button">Home</a>
<a href="login.php" role="button">Login / Register</a>
</div>


<!-- affiche le nom et la pdp de l'utilisateur qui vend l'article -->
<div >
    <a href="login.php">
        <p><?php echo $infoUser["username"]?></p>
        <img src="<?php echo $infoUser["pdp"]?>" width="3%" height="5%" alt="No_pdp">
    </a>
</div>
<!-- affiche les information de l'article prix nom, description, date publication et image -->
<div>
    <p><?php echo $infoArticle['name']; ?></p>
    <p><?php echo $infoArticle['prix'], "€"; ?></p>
    <img src="<?php echo $infoArticle['img'];?>" width="40%" height="40%"  alt="No_image">
    <p><?php echo $infoArticle['description']; ?></p>
    <p><?php echo $infoArticle['datePublie'];?></p>
</div>  

