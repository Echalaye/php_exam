<?php
    $mysqli = new mysqli("localhost", "root", "", "php_exam_db");
    if(isset($_POST["Nameart"])){
        $nameart = $_POST["Nameart"];
        $desc = $_POST["Description"];
        $price = $_POST["Price"];
        $img = $_POST["Image"];
        $stk = $_POST["Stock"];
        $date = date('d/m/Y h:i:s', time());
        $price = floatval($price);
        $cookieValue = $_COOKIE["pwd"];
        $Infouser = $mysqli->query("SELECT id FROM user WHERE `mdp` = '$cookieValue'");
        $userId = $Infouser->fetch_assoc();
        $userId = $userId["id"];
        $mysqli->query("INSERT INTO article(`name`, `description`, `prix`,`datePublie`, idAuteur , `img`) VALUES ('$nameart', '$desc', '$price', '$date', '$userId', '$img')");
        $ArticleInfo = $mysqli->query("SELECT id FROM article WHERE description = '$desc'AND prix = '$price' AND idAuteur = '$userId'");
        $idart = $ArticleInfo->fetch_assoc();
        $idart = $idart["id"];
        $mysqli->query("INSERT INTO stock(`idArticle`, `stock`) VALUES ('$idart', '$stk')");
        header("Location: http://localhost/php_exam/");
    }else{
        $nameart = "";
        $img = "";
        $price = "";
        $desc = "";
    }
?>

<html>
<body>
        <form action="vente.php" method="post">
            <input type="text" name="Nameart" placeholder="Enter the name of your article." required>
            <input type="text" name="Description" placeholder="Enter a description for your article." required>
            <input type="number" name="Price" placeholder="Enter the price of your article." required>
            <input type="text" name="Image" placeholder="Add image of your article." required>
            <input type="text" name="Stock" placeholder="Quantity." required>
            <input type="submit" href="vente.php">
        </form>
    </body>
</html>

