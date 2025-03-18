<?php
    include "..\\config\\url.php";
    require "..\\config\\connection.php";
    include "..\\utilits.php";
    redirect_auth_user();
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "..\\components\\style.php" ;?>
    <title>Login</title>
</head>
<body>
    <header>
    <?php include "..\\components\\nav.php"; ?>
    </header>

    <div class="container" >
        <div class="mt-2 border-bottom ">
            <h1>Welcome back: </h1>           
        </div>
        <div class="container d-flex justify-content-center align-items-center">
            <?php
                if(isset($_POST["loginUser"])){
                    $email = htmlspecialchars($_POST["email"]);
                    $password = htmlspecialchars($_POST["password"]);
                    set_error($email,"email");
                    set_error($password,"password");
                    if(empty($errors)){
                        $select_query = "SELECT * FROM `users` WHERE `email` = '$email'";
                        $select = mysqli_query($conn,$select_query);
                        $user = mysqli_fetch_assoc($select);
                        if(!$user){
                            setErrorDirect("emailUnfound","the email is not founded try rigstering first");
                        }
                        else{
                            if(!password_verify($password,$user["password"])){
                                setErrorDirect("wrongPassword","wrong Password");
                            }
                            else{
                                // session_start();
                                // $_SESSION["active"]= $user;
                                login($user);
                                header("Location: ".BASE_URL. "products/products.php");
                                exit;
                            }
                        }
                    }
                }
            ?>
            <form  method="post" class= "p-2 px-3 m-2 mt-4 rounded main-form" enctype="multipart/form-data">
                <h1 class="text-center">Login Form</h1>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email :</label>
                    <input type="text" name="email" id="email" class="form-control" placeholder="example@gmial.com" 
                    <?= have_Old("email","loginUser") ?>/>
                    <?= show_errors("email") ?>
                    <?= show_errors("emailUnfound") ?>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Password :</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" 
                    <?= have_Old("password","loginUser") ?>/>
                    <?= show_errors("password") ?>
                    <?= show_errors("weongPassword") ?>
                </div>

                <div class="mb-1">
                    <input type="submit" class="btn btn-dark w-100" value="Login" name="loginUser">
                </div>

                <div class=" d-flex justify-content-center">
                    <p class="m-0">don't have an acount?? 
                        <a href="register.php" class="badge bg-info" >Register</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <?php include "..\\components\\javascript.php"; ?>
</body>
</html>