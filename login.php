
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
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>

<body>

    <!-- <a href="register.php" role="button">Register</a> -->
    <!-- <form action="login.php" method="post"> -->
        <!-- <input type="text" name="addEmail" placeholder="Enter your email." required>
        <input type="text" name="motDePasse" placeholder="Enter your password." required>
        <input type="submit" href="login.php"> -->
    <h1>Login</h1>
	<div class="form-container">
		<a href="register.php">Register</a>
	    <?php if($error != ""){ echo '<div class="error">'.$error.'</div>'; } ?>
	    <form action="login.php" method="post">
	        <input type="text" name="addEmail" placeholder="Enter your email" required>
	        <input type="password" name="motDePasse" placeholder="Enter your password" required>
	        <input type="submit" value="Log in">
	    </form>
	</div>
    </form>
</body>
</html>