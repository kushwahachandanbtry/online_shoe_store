
<?php  include('layouts/header.php') ?>



      <!--home section-->
      <section id="home">
        <div class="container">
          <h5>New Arrival</h5>
          <h1><span>Best Prices</span> This Season</h1>
          <p>We offer the quality products in most affordab prices</p>
          <button onclick="location.href='shop.php'">SHOP NOW</button>
        </div>
      </section>
      <!---new Arrivals-->
      <!-- <section id="new" class="w-100">
        <div class="row p-0 m-0">  -->
          <!-----one------>
          <!-- <<div class="one col-lg-4 col-md-12 col-sm-12 p-0">
            <img class="" src="assets/imgs/em_1.jpg">
            <div class="details">
              <h2>Naya Naya Shoes</h2>
              <button class="text-uppercase">Shop now</button>
            </div>
          </div>  -->
          <!-----Two------>
          <!-- <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
            <img class="" src="assets/imgs/dye2.jpg">
            <div class="details">
              <h2>Featured Shoes</h2>
              <button class="text-uppercase">Shop now</button>
            </div>
          </div> -->
          <!-----Three------>
          <!-- <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
            <img class="" src="assets/imgs/pearl1.jpg">
            <div class="details">
              <h2>50% off Shoes</h2>
              <button class="text-uppercase">Shop now</button>
            </div>
          </div>
        </div>
      </section> -->


      
      <!-- ----------------------Feature/embroidery------------------ -->
    <section id="feature" class="my-5 pb-3">
        <div class="container text-center mt-3 py-3">
          <h3>Our Featured Shoes</h3>
          <hr/>
          <p>Here you can check out our new featured shoes</p>
        </div>
        <div class="row mx-auto container-fluid">
          <?php  include('server/get_featured_products.php'); ?>
          
          <?php while($row = $featured_products->fetch_assoc()){ ?>  


        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-5" src="assets/imgs/<?php echo $row['product_image'];?>"/>
            <div class="star">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <h5 class="p-name"> <?php echo $row ['product_name']; ?></h5>
            <h4 class="p-price">$ <?php echo $row ['product_price']; ?></h4>
            <a href="<?php echo "single_prdt.php?product_id=". $row['product_id'];?>"><span class="buy-btn">Buy Now</span></a>
          </div>
        <!------------------->
       <?php } ?>  
      </div>
    </section>
<!-------------------------- wedding ----------------------->
    <section id="feature" class="my-5 pb-5">
        <div class="container text-center mt-5 py-5">
          <h3>Our Wedding Shoes</h3>
          <hr/>
          <p>Here you can check out our new Wedding shoes</p>
        </div>
        <div class="row mx-auto container-fluid">
          <?php  include('server/get_wedding.php'); ?>
          
          <?php while($row = $wedding->fetch_assoc()){ ?>  


        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-5" src="assets/imgs/<?php echo $row['product_image'];?>"/>
            <div class="star">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <h5 class="p-name"> <?php echo $row ['product_name']; ?></h5>
            <h4 class="p-price">$ <?php echo $row ['product_price']; ?></h4>
            <a href="<?php echo "single_prdt.php?product_id=". $row['product_id'];?>"><span class="buy-btn">Buy Now</span></a>

          </div>
        <!------------------->
       <?php } ?>  
      </div>
    </section>
<!-------------------------- handpaint ----------------------->
    <section id="feature" class="my-5 pb-5">
        <div class="container text-center mt-5 py-5">
          <h3>Our Hand_Painted Shoes</h3>
          <hr/>
          <p>Here you can check out our new Hand_Painted shoes</p>
        </div>
        <div class="row mx-auto container-fluid">
          <?php  include('server/get_hand.php'); ?>
          
          <?php while($row = $handpaint->fetch_assoc()){ ?>  


        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-5" src="assets/imgs/<?php echo $row['product_image'];?>"/>
            <div class="star">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <h5 class="p-name"> <?php echo $row ['product_name']; ?></h5>
            <h4 class="p-price">$ <?php echo $row ['product_price']; ?></h4>
            <a href="<?php echo "single_prdt.php?product_id=". $row['product_id'];?>"><span class="buy-btn">Buy Now</span></a>
          </div>
        <!------------------->
       <?php } ?>  
      </div>
    </section>


    
    <?php  include('layouts/footer.php') ?>