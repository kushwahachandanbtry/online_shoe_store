<?php  include('header.php'); ?>

<?php  
    if(isset($_GET['order_id'])){
        $order_id =$_GET['order_id'];
        
        $stmt = $conn->prepare("
        SELECT oi.product_name, oi.product_quantity, oi.select_size AS shoe_size, o.order_id, o.order_cost, o.order_status, o.order_date, u.user_name
        FROM order_items oi
        JOIN `orders` o ON oi.order_id = o.order_id
        JOIN users u ON o.user_id = u.user_id
        WHERE o.order_id = ?
          ");
        $stmt->bind_param('i', $order_id);
        $stmt->execute();
        $order = $stmt->get_result();

    }else if(isset($_POST['edit_order'])){
        $order_status = $_POST['order_status'];
        $order_id = $_POST['order_id'];


        $stmt=$conn->prepare("UPDATE orders SET order_status=? WHERE order_id=?");
        $stmt->bind_param('si', $order_status, $order_id );

        if( $stmt->execute()){
        header('location: index.php?order_updated=Order has been updated');
        }else{
            header('location: order.php?order_failed=Error occured try again!');
        }
    }else{

        header('location: index.php');
        exit;
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
            <h2>Edit Order</h2>
            <div class="table-responsive ">


                <div class="mx-auto ">
                    <form id="edit-order-form" method="POST" action="edit_order.php">

                    <?php foreach($order as $r) {?>
                        <p style="color: red;"><?php if(isset($_GET['error'])){ echo $_GET['error'];}?></p>

                        <div class="form-group mt-2">
                            <label>Order Id</label>
                            <p class="my-4"><?php echo $r['order_id']; ?></p>
                        </div>

                        <div class="form-group mt-2">
                            <label>Order Price</label>
                            <p class="my-4">$<?php echo $r['order_cost']; ?></p>
                        </div>

                        <div class="form-group mt-2">
                            <label>Ordered Quantity</label>
                            <p class="my-4"><?php echo $r['product_quantity']; ?></p>
                        </div>
                        
                        <div class="form-group mt-2">
                            <label>Product Name</label>
                            <p class="my-4"><?php echo $r['product_name']; ?></p>
                        </div>

                        <div class="form-group mt-2">
                            <label>Shoe Size</label>
                            <p class="my-4"><?php echo $r['shoe_size']; ?></p>
                        </div>

                        <div class="form-group mt-2">
                            <label>Ordered By</label>
                            <p class="my-4"><?php echo $r['user_name']; ?></p>
                        </div>

                        <input type="hidden" name="order_id" value="<?php echo $r['order_id']; ?>"/>

                        <div class="form-group my-2">
                            <label>Order Status</label>
                            <select class="form-select" required name="order_status">
                                
                                <option value="not paid" <?php if($r['order_status']=='not paid') {echo "selected";} ?> >Not paid</option>
                                <option value="paid" <?php if($r['order_status']=='paid') {echo "selected";} ?>>paid</option>
                                <option value="collected" <?php if($r['order_status']=='collected') {echo "selected";} ?>>Collected</option>
                                <option value="ready" <?php if($r['order_status']=='ready') {echo "selected";} ?>>Ready for pick up</option>
                            </select>
                        </div>

                        <div class="form-group mt-2">
                            <label>Order Date</label>
                            <p class="my-4"><?php echo $r['order_date']; ?></p>
                        </div>
                       
                        <div class="form-group mt-3">
                            <input type="submit" class="btn btn-primary" id="edit-btn" name="edit_order" value="Edit"/>
                        </div>

                    <?php } ?>

                    </form>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>
