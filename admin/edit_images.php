<?php include('header.php') ?>

<?php 
if(isset($_GET['product_id'])){
    $product_id = $_GET['product_id'];
    $product_name = $_GET['product_name'];
}else{
    header('location: products.php');
}

?>

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
            <h2>Edit Product Images</h2>
            <div class="table-responsive ">
                <div class="mx-auto">
                    <form id="edit-image-form" enctype="multipart/form-data" method="POST" action="update_images.php">
                        <p style="color: red;"><?php if(isset($_GET['error'])){ echo $_GET['error'];}?></p>
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>"/>
                        <input type="hidden" name="product_name" value="<?php echo $product_name; ?>"/>
                       
                        <div class="form-group mt-2">
                            <label>Image 1</label>
                            <input type="file" class="form-control" name="image1" id="image1" value="" placeholder="Enter the image" required/>
                        </div>
                        <div class="form-group mt-2">
                            <label>Image 2</label>
                            <input type="file" class="form-control" name="image2" id="image2" value="" placeholder="Enter the image" required/>
                        </div>
                        <div class="form-group mt-2">
                            <label>Image 3</label>
                            <input type="file" class="form-control" name="image3" id="image3" value="" placeholder="Enter the image" required/>
                        </div>
                        <div class="form-group mt-2">
                            <label>Image 4</label>
                            <input type="file" class="form-control" name="image4" id="image4" value="" placeholder="Enter the image" required/>
                        </div>
                        


                        <div class="form-group mt-3">
                            <input type="submit" class="btn btn-primary" name="update_images" value="Edit"/>
                        </div>
                        
                            
                    

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