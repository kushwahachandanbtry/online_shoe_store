<?php include('../server/connection.php'); 

if(isset($_POST['create_product'])){

    $product_name = $_POST['name'];
    $product_description = $_POST['description'];
    $product_price = $_POST['price'];
    $product_category = $_POST['category'];
    $sizes = $_POST['sizes'];
    $stock =$_POST['stock'];

    $image1 = $_FILES['image1']['tmp_name'];
    $image2 = $_FILES['image2']['tmp_name'];
    $image3 = $_FILES['image3']['tmp_name'];
    $image4 = $_FILES['image4']['tmp_name'];
    // $file_name = $_FILES['image1']['tmp_name'];

    $image_name1 = $product_name."1.jpg";
    $image_name2 = $product_name."2.jpg";
    $image_name3 = $product_name."3.jpg";
    $image_name4 = $product_name."4.jpg";

    move_uploaded_file($image1,"../assets/imgs/". $image_name1 );
    move_uploaded_file($image2,"../assets/imgs/". $image_name2 );
    move_uploaded_file($image3,"../assets/imgs/". $image_name3 );
    move_uploaded_file($image4,"../assets/imgs/". $image_name4);

    //create new user
    $stmt = $conn->prepare("INSERT INTO products (product_name, product_description, product_price, product_category, sizes, stock,
                            product_image, product_image2, product_image3, product_image4)
                            VALUES (?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param('ssssssssss',$product_name, $product_description,$product_price, $product_category, $sizes, $stock, $image_name1,$image_name2,$image_name3,$image_name4);

    if($stmt->execute()){
        header('location: products.php?product_created=Product has been added');
    }else{
        header('location: products.php?product_failed=Error occured, try again later!');
    }

}

?>
