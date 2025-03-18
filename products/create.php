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
        // $user = $_SESSION["active"]
    ?>
    <title>Create</title>
</head>
<body>
    <header>
    <?php include "..\\components\\nav.php"; ?>
    </header>

    <div class="container d-flex justify-content-center align-items-center" >
        <?php 
            if (isset($_POST["addProduct"])) {
                // get values of the main data
                $name = htmlspecialchars($_POST["p_name"]);
                $price = htmlspecialchars($_POST["p_price"]);
                $category = htmlspecialchars($_POST["p_category"]);
                $description = htmlspecialchars($_POST["p_description"]);
                $images = $_FILES["p_image"];
                $inQue = "";

                // Validate fields
                set_error("p_name",$name);
                set_error("p_price",$price);
                set_error("p_category",$category);
                set_error("p_description",$description);

                $userId= $user["id"];
                if(empty($errors)){
                    $insert_query = "INSERT INTO `product` (`created_by`,`name`, `price`, `category`, `description`, `images`) 
                                        VALUES ('$userId','$name', '$price', '$category', '$description', '')";
                    $inQue = mysqli_query($conn, $insert_query);

                    if($inQue && !empty($images)){
                        // Get the last inserted product_id
                        $product_id = mysqli_insert_id($conn);

                        // Create a folder for the product images
                        $uploadDir = IMAGE_BASE_URL. "/assets/images/product_images/{$product_id}/";
                        if (!file_exists($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }
                        // Store images
                        $sources = [];
                        for ($i=0; $i < count($images["tmp_name"]) ; $i++) { 
                            $from =  $images["tmp_name"][$i];
                            $to = $uploadDir . basename($images["name"][$i]);
                            if (move_uploaded_file($from, $to)) {
                                // array_push($sources,$to);
                                array_push($sources, "/assets/images/product_images/{$product_id}/" . basename($images["name"][$i]));
                            }
                        }
                        // Convert images array to JSON and update the database
                        $imageJson = json_encode($sources);
                        $update_query = "UPDATE `product` SET `images` = '$imageJson' WHERE `id` = $product_id";
                        mysqli_query($conn, $update_query);
                    }
                }
            }
        ?>
        <!-- add product form  -->
        <form  method="post" class= "p-2 px-3 m-2 mt-4 rounded main-form" enctype="multipart/form-data">
            <h1 class="text-center">Add product</h1>
            <div class="mb-3">
                <label for="p_name" class="form-label">Name :</label>
                <input type="text" name="p_name" id="p_name" class="form-control" placeholder="Product name" 
                <?= have_Old("p_name","addProduct") ?>/>
                <?= show_errors("p_name") ?>
            </div>
            <div class="mb-3">
                <label for="p_price" class="form-label">Price :</label>
                <input type="text" name="p_price" id="p_price" class="form-control" placeholder="Product price" 
                <?= have_Old("p_price","addProduct") ?>/>
                <?= show_errors("p_price") ?>
            </div>
            <div class="mb-3">
                <label for="p_category" class="form-label">Category :</label>
                <input type="text" name="p_category" id="p_category" class="form-control" placeholder="Product category" 
                <?= have_Old("p_category","addProduct") ?>/>
                <?= show_errors("p_category") ?>
            </div>
            <div class="mb-3">
                <label for="p_description" class="form-label">Description :</label>
                <input type="text" name="p_description" id="p_description" class="form-control" placeholder="Product description" 
                <?= have_Old("p_description","addProduct") ?>/>
                <?= show_errors("p_description") ?>
            </div>
            <div class="mb-3">
                <label for="p_image" class="form-label">Image :</label>
                <input class="form-control" type="file" id="p_image" name="p_image[]" multiple >
            </div>
            <div class="mb-3">
                <input type="submit" class="btn btn-dark w-100" value="Add Product" name="addProduct">
            </div>
        </form>
    </div>
    <?php
        // final alert massage
        if(isset($_POST["addProduct"])){
            if($inQue){ ?>
                <div class="alert alert-success m-2 mx-auto" role="alert">
                    <strong>product added successfuly</strong> <a class=" btn btn-success" role="button" href="products.php">Products</a>
                </div>
            <?php } 
            else {
                    echo '<div class="alert alert-danger m-2 mx-auto" role="alert">
                            <strong>Failed to add product</strong>
                        </div>';
            }
        }
    ?>
    </div>
    <?php include "..\\components\\javascript.php"; ?>
</body>
</html>