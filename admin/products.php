<?php include('header.php');?>
<?php  

if(!isset($_SESSION['admin_logged_in'])){
  header('location: login.php');
  exit();
}




            //1. determine page no
            if(isset($_GET['page_no']) && $_GET['page_no'] !="" ){
              //if user has already entered page then page number is the one that they seleccted
              $page_no = $_GET['page_no'];
            }else{

              //if user just entered the page the default page is 1
                $page_no = 1;
            }
            // 2. return number of products
            $stmt1 = $conn->prepare("SELECT COUNT(*) As total_records FROM products");
            $stmt1->execute();
            $stmt1->bind_result($total_records);
            $stmt1->store_result();
            $stmt1->fetch();

            // 3. products per page(concept of pagination)
            $total_records_per_page = 5;
            $offset = ($page_no -1) * $total_records_per_page;
            $previous_page = $page_no - 1;
            $next_page = $page_no + 1;
            $adjacents = "2";
            $total_no_of_pages = ceil($total_records/$total_records_per_page);

            // 4. get all products
            $stmt2 = $conn->prepare("SELECT * FROM products LIMIT $offset,$total_records_per_page ");
            $stmt2->execute();
            $products = $stmt2->get_result();
          




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

          <h2>Products</h2>
          <?php if(isset($_GET['edit_success_message'])){ ?>
            <p class="text-center" style="color: green;"><?php echo $_GET['edit_success_message']; ?></p>
            <?php } ?>

            <?php if(isset($_GET['edit_failure_message'])){ ?>
            <p class="text-center" style="color: red;"><?php echo $_GET['edit_failure_message']; ?></p>
            <?php } ?>


            <?php if(isset($_GET['deleted_failure'])){ ?>
            <p class="text-center" style="color: red;"><?php echo $_GET['deleted_failure']; ?></p>
            <?php } ?>

            <?php if(isset($_GET['deleted_successfully'])){ ?>
            <p class="text-center" style="color: green;"><?php echo $_GET['deleted_successfully']; ?></p>
            <?php } ?>

            <?php if(isset($_GET['product_created'])){ ?>
            <p class="text-center" style="color: green;"><?php echo $_GET['product_created']; ?></p>
            <?php } ?>

            <?php if(isset($_GET['product_failed'])){ ?>
            <p class="text-center" style="color: red;"><?php echo $_GET['product_failed']; ?></p>
            <?php } ?>

            <?php if(isset($_GET['images_updated'])){ ?>
            <p class="text-center" style="color: green;"><?php echo $_GET['images_updated']; ?></p>
            <?php } ?>

            <?php if(isset($_GET['images_failed'])){ ?>
            <p class="text-center" style="color: red;"><?php echo $_GET['images_failed']; ?></p>
            <?php } ?>


            <div class="table-responsive w-100">
              <table class="table table-striped table-sm">
                <thead>
                  <tr>
                    
                    <th scope="col">Product Id</th>
                    <th scope="col">Product Image</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Product Price</th>
                    <th scope="col">Product Category</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Sizes</th>
                    <th scope="col">Edit Image</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                  </tr>
               </thead>

               <tbody>
               
               <?php foreach($products as $product) { 
                $stmt3 = $conn->prepare("SELECT SUM(product_quantity) as total_ordered from order_items where product_id=?");
                if($stmt3){
                $stmt3->bind_param("i", $product['product_id']);
                $stmt3->execute();
                $stmt3->bind_result($total_ordered);
                $stmt3->fetch();
                $stmt3->close();
                $remaining_stock = $product['stock'] - ($total_ordered ? $total_ordered: 0);
                }else{
                  echo "Error preparing query:" .$conn->error;
                  $remaining_stock = $product['stock'];
                }
                ?>
                <tr>
                  <td><?php  echo $product['product_id']; ?></td>
                  <td><img src="<?php  echo  "../assets/imgs/".$product['product_image']; ?>" style="width: 70px; height:70px" /></td>
                  <td><?php  echo $product['product_name']; ?></td>
                  <td>$<?php  echo $product['product_price']; ?></td>
                  <td><?php  echo $product['product_category']; ?></td>
                  
                  <td><?php  echo $product['stock']; ?></td>
                  <td><?php  echo $product['sizes']; ?></td>
                  <td><a class="btn btn-warning" href=" <?php echo "edit_images.php?product_id=".$product['product_id']."&product_name=".$product['product_name'] ; ?>">Edit Image</a></td>
                  <td><a class="btn btn-primary" href="edit_product.php?product_id=<?php echo $product['product_id']; ?>">Edit</a></td>
                  <td><a class="btn btn-danger"  href="delete_product.php?product_id=<?php echo $product['product_id']; ?>">Delete</a></td>

                </tr>
                <?php } ?>
               </tbody>
              </table>
              


    </body>
</html>
