<?php
// Start output buffering at the very top
ob_start();

ini_set('display_errors', 0); // Disable displaying errors to output
ini_set('log_errors', 1); // Enable error logging
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Determine if this is an AJAX request
$isAjax = isset($_GET['ajax']) || isset($_GET['status']);

if ($isAjax) {
    header('Content-Type: application/json');
} else {
    header('Content-Type: text/html');
}

try {
    if (!isset($_SESSION['username'])) {
        throw new Exception('User not authenticated');
    }

    include("auth_session.php");
    include("db.php");

    $user = $_SESSION['username'];
    $statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';

    // Get user ID
    $sql = "SELECT user_id FROM users WHERE username = ?";
    $stmt = $con->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $con->error);
    }
    
    $stmt->bind_param("s", $user);

    if (!$stmt->execute()) {
        throw new Exception("Failed to execute user query: " . $stmt->error);
    }

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        throw new Exception("User not found in database");
    }

    $user_id = $row['user_id'];

    // Map status to user-friendly categories (updated to match new values)
    $statusMap = [
        'to-pay'     => ['pay_status' => 0, 'order_status' => 0], // To Pay: unpaid, pending
        'to-ship'    => ['pay_status' => 1, 'order_status' => 0], // To Ship: paid, pending
        'to-receive' => ['pay_status' => 1, 'order_status' => 1], // To Receive: paid, processing
        'delivered'  => ['order_status' => 2]                     // Delivered: delivered
    ];

    // Build query
    $query = "SELECT * FROM orders WHERE user_id = ?";
    $params = [$user_id];
    $types = "i";

    if ($statusFilter !== 'all' && isset($statusMap[$statusFilter])) {
        $filter = $statusMap[$statusFilter];

        if (isset($filter['pay_status'])) {
            $query .= " AND pay_status = ?";
            $params[] = $filter['pay_status'];
            $types .= "i";
        }

        if (isset($filter['order_status'])) {
            $query .= " AND order_status = ?";
            $params[] = $filter['order_status'];
            $types .= "i";
        }
    }

    $query .= " ORDER BY date DESC";

    $stmt = $con->prepare($query);
    
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $con->error);
    }

    // Bind parameters dynamically
    if (count($params) > 0) {
        $stmt->bind_param($types, ...$params);
    }

    if (!$stmt->execute()) {
        throw new Exception("Failed to execute orders query: " . $stmt->error);
    }

    $orderItems = $stmt->get_result();

    // Group items by invoice number
    $orders = [];
    while($item = $orderItems->fetch_assoc()) {
        $invoice = $item['invoice_number'];

        if (!isset($orders[$invoice])) {
            $orders[$invoice] = [
                'invoice' => $invoice,
                'date' => $item['date'],
                'status' => $item['order_status'],
                'pay_status' => $item['pay_status'],
                'type' => $item['order_type'],
                'payment_method' => $item['pay_method'],
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

    // For AJAX requests, output JSON and exit
    if ($isAjax) {
        // Clear any previous output
        ob_end_clean();
        echo json_encode($result);
        exit;
    }

} catch (Exception $e) {
    // Clear any previous output
    ob_end_clean();
    
    if ($isAjax) {
        echo json_encode(['error' => $e->getMessage()]);
        exit;
    }
    
    $error = $e->getMessage();
}

// For HTML output, flush the buffer
ob_end_flush();
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
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
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
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($result)): ?>
                        <tr>
                            <td colspan="11" class="text-center">No orders found.</td>
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
                            <td><?= htmlspecialchars($order['pay_status']) ?></td>
                            <td>
                                <button class="btn btn-details">
                                    <i class="fas fa-eye"></i> Details
                                </button>
                            </td>
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