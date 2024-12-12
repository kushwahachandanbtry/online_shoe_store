<?php  include('layouts/header.php') ?>
<?php
include('server/connection.php');


if(isset($_SESSION['logged_in'])){
  header('location:account.php');
  exit;
}

if(isset($_POST['register']))
{
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];


    //if there is no error
  if($password !== $confirmPassword){
    header('location: register.php?error=password wont match!');
  }else if(strlen($password)<6){
    header('location: register.php?error=Password must be more than 6 character!');
  }else if(!preg_match("/^(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[!@\#$%^&*()_+\-=\{\};:'<>,\.\/?]).{6,}$/", $password)){
    header('location: register.php?error=password must contain at least one letter, one number and one special character!');
  } else{
    //check whether there is a user with this email OR not
      $stmt1 = $conn->prepare("SELECT count(*) FROM users where user_email=?");
      $stmt1->bind_param('s', $email);
      $stmt1->execute();
      $stmt1->bind_result($num_rows);
      $stmt1->store_result();
      $stmt1->fetch();

      //if no user registered with this email
      if($num_rows!=0){
        header('location:register.php?error= User with this email already exists!'); 
      }else{
        //creqate a new user
          $stmt=$conn->prepare("INSERT INTO users (user_name, user_email, user_password)
          
          VALUES(?,?,?)");
          $stmt->bind_param('sss', $name,$email,md5($password));
          //if account was created successflly


          if($stmt->execute()){

            $user_id=$stmt->insert_id;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_email']=$email;
            $_SESSION['user_name'] = $name;
            $_SESSION['logged_in'] = true;
            header('location:account.php?register_success=You registered successfully');
          }else{
            header('location: register.php?error=Could not create an acccount at the moment!');
          }
      }
  } 

}
?>



<?php  include('layouts/header.php') ?>
    <!--------------------REGISTER---------------------->
    <section class="my-5 py-5">
      <div class="container text-center mt-3 pt-5">
        
        <h2 class="form-weight-bold">Register</h2>
        <hr class="mx-auto">
      </div>
        <div class="mx-auto container">
          <form id="register-form" method="POST" action="register.php">
            <p style="color: red;"><?php if(isset($_GET['error'])){ echo $_GET['error'];}?></p>
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="name" id="register-name" placeholder="Type your name" required/>
              </div>

            <div class="form-group">
              <label>Email</label>
              <input type="text" class="form-control" name="email" id="register-email" placeholder="Type your email " required/>
            </div>

            
            <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control" name="password" id="register-password" placeholder="Type your password" required/>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" class="form-control" name="confirmPassword" id="register-confirm-password" placeholder="Confirm your password" required/>
              </div>

            <div class="form-group">
              
              <input type="submit" class="btn" id="register-btn" name="register" value="Register"/>
            </div>
            <div class="form-group">
              <a id="login-url" href="login.php" class="btn">Already have an account? Login</a>
            </div>

          </form>
        </div>
    </section>

    <?php  include('layouts/footer.php') ?>