<?php
include '../admin_panel/config/dbconnect.php';
header('Content-Type: application/json');

$sql = "SELECT * FROM product";
$result = $conn->query($sql);

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}
echo json_encode($products);
?>