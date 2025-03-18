
<?php 
    $update_stauts = false;
    // $p_id ;
    function update_form( $id){
        global $conn;
        // global $p_id;
        // $p_id = $id ;
        global $update_view;
        $update_select = "SELECT * FROM `product` WHERE `product_id` = '{$id}' ";
        $p_select = mysqli_query($conn, $update_select);
        $p_data = mysqli_fetch_assoc($p_select); 
        if ($p_select == true){
        ?>
        <form class=" position-absolute d-flex justify-content-center align-items-center update-cover" method="post">
            <div  class="main-form update_form px-3 py-2 rounded bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="text-center">Update product</h1>
                    <a class="text-danger text-decoration-none close-form" href="product.php">x</a>
                </div>
                <input type="hidden" name="product_id" value="<?= $p_data['product_id'] ?>">
                <div class="mb-3">
                    <label for="p_name" class="form-label">Name :</label>
                    <input type="text" name="p_name" id="p_name" class="form-control" placeholder="Product name" value="<?= $p_data["name"] ?>" />
                </div>
                <div class="mb-3">
                    <label for="p_price" class="form-label">Price :</label>
                    <input type="text" name="p_price" id="p_price" class="form-control" placeholder="Product price" value="<?= $p_data["price"] ?>" />
                </div>
                <div class="mb-3">
                    <label for="p_category" class="form-label">Category :</label>
                    <input type="text" name="p_category" id="p_category" class="form-control" placeholder="Product category" value="<?= $p_data["category"] ?>" />
                </div>
                <div class="mb-3">
                    <label for="p_description" class="form-label">Description :</label>
                    <input type="text" name="p_description" id="p_description" class="form-control" placeholder="Product description" value="<?= $p_data["description"] ?>" />
                </div>
                <div class="mb-3">
                    <input type="submit" class="btn btn-success w-100" value="Save" name="updateProduct">
                </div>
            </div>
        </form>
        <?php  }
    }

    if (isset($_POST['updateProduct'])) {
        $id = $_POST['product_id'];
        $name = htmlspecialchars($_POST['p_name']);
        $price = htmlspecialchars($_POST['p_price']);
        $category = htmlspecialchars($_POST['p_category']);
        $description = htmlspecialchars($_POST['p_description']);
        $images = $_FILES['productimage'];
        $update_query = "UPDATE `product` SET `name` = '$name', `price` = '$price', `category` = '$category', `description` = '$description' WHERE `product_id` = '$id'";
        $upQue = mysqli_query($conn, $update_query);

        if ($upQue) {
            header("Location: product.php"); 
            exit;
        } else {
            echo "<p class='text-danger'>Failed to update product. " . mysqli_error($conn) . "</p>";
        }
    }
?>