<?php 
    $mysqli = new mysqli("localhost", "root", "", "php_exam_db");
    $error = "";
    if(isset($_POST["addEmail"])){
        $addmail = $_POST["addEmail"];
        $result = $mysqli->query("SELECT mdp FROM user WHERE adresseMail = '$addmail'");
        if($result->num_rows != 0){
            $tab = $result->fetch_assoc();
            if(password_verify($_POST["motDePasse"], $tab["mdp"])){
                $cookie_name = "pwd";
                $cookie_value = $tab["mdp"];
                setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "index.php");
                header("Location: http://localhost/php_exam/");
            }else{
                $error = "Wrong Password";
            }
        }else{
            $error = "This email doesn't exist";
        }

    }
?>
<html>
<body>
    <a href="register.php" role="button">Register</a>
    <?php echo $error ?>
    <form action="login.php" method="post">
        <input type="text" name="addEmail" placeholder="Enter your email." required>
        <input type="text" name="motDePasse" placeholder="Enter your password." required>
        <input type="submit" href="login.php">
    </form>
</body>
</hmtl>