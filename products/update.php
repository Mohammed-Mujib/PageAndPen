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
            header("Location: login.php");
        }
        include "..\\components\\style.php" ;
    ?>
    <title>Update product</title>
</head>
<body>
    <header>
        <?php 
            include "..\\components\\nav.php" ;
        ?>
    </header>
    <?php 
    $id = $_GET["id"];
    $update_select = "SELECT * FROM `product` WHERE `id` = '{$id}' ";
    $p_select = mysqli_query($conn, $update_select);
    $p_data = mysqli_fetch_assoc($p_select); 

    if(!($_SESSION["active"]["id"] === $p_data["created_by"])){
        header("Location: index.php");
        exit;
    }

    if ($p_select == true){
        if (isset($_POST['updateProduct'])) {
            $name = htmlspecialchars($_POST['p_name']);
            $price = htmlspecialchars($_POST['p_price']);
            $category = htmlspecialchars($_POST['p_category']);
            $description = htmlspecialchars($_POST['p_description']);
            $images = $_FILES["p_image"];
            // Validate fields
            set_error("p_name",$name);
            set_error("p_price",$price);
            set_error("p_category",$category);
            set_error("p_description",$description);

            if(empty($errors)){
                $update_query = "UPDATE `product` SET `name` = '$name', `price` = '$price', `category` = '$category', `description` = '$description' WHERE `id` = '$id'";
                $upQue = mysqli_query($conn, $update_query);
                if ($upQue) {
                    if($images){  
                        // $uploadDir = "assets/images/{$id}/";
                        $uploadDir = IMAGE_BASE_URL. "/assets/images/product_images/{$id}/";
                        if (!file_exists($uploadDir)) {
                            mkdir($uploadDir, 0777, true); 
                        } else{
                            deleteDirectory(IMAGE_BASE_URL."assets/images/{$id}"); 
                            mkdir($uploadDir, 0777, true); 
                        }
                        // Store images
                        $sources = [];
                        for ($i = 0; $i < count($images["name"]); $i++) {
                            $from = $images["tmp_name"][$i];
                            $to = $uploadDir . basename($images["name"][$i]);
                            if (move_uploaded_file($from, $to)) {
                                array_push($sources, "/assets/images/product_images/{$id}/" . basename($images["name"][$i]));
                            }
                        }
                        // Convert images array to JSON and update the database
                        $imageJson = json_encode($sources);
                        $update_query = "UPDATE `product` SET `images` = '$imageJson' WHERE `id` = '$id'";
                        mysqli_query($conn, $update_query);
                    }
                    header("Location: products.php"); 
                    exit;
                } else {
                    echo "<p class='text-danger'>Failed to update product. " . mysqli_error($conn) . "</p>";
                }
            }
            
        }
    ?>
    <div class="container d-flex justify-content-center">
        <form class=" position-absolute  align-items-center  mx-auto mt-2" method="post" enctype="multipart/form-data">
            <div  class="main-form update_form px-3 py-2 rounded bg-white">
                <div class="d-flex justify-content-center align-items-center">
                    <h1 class="text-center">Update product</h1>
                </div>
                <input type="hidden" name="product_id" value="<?= $p_data['id'] ?>">
                <div class="mb-3">
                    <label for="p_name" class="form-label">Name :</label>
                    <input type="text" name="p_name" id="p_name" class="form-control" placeholder="Product name" value="<?= $p_data["name"] ?>" />
                    <?= show_errors("p_name") ?>
                </div>
                <div class="mb-3">
                    <label for="p_price" class="form-label">Price :</label>
                    <input type="text" name="p_price" id="p_price" class="form-control" placeholder="Product price" value="<?= $p_data["price"] ?>" />
                    <?= show_errors("p_price") ?>
                </div>
                <div class="mb-3">
                    <label for="p_category" class="form-label">Category :</label>
                    <input type="text" name="p_category" id="p_category" class="form-control" placeholder="Product category" value="<?= $p_data["category"] ?>" />
                    <?= show_errors("p_category") ?>
                </div>
                <div class="mb-3">
                    <label for="p_description" class="form-label">Description :</label>
                    <input type="text" name="p_description" id="p_description" class="form-control" placeholder="Product description" value="<?= $p_data["description"] ?>" />
                    <?= show_errors("p_description") ?>
                </div>
                <div class="mb-3">
                    <label for="p_image" class="form-label">Image :</label>
                    <input class="form-control" type="file" id="p_image" name="p_image[]" multiple/>
                </div>
                <div class="mb-3">
                    <input type="submit" class="btn btn-success w-100" value="Save" name="updateProduct">
                </div>
            </div>
        </form>
    </div>
    <?php  } ?>
    <?php include "..\\components\\javascript.php"; ?>
</body>
</html>