
<?php  
session_start();

// include('../server/connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fancy Shoe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="assets/css/sty.css"/>
</head>
<body>
    <!--navbar-->
      <nav class="navbar navbar-expand-lg navbar-light bg-light py-3 fixed-top">
        <div class="container">
          <img src="assets/imgs/l6.jpg">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

              <li class="nav-item">
                <a class="nav-link active" href="index.php">Home</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="shop.php">Shop</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="contact.php">Contact Us</a>
              </li>

              <li class="nav-item">
                <a href="cart.php">
                  <i class="fas fa-shopping-bag">
                  <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) { ?>
                  <?php if(isset($_SESSION['quantity']) && $_SESSION['quantity'] !=0 ) { ?>
                    <span class="cart-quantity"><?php  echo $_SESSION['quantity']; ?></span>
                  <?php } ?>
                  <?php } ?>
                </i>
              </a>
                <a href="account.php"><i class="fas fa-user"></i></a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
