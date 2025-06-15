<?php
include("auth_session.php");
include("db.php");

header('Content-Type: application/json');

$user = $_SESSION['username'];
$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Get user ID
$sql = "SELECT user_id FROM users WHERE username = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$user_id = $row['user_id'];

// Map status numbers to text
$statusMap = [
    0 => 'pending',
    1 => 'delivered'
];

// Build query
$query = "SELECT * FROM orders WHERE user_id = ?";
$params = [$user_id];
$types = "i";

if ($statusFilter !== 'all') {
    // Convert status text back to number
    $statusNumber = array_search($statusFilter, $statusMap);
    $query .= " AND order_status = ?";
    $params[] = $statusNumber;
    $types .= "i";
}

if (!empty($searchTerm)) {
    $query .= " AND invoice_number LIKE ?";
    $params[] = "%$searchTerm%";
    $types .= "s";
}

$query .= " ORDER BY date DESC";

$stmt = $con->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$orderItems = $stmt->get_result();

// Group items by invoice number
$orders = [];
while($item = $orderItems->fetch_assoc()) {
    $invoice = $item['invoice_number'];

    // Convert status number to text
    $statusText = isset($statusMap[$item['order_status']]) ? $statusMap[$item['order_status']] : 'unknown';

    if (!isset($orders[$invoice])) {
        $orders[$invoice] = [
            'invoice' => $invoice,
            'date' => $item['date'],
            'status' => $statusText,
            'type' => $item['order_type'],
            'payment_method' => $item['pay_method'],
            'payment_status' => $item['pay_status'],
            'total' => 0,
            'items' => [],
            'delivery_address' => [
                'street' => $item['street'] ?? '',
                'barangay' => $item['barangay'] ?? '',
                'city' => $item['city'] ?? '',
                'phone' => $item['phone'] ?? ''
            ]
        ];
    }
    
    // Add item to order
    $orders[$invoice]['items'][] = [
        'title' => $item['title'],
        'price' => $item['price'],
        'quantity' => $item['quantity'],
        'subtotal' => $item['subtotal_amount']
    ];
    
    // Add to total
    $orders[$invoice]['total'] += $item['subtotal_amount'];
}

// Convert associative array to indexed array
$result = array_values($orders);

echo json_encode($result);
exit;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">My Orders</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Invoice #</th>
                        <th>Title</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                        <th>Order Type</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th>Payment Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($orders->num_rows === 0): ?>
                        <tr>
                            <td colspan="10" class="text-center">No orders found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($result as $order): ?>
                        <tr>
                            <td><?= htmlspecialchars($order['date']) ?></td>
                            <td><?= htmlspecialchars($order['invoice']) ?></td>
                            <td>
                                <?php foreach($order['items'] as $item): ?>
                                    <?= htmlspecialchars($item['title']) ?><br>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <?php foreach($order['items'] as $item): ?>
                                    <?= htmlspecialchars($item['quantity']) ?><br>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <?php foreach($order['items'] as $item): ?>
                                    ₱<?= htmlspecialchars($item['price']) ?><br>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <?php foreach($order['items'] as $item): ?>
                                    ₱<?= htmlspecialchars($item['subtotal']) ?><br>
                                <?php endforeach; ?>
                            </td>
                            <td><?= htmlspecialchars($order['type']) ?></td>
                            <td><?= htmlspecialchars($order['payment_method']) ?></td>
                            <td><?= htmlspecialchars($order['status']) ?></td>
                            <td><?= htmlspecialchars($order['payment_status']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <a href="index.php" class="btn btn-secondary">Back to Home</a>
    </div>
</body>
</html>