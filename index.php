<?php
    include "config\\url.php";
    require "config\\connection.php";
    include "utilits.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "components\\style.php" ;?>
    <title>Home</title>
</head>
<body>
    <header>
    <?php include "components\\nav.php"; ?>
    </header>

    <div class="container ">
        <div class="d-flex justify-content-center align-items-center hero position-absolute start-50 top-50 translate-middle z-0">
            <h1> welcome to PageAndPen</h1>
        </div>
    
    </div>
    <?php include "components\\javascript.php"; ?>
</body>
</html>