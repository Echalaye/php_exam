<?php 
    $mysqli = new mysqli("localhost", "root", "", "php_exam_db");
    $error = "";
    if(isset($_POST["addEmail"])){
        if(isset($_POST["submit"])){


            $target_dir = "pdpUser/";
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
        $name = $_POST["userName"];;
        $addmail = $_POST["addEmail"];
        $pwd =  $_POST["motDePasse"];
        $result = $mysqli->query("SELECT mdp FROM user WHERE username = '$name'");
        if($result->num_rows == 0){
            $result =  $mysqli->query("SELECT mdp FROM user WHERE adresseMail = '$addmail'");
            if($result->num_rows == 0){
                $pwd = password_hash($pwd, PASSWORD_BCRYPT);
                $mysqli->query("INSERT INTO user(`username`, `mdp`, `adresseMail`,`solde`, pdp, `role`) VALUES ('$name', '$pwd', '$addmail', 0, '$pathIMG','basiqueUser')");
                $cookie_name = "pwd";
                $cookie_value = $pwd;
                setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "index.php");
                header("Location: http://localhost/php_exam/");
            }else{
                $error = "This mail adress already exist";
            }
        }else{
            $error = "This username already exist";
        }
    }
?>
<html>
<body>
    <a href="login.php" role="button">login</a>
    <?php echo $error ?>
    <form action="register.php" method="post" enctype="multipart/form-data">
        <input type="file" name="fileToUpload" id="fileToUpload" required>
        <input type="text" name="userName" placeholder="Enter your name." required>
        <input type="text" name="addEmail" placeholder="Enter your email." required>
        <input type="text" name="motDePasse" placeholder="Enter your password." required>
        <input type="submit" name="submit">
    </form>
</body>
</hmtl>