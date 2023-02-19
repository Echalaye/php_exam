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

<?php
if(isset($_GET["id"])){
    $artId = $_GET["id"];
    $articleInfo = $mysqli->query("SELECT * FROM article WHERE id = $artId");
    if(isset($_POST['newDesc'])){
        $newDesc = $_POST['newDesc'];
        if($newDesc != ""){
            $mysqli->query("UPDATE article SET description = '$newDesc' WHERE id = '$artId'");
            header("Location: http://localhost/php_exam/index.php");
        }
    }
    if(isset($_POST["newPrice"])){
        $newPrice = $_POST['newPrice'];
        if($newPrice != ""){
            $mysqli->query("UPDATE article SET prix = '$newPrice' WHERE id = '$artId'");
            header("Location: http://localhost/php_exam/index.php");    
        }
}
    if(isset($_FILES["newPics"])){
        $oldPicture = $articleInfo->fetch_assoc();
        unlink($oldPicture["img"]);
        if(isset($_POST["submit"])){


            $target_dir = "pdpUser/";
            $target_file = $target_dir . basename($_FILES["newPics"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            
            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
              $check = getimagesize($_FILES["newPics"]["tmp_name"]);
              if($check !== false) {
                $uploadOk = 1;
              } else {
                echo "File is not an image.";
                $uploadOk = 0;
              }
            }
            
            // Check if file already exists
            if (file_exists($target_file)) {
              echo "Sorry, file already exists.";
              $uploadOk = 0;
            }
            
            // Check file size
            if ($_FILES["newPics"]["size"] > 500000) {
              echo "Sorry, your file is too large.";
              $uploadOk = 0;
            }
            
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
              echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
              $uploadOk = 0;
            }
            
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
              echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
              if (move_uploaded_file($_FILES["newPics"]["tmp_name"], $target_file)) {
                $pathIMG = $target_dir . htmlspecialchars( basename( $_FILES["newPics"]["name"]));
              } else {
                echo "Sorry, there was an error uploading your file.";
              }
            }
        }
        $mysqli->query("UPDATE article SET img = '$pathIMG' WHERE id = '$artId'");
        header("Location: http://localhost/php_exam/index.php"); 
    }

}else{
    header("Location: http://localhost/php_exam/index.php");
}
?>
<!-- formulaire pour modifier l'article que l'on vend, on peux changer chaque chose indépendament des autres -->
<html>
<body>
    <form action="edit.php?id=<?php echo $artId; ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="newPics" id="Upload new Files">
        <input type="text" name="newDesc" placeholder="Enter a new Description.">
        <input type="number" name="newPrice" placeholder="Choose a new price.">
        <input type="submit" name="submit">
    </form>
</body>
</hmtl>