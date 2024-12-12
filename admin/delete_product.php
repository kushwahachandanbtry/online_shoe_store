<?php  
session_start();
include('../server/connection.php');

if(!isset($_SESSION['admin_logged_in'])){
  header('location: login.php');
  exit();
}

if(isset($_GET['product_id'])){
    $product_id = $_GET['product_id'];

     // 2. return number of products
    $stmt = $conn->prepare("DELETE  FROM products WHERE product_id=?");
    $stmt->bind_param('i',$product_id);
    $stmt->execute();

    if($stmt->execute()){
        header('location: products.php?deleted_successfully=Product was deleted successfully');

    }else{
        header('location: products.php?deleted_failure= Could not delete Product');
    }
          
}

?>