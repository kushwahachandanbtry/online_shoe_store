<?php
include('server/connection.php');

$stmt = $conn->prepare("SELECT * FROM products WHERE product_category='dye' LIMIT 4");
$stmt->execute();
$dye = $stmt->get_result();
?>