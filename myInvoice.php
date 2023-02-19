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
<!-- bout de code qui fait office de bandeau -->
<div>
<a href="index.php" role="button">Home</a>
<a href="sell.php" role="button">Vente</a>
<a href="cart.php" role="button">Cart</a>
<a href="disconnect.php" role="button">Disconnect</a>
</div>
<!-- bout de code qui liste toutes nos factures -->
<?php
if(isset($_GET['id'])){
    $accountId = $_GET['id'];
    $infoInvoices = $mysqli->query("SELECT * FROM invoice WHERE idUser = '$accountId' ORDER BY dateTransaction DESC");
    ?>
    <!-- affiche le nombre de facture que l'on possède -->
    <p>You have <?php echo $infoInvoices->num_rows?> Invoices.</p>
    <?php
    while ($infoInvoice = $infoInvoices->fetch_assoc()) {
        ?>
        <!-- affiche chaque information de la facture date d'achat, adresse et prix -->
        <p><?php echo $infoInvoice['dateTransaction']; ?></p>
        <p><?php echo $infoInvoice['price'], "€"; ?></p>
        <p><?php echo $infoInvoice['addInvoice'], " ", $infoInvoice['villeInvoice'], " ", $infoInvoice['postaleInvoice'];?></p>
        <?php
    }
}

?>