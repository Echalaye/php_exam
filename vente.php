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
        $mysqli->query("INSERT INTO article(`name`, `description`, `prix`,`datePublie`,`img`) VALUES ('$nameart', '$desc', '$price', '$date', '$img')");
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

