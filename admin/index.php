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
            $stmt1 = $conn->prepare("SELECT COUNT(*) As total_records FROM orders");
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
            $stmt2 = $conn->prepare("
            SELECT o.order_id, o.order_status, oi.product_name, oi.product_quantity, oi.select_size, o.user_name, o.order_date, o.user_phone
            FROM orders o
            JOIN order_items oi ON o.order_id = oi.order_id
            LIMIT ?, ?
        ");
        
        $stmt2->bind_param('ii', $offset, $total_records_per_page);
        $stmt2->execute();

        $orders = $stmt2->get_result();
          




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

          
          <h2>Orders</h2>
          <?php if(isset($_GET['order_updated'])){ ?>
            <p class="text-center" style="color: green;"><?php echo $_GET['order_updated']; ?></p>
            <?php } ?>

            <?php if(isset($_GET['order_failed'])){ ?>
            <p class="text-center" style="color: red;"><?php echo $_GET['order_failed']; ?></p>
            <?php } ?>

            <?php if(isset($_GET['order_deleted'])){ ?>
            <p class="text-center" style="color: green;"><?php echo $_GET['order_deleted']; ?></p>
            <?php } ?>

            <?php if(isset($_GET['order_deleted_failed'])){ ?>
            <p class="text-center" style="color: red;"><?php echo $_GET['order_deleted_failed']; ?></p>
            <?php } ?>


            <div class="table-responsive w-100">
              <table class="table table-striped table-sm">
                <thead>
                  <tr>
                    
                    <th scope="col">Order Id</th>
                
                    <th scope="col">Product Name</th>
                    <th scope="col">Ordered Quantity</th>
                    <th scope="col">Shoe Size</th>
                    
                    <th scope="col">Order date</th>
                    <th scope="col">User Phone</th>
                    
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                  </tr>
               </thead>

               <tbody>
               
               <?php foreach($orders as $order) { ?>
                <tr>
                <td><?php echo $order['order_id']; ?></td>
                <td><?php echo $order['product_name']; ?></td>
                <td><?php echo $order['product_quantity']; ?></td>
                <td><?php echo $order['select_size']; ?></td>
                
                <td><?php echo $order['order_date']; ?></td>
                <td><?php echo $order['user_phone']; ?></td>
                <td><a class="btn btn-primary" href="edit_order.php?order_id=<?php echo $order['order_id'];?>">Edit</a></td>
                <td><a class="btn btn-danger" href="delete_order.php?order_id=<?php echo $order['order_id'];?>">Delete</a></td>
                </tr>
                <?php } ?>
               </tbody>
              </table>
              



    </body>
</html>
