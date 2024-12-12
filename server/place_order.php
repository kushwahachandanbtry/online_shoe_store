<?php
session_start();
include('connection.php');

// if user is not lOgged in
if(!isset($_SESSION['logged_in'])){
    header('location: ../checkout.php?message=Please Login/Register to place an order');
    exit;
    
}else{

    if(isset($_POST['place_order'])){
        //1. get user info and store in DB
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $city = $_POST['city'];
            $address = $_POST['address'];
            $order_cost = $_SESSION['total'];
            $order_status = "not paid";
            $user_id = $_SESSION['user_id'];
            $order_date = date('Y-m-d H:i:s');
        
            $stmt = $conn->prepare("INSERT INTO orders (order_cost, order_status, user_id, 
                                                        user_phone, user_city, user_address, order_date)
                                                        VALUES (?,?,?,?,?,?,?);");
            $stmt->bind_param('isiisss', $order_cost,$order_status,$user_id,$phone,$city,$address,$order_date);
            
            $stmt_status=$stmt->execute();
        
            if(!$stmt_status){
                header('location: index.php');    
                exit;
            }   
            // dfdfdfdf
        
            //2. store order info in DB
            $order_id = $stmt->insert_id;
        
        
            //3. get products from cart from session 
         
            foreach($_SESSION['cart'] as $key => $value){
                $product = $_SESSION['cart'] [$key];
                $product_id = $product['product_id'];
                $product_name = $product['product_name'];
                $product_image = $product['product_image'];
                $product_price = $product['product_price'];
                $product_quantity = $product['product_quantity'];
                $shoe_size = $product['size'];

                //check stock before placing the order
                $stmt_stock = $conn->prepare("SELECT stock FROM products WHERE product_id = ?");
                $stmt_stock->bind_param('i', $product_id);
                $stmt_stock->execute();
                $result_stock = $stmt_stock->get_result();
        
                if ($result_stock->num_rows > 0) {
                    $product_stock = $result_stock->fetch_assoc()['stock'];
        
                    // Check if enough stock is available
                    if ($product_stock >= $product_quantity) {
                        // Store each single item in order_items DB
                        $stmt1 = $conn->prepare ("INSERT INTO order_items (order_id, product_id, product_name, 
                                                                product_image,product_price,product_quantity, 
                                                                user_id, order_date, select_size)
                                                                VALUES (?,?,?,?,?,?,?,?,?)");
                        $stmt1->bind_param('iissiiiss', $order_id, $product_id, $product_name, $product_image, $product_price, $product_quantity,$user_id, $order_date,$shoe_size);
                        $stmt1->execute();
                        // Update the stock in the products table
                        $new_stock = $product_stock - $product_quantity;
                        $stmt_update = $conn->prepare("UPDATE products SET stock = ? WHERE product_id = ?");
                        $stmt_update->bind_param('ii', $new_stock, $product_id);
                        $stmt_update->execute();
                    } else {
                        // Handle insufficient stock case
                        echo '<script>alert("Not enough stock for product ID: ' . $product_id . '");</script>';
                    }
                }
            }
                        
    
        
        //5.----remove everything from cart--delay
        unset($_SESSION['cart']);
        unset($_SESSION['total']); // Clear total as well
        $_SESSION['quantity'] = 0;
        
        // $_SESSION['order_id']= $order_id;
        
        
        //6.inform user whether everything is fine or if there is problem
        header ('location: ../payment.php?order_status=You have placed an order.');
        exit;
}

}


?>