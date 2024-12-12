<?php  include('layouts/header.php') ?>

<?php
include('server/connection.php');
echo "Connected ";
if(isset($_GET['product_id'])){

  $product_id = $_GET['product_id'];

  $stmt = $conn->prepare("SELECT * FROM products WHERE product_id=?");

  $stmt->bind_param("i",$product_id);
  
  $stmt->execute();

  $product = $stmt->get_result();
  if($product->num_rows == 0){
    header('location: index.php');
  }
  $row = $product->fetch_assoc();


}else{
  header('location: index.php');
}


?>



      <!--single product-->
     <section class="container single-product my-5 pt-5">
        <div class="row mt-5">
       
           
            <div class="col-lg-5 col-md-6 col-sm-12">
                <img class="img-fluid w-100 pb-1" src="assets/imgs/<?php echo $row['product_image'];?>" id="mainImg"/>
                <div class="small-img-group">
                    <div class="small-img-col">
                        <img src="assets/imgs/<?php echo $row['product_image'];?>" width="100%" class="small-img"/>
                    </div>
                    <div class="small-img-col">
                        <img src="assets/imgs/<?php echo $row['product_image2'];?>" width="100%" class="small-img"/>
                    </div>
                    <div class="small-img-col">
                        <img src="assets/imgs/<?php echo $row['product_image3'];?>" width="100%" class="small-img"/>
                    </div>
                    <div class="small-img-col">
                      <img src="assets/imgs/<?php echo $row['product_image4'];?>" width="100%" class="small-img"/>
                  </div>
                    
                </div>
            </div>
            

            <div class="col-lg-6 col-md-12 col-12">
                <h6>Women Shoes</h6>
                <h3 class="py-4">Women's Fashion</h3>
                <h2>$ <?php echo $row['product_price']?></h2>
                
                <form method="POST" action="cart.php">
                  <input type="hidden" name="product_id" value="<?php echo $row['product_id'];?>"/>
                    <input type="hidden" name="product_image" value="<?php echo $row['product_image'];?>"/>
                    <input type="hidden" name="product_name" value="<?php echo $row['product_name'];?>"/>
                    <input type="hidden" name="product_price" value="<?php echo $row['product_price'];?>"/>

                    <div class="form-group">
                      <label for="size">Size:</label>
                      <select class="form-control" id="size" name="size" required> 
                        <?php 
                          $sizes = explode(',', $row['sizes']); 
                          foreach ($sizes as $size) {
                            echo "<option value='$size'>$size</option>";
                          }
                        ?>
                      </select>
                    </div>


                  <div class="form-group">
                    <label for="product_quantity">Quantity:</label>
                      <input type="number" name="product_quantity" id="product_quantity" value="1" min="1" max="<?php echo $row['stock']; ?>" style="font-weight: bold;" required>
                      <span id="stock_message" style="color: red;"></span> 
                      <div class="stock-info">
                        <?php if($row['stock'] > 0): ?>
                          <span class="instock">In Stock (<?php echo $row['stock']; ?> available)</span>
                        <?php else: ?>
                          <span class="outofstock">Out of Stock</span>
                        <?php endif; ?>
                      </div> 
                  </div>
                <button class="buy-btn" type="submit" name="add_to_cart">Add To Cart</button>
               
                </form>
                <h4 class="mt-5 mb-5">Product details</h4>
                <span ><?php echo $row ['product_description'];?>
                </span>

                
                
            </div>
         
         
        </div>
     </section>

     <!--Related Products-->
     <section id="related-products" class="my-5 pb-5">
        <div class="container text-center py-5">
          <h3>Related Shoes</h3>
          <hr/>

        </div>
        <div class="row mx-auto container-fluid">
          <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3" src="assets/imgs/1.jpg"/>
            <div class="star">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
            <h5 class="p-name">stylish Shoes</h5>
            <h4 class="p-price">$ 1000.00</h4>
            <a  class="btn buy-btn" href="<?php echo "single_prdt.php?product_id=".$row['product_id']; ?>">Buy Now</a>
          </div>
        <!------------------->
        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
          <img class="img-fluid mb-3" src="assets/imgs/2.jpg"/>
          <div class="star">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
          <h5 class="p-name">Embroidery shoes</h5>
          <h4 class="p-price">$ 2000.00</h4>
          <a  class="btn buy-btn" href="<?php echo "single_prdt.php?product_id=".$row['product_id']; ?>">Buy Now</a>
          </div>
        <!------------------->
        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
          <img class="img-fluid mb-3" src="assets/imgs/3.jpg"/>
          <div class="star">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
          <h5 class="p-name">Hand-Painted Shoes</h5>
          <h4 class="p-price">$ 3000.00</h4>
          <a  class="btn buy-btn" href="<?php echo "single_prdt.php?product_id=".$row['product_id']; ?>">Buy Now</a>
          </div>
        <!------------------->
        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
          <img class="img-fluid mb-3" src="assets/imgs/4.jpg"/>
          <div class="star">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
          <h5 class="p-name">Dye Shoes</h5>
          <h4 class="p-price">$ 5000.00</h4>
          <a  class="btn buy-btn" href="<?php echo "single_prdt.php?product_id=".$row['product_id']; ?>">Buy Now</a>
          </div>
      </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
      var mainImg = document.getElementById("mainImg");
      var smallImg = document.getElementsByClassName("small-img");

      smallImg[0].onclick = function(){
        mainImg.src = smallImg[0].src;
      }

      smallImg[1].onclick = function(){
        mainImg.src = smallImg[1].src;
      }
      smallImg[2].onclick = function(){
        mainImg.src = smallImg[2].src;
      }
      smallImg[3].onclick = function(){
        mainImg.src = smallImg[3].src;
      }
    </script>

    <input type="hidden" id="product_stock" value="<?php echo $row['stock']; ?>"

      <?php  include('layouts/footer.php') ?>
