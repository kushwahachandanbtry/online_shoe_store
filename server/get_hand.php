<?php
include('server/connection.php');

$stmt = $conn->prepare("SELECT * FROM products WHERE product_category='handpaint' LIMIT 4");
$stmt->execute();
$handpaint = $stmt->get_result();
?>