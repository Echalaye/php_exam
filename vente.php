<?php
    $nameart = $_POST["Nameart"];
    if($nameart != null){
        $desc = $_POST["Description"];
        $price = $_POST["Price"];
        $img = $_POST["Image"];
    }else{
        $nameart = "";
        $img = "";
        $price = "";
        $desc = "";
    }
?>

<html>
<h1> <?php echo "name ", $nameart, " desc ", $desc , " price " , $price , " img " , $img ?> !</h1> 
<body>
        <form action="vente.php" method="post">
            <input type="text" name="Nameart" placeholder="Enter the name of your article." required>
            <input type="text" name="Description" placeholder="Enter a description for your article." required>
            <input type="text" name="Price" placeholder="Enter the price of your article." required>
            <input type="text" name="Image" placeholder="Add image of your article." required>
        </form>
    </body>
</html>

