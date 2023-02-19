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
<a href="cart.php" role="button">Cart</a>
<a href="disconnect.php" role="button">Disconnect</a>
</div>

<?php
    $mysqli = new mysqli("localhost", "root", "", "php_exam_db");

    if(isset($_POST["Nameart"])){
        if(isset($_POST["submit"])){


            $target_dir = "imageUser/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            
            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
              $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
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
              header("Location: http://localhost/php_exam/sell.php");
              $uploadOk = 0;
            }
            
            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000) {
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
              if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $pathIMG = $target_dir . htmlspecialchars( basename( $_FILES["fileToUpload"]["name"]));
              } else {
                echo "Sorry, there was an error uploading your file.";
              }
            }
            }
        $nameart = $_POST["Nameart"];
        $desc = $_POST["Description"];
        $price = $_POST["Price"];
        $stk = $_POST["Stock"];
        $date = date('d/m/Y h:i:s', time());
        $price = floatval($price);
        $cookieValue = $_COOKIE["pwd"];
        $Infouser = $mysqli->query("SELECT id FROM user WHERE `mdp` = '$cookieValue'");
        $userId = $Infouser->fetch_assoc();
        $userId = $userId["id"];
        $mysqli->query("INSERT INTO article(`name`, `description`, `prix`,`datePublie`, idAuteur, img ) VALUES ('$nameart', '$desc', '$price', '$date', '$userId', '$pathIMG')");
        $ArticleInfo = $mysqli->query("SELECT id FROM article WHERE description = '$desc'AND prix = '$price' AND idAuteur = '$userId'");
        $idart = $ArticleInfo->fetch_assoc();
        $idart = $idart["id"];
        $mysqli->query("INSERT INTO stock(`idArticle`, `stock`) VALUES ('$idart', '$stk')");
        header("Location: http://localhost/php_exam/index.php");
    }else{
        $nameart = "";
        $img = "";
        $price = "";
        $desc = "";
    }
?>

<html>
    <body>
      <!-- formulaire pour publier un article -->
        <form action="sell.php" method="post" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" id="fileToUpload" required>
            <input type="text" name="Nameart" placeholder="Enter the name of your article." required>
            <input type="text" name="Description" placeholder="Enter a description for your article." required>
            <input type="number" name="Price" placeholder="Enter the price of your article." required>
            <input type="number" name="Stock" placeholder="Quantity." required>
            <input type="submit" name="submit">
        </form>
    </body>
</html>

