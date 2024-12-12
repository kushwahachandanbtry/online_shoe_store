<?php  include('header.php'); ?>

<?php  
            if(isset($_GET['product_id'])){
                $product_id =$_GET['product_id'];
            $stmt = $conn->prepare("SELECT * FROM products WHERE product_id=?");
            $stmt->bind_param('i', $product_id);
            $stmt->execute();
            $products = $stmt->get_result();

            }elseif(isset($_POST['edit_btn'])){
                $product_id = $_POST['product_id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];
                $sizes = $_POST['sizes'];
                $stock =$_POST['stock'];

                $stmt=$conn->prepare("UPDATE products SET product_name=?, product_description=?, product_price=?, product_category=? ,sizes=?, stock=? WHERE product_id=?");
                $stmt->bind_param('sssssii', $title, $description, $price, $category, $sizes, $stock, $product_id);
               if( $stmt->execute()){
                header('location: products.php?edit_success_message=Products has been updated');
               }else{
                header('location: products.php?edit_failure_message=Error occured try again!');
               }
            
            }else{
                header('location: products.php');
            }
          
?>

<!----- sidebar -------------->
<div class="container-fluid">
  <div class="row">
    <div class="col-md-2 sidebar">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link active" href="index.php">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php">Orders</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="products.php">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="add_product.php">Add New Product</a>
        </li>
      </ul>
    </div>

    <div class="col-md-10 main">
      <div class="pt-1 pb-2">
        <h1 class="h2">Dashboard</h1>
        <hr class="dsh_hori">
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="section-container">
            <h2>Edit Products</h2>
            <div class="table-responsive ">
                <div class="mx-auto">
                    <form id="edit-form" method="POST" action="edit_product.php">
                        <p style="color: red;"><?php if(isset($_GET['error'])){ echo $_GET['error'];}?></p>
                        <div class="form-group mt-2">
                            <?php foreach($products as $product){?>
                                <input type="hidden" name="product_id" value="<?php echo $product['product_id'];?>"/>
                            <label>Title</label>
                            <input type="text" class="form-control w-100" name="title" id="product-name" value="<?php echo $product['product_name']; ?>" placeholder="Enter the product title" required/>
                        </div>

                        <div class="form-group mt-2">
                            <label>Description</label>
                            <input type="text" class="form-control" name="description" id="product-desc" value="<?php echo $product['product_description']; ?>" placeholder="Enter the product description" required/>
                        </div>


                        
                        <div class="form-group mt-2">
                            <label>Price</label>
                            <input type="text" class="form-control" name="price" id="product-price" value="<?php echo $product['product_price']; ?>" placeholder="Enter the product price" required/>
                        </div>

                    

                        <div class="form-group mt-2">
                            <label>Category</label>
                            <select class="form-select" required name="category">
                                <option value="embroidery">Embroidery</option>
                                <option value="dye">Dye</option>
                                <option value="handpaint">Hand-Painted</option>
                                <option value="wedding">Wedding</option>
                            </select>
                        </div>

                        <div class="form-group mt-2">
                          <label>Stock</label>
                          <input type="number" class="form-control" name="stock" id="product-stock" value="" placeholder="Enter the product stock" required/>
                        </div>

                        <div class="form-group mt-2">
                            <label>Sizes</label>
                            <input type="text" class="form-control" name="sizes" id="product-sizes" value="" placeholder="Enter the product sizes (e.g. 36, 37, 38, 40)" required/>
                        </div>


                        <div class="form-group mt-3">
                            <input type="submit" class="btn btn-primary" id="edit-btn" name="edit_btn" value="Edit"/>
                        </div>
                        <?php } ?>
                            
                    

                    </form>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>