<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        include "..\\config\\url.php";
        require "..\\config\\connection.php";
        include "..\\utilits.php";
        if(!is_authenticated()){
            header("location : login.php");
        }
        include "..\\components\\style.php" ;
        $id = $_GET["id"];
        $select_query = "SELECT * FROM `product` WHERE `id` = '{$id}' ";
        $p_select = mysqli_query($conn, $select_query);
        $p_data = mysqli_fetch_assoc($p_select); 
    ?>
    <title><?=$p_data["name"]?></title>
</head>
<body>
    <header>
        <?php 
            include "..\\components\\nav.php" ;
        ?>
    </header>
    <?php 
        
        
    ?>
    <?php include "..\\components\\javascript.php"; ?>
</body>
</html>