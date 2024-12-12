<?php  include('header.php'); ?>


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
            <h2>Add New Product</h2>
            <div class="table-responsive ">

                <div class="mx-auto">
                    <form id="create-form" enctype="multipart/form-data" method="POST" action="create_product.php">
                        <p style="color: red;"><?php if(isset($_GET['error'])){ echo $_GET['error'];}?></p>
                        <div class="form-group mt-2">
                            <!-- <input type="hidden" name="product_id" value=""/> -->
                            <label>Title</label>
                            <input type="text" class="form-control w-100" name="name" id="product-name" value="" placeholder="Enter the product title" required/>
                        </div>

                        <div class="form-group mt-2">
                            <label>Description</label>
                            <input type="text" class="form-control" name="description" id="product-desc" value="" placeholder="Enter the product description" required/>
                        </div>
                        
                        <div class="form-group mt-2">
                            <label>Price</label>
                            <input type="text" class="form-control" name="price" id="product-price" value="" placeholder="Enter the product price" required/>
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
                            <input type="submit" class="btn btn-primary" id="edit-btn" name="create_product" value="Edit"/>
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