<?php
include('layouts/header.php');
include('server/connection.php');




if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_quantity = $_POST['product_quantity'];
    $selected_size = $_POST['size'];

    // Get the current stock quantity from the database
    $stmt = $conn->prepare("SELECT stock, product_name, product_price, product_image FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $current_stock = $row['stock'];
        $product_name = $row['product_name'];
        $product_price = $row['product_price'];
        $product_image = $row['product_image'];

        // Check if the user is trying to order more products than are in stock
        if ($product_quantity > $current_stock) {
            echo '<script>alert("Sorry, we don\'t have enough stock to fulfill your order.");</script>';
        } else {
            // Add or update product in the cart
            $product_array = array(
                'product_id' => $product_id,
                'product_name' => $product_name,
                'product_price' => $product_price,
                'product_image' => $product_image,
                'product_quantity' => $product_quantity,
                'size' => $selected_size
            );

            // If the cart already exists
            if (isset($_SESSION['cart'])) {
                // Check if the product is already in the cart
                if (!array_key_exists($product_id, $_SESSION['cart'])) {
                    $_SESSION['cart'][$product_id] = $product_array;
                } else {
                  $_SESSION['cart'][$product_id]['product_quantity'] += $product_quantity;
                    echo '<script>alert("Product was already added!");</script>';
                }
            } else {
                // Create the cart if it doesn't exist
                $_SESSION['cart'][$product_id] = $product_array;
            }

            calculateTotalCart();
        }
    } else {
        echo '<script>alert("Product not found.");</script>';
    }
} elseif (isset($_POST['remove_product'])) {
    $product_id = $_POST['product_id'];
    unset($_SESSION['cart'][$product_id]);
    calculateTotalCart();
    header('Location: cart.php');
    exit();
} elseif (isset($_POST['edit_quantity'])) {
    $product_id = $_POST['product_id'];
    $product_quantity = $_POST['product_quantity'];

    // Get the current stock quantity from the database
    $stmt = $conn->prepare("SELECT stock FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $current_stock = $row['stock'];

    // Check if the new quantity exceeds available stock
    if ($product_quantity > $current_stock) {
        echo '<script>alert("Sorry, we don\'t have enough stock to fulfill your order.");</script>';
    } else {
        // Update product quantity
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['product_quantity'] = $product_quantity;
            calculateTotalCart();
        }
    }
}

function calculateTotalCart() {
    $total_price = 0;
    $total_quantity = 0;
    foreach ($_SESSION['cart'] as $key => $value) {
        $price = $value['product_price'];
        $quantity = $value['product_quantity'];
        $total_price += ($price * $quantity);
        $total_quantity += $quantity;
    }
    $_SESSION['total'] = $total_price;
    $_SESSION['quantity'] = $total_quantity;
    // echo '<pre>';
    // print_r($_SESSION['cart']);
    // echo 'Total Quantity: ' . $_SESSION['quantity'];
    // echo '</pre>';
}

if( $_SESSION['logged_in'] == 1) {
?>

<!---------Cart------------------->
<section class="cart container my-5 py-5">
    <div class="container mt-5">
        <h2 class="font-weight-bold">Your Cart</h2>
    </div>
    <table class="mt-5 pt-5">
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Size</th>
            <th>Subtotal</th>
        </tr>
        <?php if (isset($_SESSION['cart'])) { ?>
            <?php foreach ($_SESSION['cart'] as $key => $value) { ?>
                <tr>
                    <td>
                        <div class="product-info">
                            <img src="assets/imgs/<?php echo $value['product_image']; ?>">
                            <div>
                                <p><?php echo $value['product_name']; ?></p>
                                <small><span>$ </span><?php echo $value['product_price']; ?></small>
                                <br>
                                <form method="POST" action="cart.php">
                                    <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>">
                                    <input type="submit" name="remove_product" class="remove-btn bold-btn" value="remove" />
                                </form>
                            </div>
                        </div>
                    </td>
                    <td>
                        <form method="POST" action="cart.php">
                            <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>">
                            <input type="number" class="bold-input" name="product_quantity" value="<?php echo $value['product_quantity']; ?>" style="font-weight: bold;">
                            <input type="submit" name="edit_quantity" class="edit-btn bold-btn" value="edit" />
                        </form>
                    </td>
                    <td>
                        <span style="font-weight: bold;"><?php echo $value['size']; ?></span>
                    </td>
                    <td>
                        <span style="font-weight: bold;">$ </span>
                        <span class="product-price"><?php echo $value['product_quantity'] * $value['product_price']; ?></span>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
    </table>
    <div class="cart-total">
        <table>
            <tr>
                <td style="font-weight: bold;">Total</td>
                <?php if (isset($_SESSION['cart'])) { ?>
                    <td style="font-weight: bold;">$ <?php echo $_SESSION['total']; ?></td>
                <?php } ?>
            </tr>
        </table>
    </div>
    <div class="checkout-container">
    <?php if (!empty($_SESSION['cart'])) { ?>
        <form method="POST" action="khalti/checkout.php">
            <input type="submit" class="btn checkout-btn" value="Checkout" name="checkout" />
        </form>
        <?php }
        ?>
    </div>
</section>

<?php include('layouts/footer.php'); 
} else {
    header("Location:   login.php");
}

?>

