<?php
include('server/connection.php');

$stmt = $conn->prepare("SELECT * FROM products WHERE product_category='embroidery' LIMIT 4");
$stmt->execute();
$embroidery= $stmt->get_result();
?>