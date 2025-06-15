<?php
include("auth_session.php");
include("db.php");

header('Content-Type: application/json');

if (!isset($_GET['invoice'])) {
    echo json_encode(['error' => 'Invoice number not provided']);
    exit;
}

$invoice = $_GET['invoice'];

// Verify order belongs to user
$user = $_SESSION['username'];
$user_sql = "SELECT user_id FROM users WHERE username = ?";
$user_stmt = $con->prepare($user_sql);
$user_stmt->bind_param("s", $user);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user_row = $user_result->fetch_assoc();
$user_id = $user_row['user_id'];

// Get all items for this invoice
$order_sql = "SELECT * FROM orders WHERE invoice_number = ? AND user_id = ?";
$order_stmt = $con->prepare($order_sql);
$order_stmt->bind_param("si", $invoice, $user_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();

if ($order_result->num_rows === 0) {
    echo json_encode(['error' => 'Order not found or access denied']);
    exit;
}

// Build order details
$order = null;
$items = [];
$total = 0;

while($item = $order_result->fetch_assoc()) {
    if ($order === null) {
        $order = [
            'invoice' => $item['invoice_number'],
            'date' => $item['date'],
            'status' => $item['order_status'],
            'pay_status' => $item['pay_status'],
            'type' => $item['order_type'],
            'payment_method' => $item['pay_method'],
            'delivery_address' => [
                'street' => $item['street'] ?? '',
                'barangay' => $item['barangay'] ?? '',
                'city' => $item['city'] ?? '',
                'phone' => $item['phone'] ?? ''
            ]
        ];
    }
    
    $items[] = [
        'title' => $item['title'],
        'price' => $item['price'],
        'quantity' => $item['quantity'],
        'subtotal' => $item['subtotal_amount']
    ];
    
    $total += $item['subtotal_amount'];
}

// Add items and total to order
$order['items'] = $items;
$order['total'] = $total;

echo json_encode($order);
?>