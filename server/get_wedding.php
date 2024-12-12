<?php
include('server/connection.php');

$stmt = $conn->prepare("SELECT * FROM products WHERE product_category='wedding' LIMIT 4");
$stmt->execute();
$wedding = $stmt->get_result();
?>