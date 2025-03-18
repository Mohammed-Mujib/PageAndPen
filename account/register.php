<?php
    require "..\\config\\url.php";
    require "..\\config\\connection.php";
    include "..\utilits.php";
    redirect_auth_user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "..\\components\\style.php" ;?>
    <title>register</title>
</head>
<body>
    <header>
    <?php include "..\\components\\nav.php"; ?>
    </header>
    <div class="container" >
        <div class="mt-2 border-bottom ">
            <h1>Join us now: </h1>          
        </div>
        <div class="container d-flex justify-content-center align-items-center">
            <?php
                if(isset($_POST['registerUser'])){
                    $name = htmlspecialchars($_POST["name"]);
                    $email = htmlspecialchars($_POST["email"]);
                    $phone = htmlspecialchars($_POST["phone"]);
                    $address = htmlspecialchars($_POST["address"]);
                    $password = htmlspecialchars($_POST["password"]);
                    $password_confirm = htmlspecialchars($_POST["password_confirmation"]);
                    // echo "<p> data stored </p>";
                    //validation
                    set_error("name",$name);
                    set_error("email",$email);
                    set_error("phone",$phone);
                    set_error("password",$password);
                    set_error("password_confirmation",$password_confirm);
                    // set_error("passAndConfirm",$password_confirm, ($password !== $password_confirm) ? "" : "Passwords do not match");
                    // echo "<p> data validate : </p>" . count($errors);
                    // check if it's not empty of input
                    if(empty($errors)){
                        // echo "<p> it is not empty</p>";
                        // check if the password and the comfirmatopn are the same
                        if($password !== $password_confirm){
                            setErrorDirect("passAndConfirm","the password and the confirmation are not the same");
                        }
                        else{
                            $select_query = "SELECT * FROM `users` WHERE `email` = '$email'";
                            $select = mysqli_query($conn,$select_query);
                            if(mysqli_fetch_assoc($select)){
                                setErrorDirect("foundedUser","the user is allready registerd try login in");
                            }
                            else {
                                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                                $insert_query = "INSERT INTO `users`(`name`, `email`, `password`, `phone`, `address`, `role`) VALUES ('$name','$email','$hashed_password','$phone','$address','user')";
                                $inQue = mysqli_query($conn,$insert_query);
                                header("Location: login.php");
                                exit;
                            }
                        }
                    }
                }
            ?>
            <form  method="post" class= "p-2 px-3 m-2 mt-4 rounded main-form" enctype="multipart/form-data">
                <h1 class="text-center">Register Form</h1>
                <div class="mb-3">
                    <label for="name" class="form-label">Name :</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="user name" 
                    <?= have_Old("name","registerUser") ?>/>
                    <?= show_errors("name") ?>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email :</label>
                    <input type="text" name="email" id="email" class="form-control" placeholder="example@gmial.com" 
                    <?= have_Old("email","registerUser") ?>/>
                    <?= show_errors("email") ?>
                    <?= show_errors("foundedUser") ?>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone :</label>
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="0110XXXXXXX" 
                    <?= have_Old("phone","registerUser") ?>/>
                    <?= show_errors("phone") ?>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address :</label>
                    <input type="text" name="address" id="address" class="form-control" placeholder="egypt , giza , doki" 
                    <?= have_Old("address","registerUser") ?>/>
                    <!-- <?= show_errors("address") ?> -->
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password :</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" 
                    <?= have_Old("password","registerUser") ?>/>
                    <?= show_errors("password") ?>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password :</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm password" 
                    <?= have_Old("password_confirmation","registerUser") ?>/>
                    <?= show_errors("password_confirmation") ?>
                    <?= show_errors("passAndConfirm") ?>
                </div>

                <div class="mb-1">
                    <input type="submit" class="btn btn-dark w-100" value="Register" name="registerUser">
                </div>
                <div class=" d-flex justify-content-center">
                    <p class="m-0">have an acount?? 
                        <a href="<?=BASE_URL?>login.php" class="badge bg-info">login</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <?php include "..\\components\\javascript.php"; ?>
</body>
</html>