<?php
    require "..\config\connection.php";
    include "..\utilits.php";
    if(!is_authenticated()){
        header("Location: login.php ");
        exit;
    }else{
        if(!is_admin()){
            header("Location: index.php");
            exit;
        }
    }
    // $user= $_SESSION["active"];
    $select_query = "SELECT * FROM `users`";
    $select = mysqli_query($conn,$select_query);
    $all_users = mysqli_fetch_all($select)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <?php include "..\\components\\style.php" ;?> -->
    <link rel="stylesheet" href="..\css\all.min.css">
    <link rel="stylesheet" href="..\css\bootstrap.min.css">
    <link rel="stylesheet" href="..\css\style.css">
    <title>Admin <?= $user["name"] ?></title>
</head>
<body>
    <header>
    <?php include "..\components\\nav.php"; ?>
    </header>
    <div class="container"> 
        <div class=" mt-2 border-bottom d-flex justify-content-between align-items-center">
            <h1>Admin (<?= $user["name"] ?>): </h1>
        </div>
    <h4>number of users = <?= count($all_users) ?></h4>
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>id</th>
                <th>name</th>
                <th>email</th>
                <th>phone</th>
                <th>address</th>
                <th>role</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($all_users as $uesrs){
                    ?>
                <tr>
                    <td><?=$uesrs[0] ?></td>
                    <td><?=$uesrs[1] ?></td>
                    <td><?=$uesrs[2] ?></td>
                    <td><?=$uesrs[4] ?></td>
                    <td><?=$uesrs[5] ?></td>
                    <td><?=$uesrs[6] ?></td>
                </tr>
                <?php
                }
            ?>
        </tbody>
    </table>
    </div>
    
    <?php include "..\components\\javascript.php"; ?>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
