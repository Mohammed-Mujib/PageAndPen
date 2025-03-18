<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        include "..\\config\\url.php";
        require "..\\config\\connection.php";
        include "..\\utilits.php";
        include "..\\components\\style.php" ;
    ?>
    <title>Products</title>
</head>
<body>
    <header>
        <?php include "..\\components\\nav.php"; ?>
    </header>

    <div class="container">
        <div class=" mt-2 border-bottom d-flex justify-content-between align-items-center">
            <h1>Products: </h1>
            <?php
                if(is_authenticated()){
            ?>
            <a  id="" class="btn btn-dark" href="create.php" role="button">Add Product</a>   
            <?php } ?>         
        </div>
        <div class="row mt-2">
            <?php
                $select_query ="SELECT * FROM `product`";
                $select = mysqli_query($conn, $select_query);
                $data = mysqli_fetch_all ($select);
                
                foreach($data as $val){
                    $image_arr = json_decode($val[6]);
                ?>
                    <div class="col-sm-12 col-md-4 col-lg-3 p-2">
                        <div class="card p-1 w-100 ">
                            <div class="image-holder overflow-hidden rounded position-relative mx-auto w-100">
                                <img src="<?= $image_arr[0] ?>" class="product-outer-img mx-auto w-100" >
                                <!-- checking if you are the admin or the owner if the product -->
                                <?php
                                    if(is_authenticated()){
                                        if(is_admin() || $user["id"] == $val[1]){ ?>
                                            <div class="over-layer">
                                                <div class="d-flex flex-column align-items-center justify-content-center position-absolute top-0 start-0 w-100 px-3" style="height: 100%;">
                                                    <!-- update page link -->
                                                    <?php if($user["id"] == $val[1]){?>
                                                        <div class="w-100">
                                                            <a href="update.php?id=<?= $val[0] ?>" class="btn btn-dark mb-2 w-100 p_btn">
                                                                <i class="fa-solid fa-pen-to-square text-info"></i> Update 
                                                            </a>
                                                        </div>
                                                    <?php } ?>
                                                    <!-- delete product form -->
                                                    <div class="w-100">
                                                        <form action="product.php" method="post" class="w-100">
                                                            <?php
                                                                if(isset($_POST["deleteBtn"])){
                                                                    $delete_query = "DELETE FROM `product` WHERE `id` = '{$_POST["delete"]}'";
                                                                    $delete = mysqli_query($con,$delete_query);
                                                                    if($delete){
                                                                        deleteDirectory(BASE_URL."assets/images/{$_POST['delete']}"); 
                                                                        header("location: product.php");
                                                                        exit;
                                                                    }
                                                                }
                                                            ?>
                                                            <input type="hidden" name="delete" value="<?= $val[0]?>">
                                                            <button type="submit" name="deleteBtn" class="btn btn-dark w-100 p_bt">
                                                                    <i class="fa-solid fa-trash text-danger"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        } 
                                    }
                                ?>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><a href="show.php?id=<?= $val[0] ?>"class="p_link" ><?= $val[2] ?></a></h5>
                                <p class="text-success mb-1 price">$<?= $val[3] ?></p>
                                <small class="text-capitalize text-black-50"><?= $val[5] ?></small>
                                <p class="card-text"><?= $val[4] ?></p>
                            </div>
                        </div>
                    </div>
                <?php
                }
            ?>  
        </div> 
    </div>
    <?php include "..\\components\\javascript.php"; ?>
</body>
</html>