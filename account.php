<?php  include('layouts/header.php') ?>
<?php

include('server/connection.php');
if(!isset($_SESSION['logged_in'])){
  header('location:login.php');
  exit;
}

if(isset($_GET['logout'])){
  if(isset($_SESSION['logged_in'])){
    unset($_SESSION['logged_in']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_name']);
    header('location: index.php');
    exit;
  }
}


if(isset($_POST['change_password'])){
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];
  $user_email = $_SESSION['user_email'];

  if($password !== $confirmPassword){
    header('location: account.php?error=password wont match!');
  }else if(strlen($password)<6){
    header('location: account.php?error=Password must be more than 6 character!');
  }else if(!preg_match("/^(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[!@\#$%^&*()_+\-=\{\};:'<>,\.\/?]).{6,}$/", $password)){
    header('location: account.php?error=password must contain at least one letter, one number and one special character!');
  }else{  //incase no error occur
    $stmt=$conn->prepare("UPDATE users SET user_password=? WHERE user_email=?");
    $stmt->bind_param('ss', md5($password), $user_email);

    if($stmt->execute()){
      header('location:account.php?message=Password has been Updated successfuy');
    }else{
      header('location: account.php?error=Could not update password');
    }
  }
}


//get orders
if(isset($_SESSION['logged_in'])){
  $user_id = $_SESSION['user_id'];

  $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id=?");

  $stmt->bind_param('i', $user_id);

  $stmt->execute();
  
  $orders =  $stmt->get_result();

}


?>

    <!------ACCOUNT------>
    <section class= "my-5 py-5">
      <div class="row container mx-auto">
        <div class="text-center mt-3 pt-5 col-lg-6 col-md-3 col-sm-12">
        <p class="text-center " style="color: green"><?php  if(isset($_GET['register_success'])){ echo $_GET['register_success'];}?></p>
        <p class="text-center " style="color: green"><?php  if(isset($_GET['login_success'])){ echo $_GET['login_success'];}?></p>

          <h3 class="font-weght-bold">Account info</h3>
          <hr class="mx-auto">
          <div class="account-info">
            <p>Name: <span> <?php if(isset($_SESSION['user_name'])){echo $_SESSION['user_name'];}?>  </span> </p>
            <p>Email: <span><?php if(isset($_SESSION['user_email'])){echo $_SESSION['user_email'];}?></span></p>
            <p><a href="#orders" id="order-btn">Your orders</a> </p>
            <p><a href="account.php?logout=1" id="logout-btn">Logout</a></p>
          </div>
        </div>

        <div class="col-lg-6 col-md-12 col-sm-12">
          <form id="account-form" method="POST" action="account.php">
          <p class="text-center " style="color: red"><?php  if(isset($_GET['error'])){ echo $_GET['error'];}?></p>
          <p class="text-center " style="color: green"><?php  if(isset($_GET['message'])){ echo $_GET['message'];}?></p>


            <h3>Change password</h3>
            <hr class="mx-auto">
            <div class="form-group">
              <label>Password</label>
              <input type="password" id="account-password" class="form-control" name="password" placeholder="required"/>
            </div>
            <div class="form-group">
              <label>Confirm Password</label>
              <input type="password" id="account-password-confirm" class="form-control" name="confirmPassword" placeholder="required"/>
            </div>
            <div class="form-group">
              <input type="submit" id="change-pass-btn" class="btn" name="change_password" value="submit" />
            </div>
          </form>
        </div>
      </div>     
    </section>



          <!------------------Orders--------------->   
    <section id="orders" class="orders container my-5 py-3">
      <div class="container mt-2">
        <h2 class="font-weignt-bold text-center">Your Orders</h2>
        <hr class="mx-auto">
      </div>
        <table class="mt-5 pt-5">
          <tr>
            <th>Order id</th>
            <th>Order cost</th>
            <th>Order date</th>
            <th>Order details</th>
          </tr>

          <?php while($row = $orders->fetch_assoc()){ ?>

                <tr>
                  <td>
                    <!-- <?php echo $row['order_id'];?> -->
                    <span class="user_order_detail"><?php echo $row['order_id'];?></span>
                    
                  </td>
                  <td>
                    <span class="user_order_detail"><?php echo $row['order_cost'];?></span>
                  </td>
                 
                  
                  <td>
                    <span class="user_order_detail"><?php echo $row['order_date'];?></span>
                  </td>

                  <td>
                    <form action="order_details.php" method="POST">
                      <input type="hidden" value="<?php echo $row['order_status'];?>" name = "order_status"/>
                      <input type="hidden" value="<?php echo $row['order_id'];?>" name="order_id"/>
                      <input type="submit" class="btn order-details-btn" value="details" name="order_details_btn" style="font-weight: bold"/>
                    </form>
                  </td>

                </tr>
                <?php  }  ?>

        </table>
      
    </section>
    <?php  include('layouts/footer.php') ?>
