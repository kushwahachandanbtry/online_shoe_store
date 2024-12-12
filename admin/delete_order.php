<?php  
session_start();
include('../server/connection.php');

if(!isset($_SESSION['admin_logged_in'])){
  header('location: login.php');
  exit();
}

if(isset($_GET['order_id'])){
    $order_id = $_GET['order_id'];
     // 2. return number of products
    $stmt = $conn->prepare("DELETE  FROM orders WHERE order_id=?");
    $stmt->bind_param('i', $order_id);
    $stmt->execute();

    if($stmt->execute()){
        header('location: index.php?order_deleted=order was deleted successfully');

    }else{
        header('location: index.php?order_deleted_failed= Could not delete order');
    }
          
}

?>