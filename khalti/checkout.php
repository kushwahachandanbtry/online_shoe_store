<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khalti Payment Integration</title>

    <!-- bootstrap css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="m-4">
    <?php
    session_start();
    if (isset($_SESSION['transaction_msg'])) {
        echo $_SESSION['transaction_msg'];
        unset($_SESSION['transaction_msg']);
    }

    if (isset($_SESSION['validate_msg'])) {
        echo $_SESSION['validate_msg'];
        unset($_SESSION['validate_msg']);
    }

    if( !empty( $_SESSION['cart'] ) ) {
        include '../server/connection.php';
    $product_ids = array_keys($_SESSION['cart']);
    $order_date = date("Y-m-d"); // Correct date format

    // Prepare a SQL statement for inserting the order
    $sql = "INSERT INTO orders (order_id, user_name, product_name, product_quantity, order_cost, order_status, user_id, user_phone, user_city, user_address, order_date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Example values for missing fields (replace with actual session data if available)
    $product_name = implode(", ", $product_ids); // Combine product IDs as a placeholder for product names
    $product_quantity = count($_SESSION['cart']); // Example: number of products in the cart
    $order_cost = $_SESSION['total'];
    $order_status = "not paid";
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
    $user_phone = "000-000-0000"; // Placeholder, replace with actual data
    $user_city = "City";          // Placeholder
    $user_address = "Address";    // Placeholder

    // Bind parameters
    $stmt->bind_param(
        "isssdsissss",
        $product_ids[0],
        $user_name,
        $product_name,
        $product_quantity,
        $order_cost,
        $order_status,
        $user_id,
        $user_phone,
        $user_city,
        $user_address,
        $order_date
    );

    // Execute the statement
    $stmt->execute();
       


    ?>
    <h1 class="text-center">Pay with Khalti</h1>
    <div class="d-flex justify-content-center mt-3">
        <form class="row g-3 w-50 mt-4" action="payment-request.php" method="POST">
            <label for="">Details:</label>
            <div class="col-md-6">
                <label for="inputAmount4" class="form-label">Amount</label>
                <input type="Amount" class="form-control" readonly value="<?php echo $_SESSION['total']; ?>" id="inputAmount4" name="inputAmount4">
            </div>
            <div class="col-md-6">
                <label for="inputPurchasedOrderId4" class="form-label">Id</label>
                <input type="PurchasedOrderId" readonly value="<?php echo $product_ids[0]; ?>" class="form-control" id="inputPurchasedOrderId4" name="inputPurchasedOrderId4">
            </div>
            <div class="col-12">
                <label for="inputPurchasedOrderName" class="form-label">Statement</label>
                <input type="text" class="form-control" id="inputPurchasedOrderName" name="inputPurchasedOrderName">
            </div>
            <div class="col-12">
                <label for="inputName" class="form-label">Username</label>
                <input type="text" readonly value="<?php echo $_SESSION['user_name']; ?>" class="form-control" id="inputName" name="inputName">
            </div>
            <div class="col-md-6">
                <label for="inputEmail" class="form-label">Email</label>
                <input type="text" readonly value="<?php echo $_SESSION['user_email']; ?>" class="form-control" id="inputEmail" name="inputEmail">
            </div>
            <div class="col-md-6">
                <label for="inputPhone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="inputPhone" name="inputPhone">
            </div>
            <div class="col-12">
                <button type="submit" name="submit" class="btn btn-primary">Pay with khalti</button>
            </div>
        </form>
    </div>
</body>

</html>
<?php } ?>
