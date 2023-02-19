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
if(isset($_GET["name"])){
    $accountName = $_GET["name"];
    $infoAccount = $mysqli->query("SELECT pdp FROM user WHERE username = '$accountName'");
    if(isset($_POST["newEmail"]) ){
        if($_POST["newEmail"]){
            $newMailAdd = $_POST["newEmail"];
            $result =  $mysqli->query("SELECT mdp FROM user WHERE adresseMail = '$newMailAdd'");
            if($result->num_rows == 0){
                $mysqli->query("UPDATE user SET adresseMail = '$newMailAdd' WHERE username = '$accountName'");
                header("Location: http://localhost/php_exam/index.php");
            }else{
                echo "This email is already used";
            }
        }

    }
    if(isset($_POST["newPass"])){
        if($_POST["newPass"] != ""){
            $newPassword = $_POST["newPass"];
            $newPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $mysqli->query("UPDATE user SET mdp = '$newPassword' WHERE username = '$accountName'");
            $cookie_name = "pwd";
            $cookie_value = $newPassword; 
            setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "index.php");
            header("Location: http://localhost/php_exam/index.php");
        }
    }
    if(isset($_FILES["newPdp"])){
        $oldPicture = $infoAccount->fetch_assoc();
        unlink($oldPicture["pdp"]);
        if(isset($_POST["submit"])){


            $target_dir = "pdpUser/";
            $target_file = $target_dir . basename($_FILES["newPdp"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            
            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
              $check = getimagesize($_FILES["newPdp"]["tmp_name"]);
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
            if ($_FILES["newPdp"]["size"] > 500000) {
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
              if (move_uploaded_file($_FILES["newPdp"]["tmp_name"], $target_file)) {
                $pathIMG = $target_dir . htmlspecialchars( basename( $_FILES["newPdp"]["name"]));
              } else {
                echo "Sorry, there was an error uploading your file.";
              }
            }
        }
        $mysqli->query("UPDATE user SET pdp = '$pathIMG' WHERE username = '$accountName'");
        header("Location: http://localhost/php_exam/index.php");    
    }
}else{
    header("Location: http://localhost/php_exam/index.php");
}
?>
<html>
<body>
  <!-- formulaire pour changer notre pdp ou notre mdp ou notre addmail on peux en changer autant qu'on veux d'un coup il n'est pas obligatoir de tous les changer -->
    <form action="changeUserInfo.php?name=<?php echo $accountInfo["username"]; ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="newPdp" id="fileToUpload">
        <input type="text" name="newEmail" placeholder="Enter your email.">
        <input type="text" name="newPass" placeholder="Enter your password.">
        <input type="submit" name="submit">
    </form>
</body>
</hmtl>