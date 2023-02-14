<?php 
    $mysqli = new mysqli("localhost", "root", "", "php_exam_db");
    $error = "";
    if(isset($_POST["addEmail"])){
        $name = $_POST["userName"];;
        $addmail = $_POST["addEmail"];
        $pwd =  $_POST["motDePasse"];
        $result = $mysqli->query("SELECT mdp FROM user WHERE username = '$name'");
        if($result->num_rows == 0){
            $result =  $mysqli->query("SELECT mdp FROM user WHERE username = '$addmail'");
            if($result->num_rows == 0){
                $mysqli->query("INSERT INTO user(`username`, `mdp`, `adresseMail`,`solde`,`role`) VALUES ('$name', '$pwd', '$addmail', 0, 'basiqueUser')");
                $cookie_name = "pwd";
                $cookie_value = $pwd;
                setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
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
    <form action="register.php" method="post">
        <input type="text" name="userName" placeholder="Enter your name." required>
        <input type="text" name="addEmail" placeholder="Enter your email." required>
        <input type="text" name="motDePasse" placeholder="Enter your password." required>
        <input type="submit" href="register.php">
    </form>
</body>
</hmtl>