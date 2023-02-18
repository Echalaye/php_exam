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
    $accountId = $_GET['id'];
    $infoInvoices = $mysqli->query("SELECT * FROM invoice WHERE idUser = '$accountId' ORDER BY dateTransaction DESC");
    ?>
    <p>You have <?php echo $infoInvoices->num_rows?> Invoices.</p>
    <?php
    while ($infoInvoice = $infoInvoices->fetch_assoc()) {
        ?>
        <p><?php echo $infoInvoice['dateTransaction']; ?></p>
        <p><?php echo $infoInvoice['price'], "€"; ?></p>
        <p><?php echo $infoInvoice['addInvoice'], " ", $infoInvoice['villeInvoice'], " ", $infoInvoice['postaleInvoice'];?></p>
        <?php
    }
}

?>