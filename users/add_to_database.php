<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'db.php';

// Get order details from POST request
$orderDetails = json_decode(file_get_contents('php://input'), true);

// Debug: Log the received order details to a file
error_log(print_r($orderDetails, true), 3, "debug.log");

session_start();

if (!isset($_SESSION['username'])) {
    die("User not logged in");
}

$user = $_SESSION['username'];

// Get user ID
$sql = "SELECT user_id FROM users WHERE username = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("User not found");
}

$row = $result->fetch_assoc();
$user_id = $row['user_id'];

// Insert orders
$date = date('Y-m-d');

// Use prepared statements for secure insertion
$stmt = $con->prepare("INSERT INTO orders 
    (title, price, quantity, subtotal_amount, date, invoice_number, user_id, pay_method, order_status, pay_status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pending', 'Unpaid')");

foreach ($orderDetails as $order) {
    $title = $order['title'];
    $price = floatval($order['price']);
    $quantity = intval($order['quantity']);
    $subtotal = floatval($order['subtotal_amount']);
    $invoice = $order['invoice_number'];
    $pay_method = $order['pay_method'] ?? '';

    $stmt->bind_param(
        "sddissis", // string, double, double, integer, string, string, integer, string
        $title, $price, $quantity, $subtotal, $date, $invoice, $user_id, $pay_method
    );

    if (!$stmt->execute()) {
        error_log("Error: " . $stmt->error . "\n", 3, "debug.log");
    }
}
$stmt->close();

$con->close();
echo "Orders added successfully!";
?>

