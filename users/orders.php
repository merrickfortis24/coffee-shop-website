<?php
include("auth_session.php");
include("db.php");

$user = $_SESSION['username'];
$sql = "SELECT user_id FROM users WHERE username = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$user_id = $row['user_id'];

// Fetch orders for this user
$order_sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY date DESC";
$order_stmt = $con->prepare($order_sql);
$order_stmt->bind_param("i", $user_id);
$order_stmt->execute();
$orders = $order_stmt->get_result();

if (isset($_GET['ajax'])) {
    if ($orders->num_rows === 0) {
        echo "<div>No orders found.</div>";
    } else {
        while($order = $orders->fetch_assoc()) {
            echo '<div class="cart-item mb-3 p-2" style="border-bottom:1px solid #eee;">';
            echo '<div><strong>Date:</strong> ' . htmlspecialchars($order['date']) . '</div>';
            echo '<div><strong>Invoice #:</strong> ' . htmlspecialchars($order['invoice_number']) . '</div>';
            echo '<div><strong>Title:</strong> ' . htmlspecialchars($order['title']) . '</div>';
            echo '<div><strong>Qty:</strong> ' . htmlspecialchars($order['quantity']) . '</div>';
            echo '<div><strong>Price:</strong> ₱' . htmlspecialchars($order['price']) . '</div>';
            echo '<div><strong>Subtotal:</strong> ₱' . htmlspecialchars($order['subtotal_amount']) . '</div>';
            echo '<div><strong>Order Type:</strong> ' . htmlspecialchars($order['order_type']) . '</div>';
            echo '<div><strong>Payment Method:</strong> ' . htmlspecialchars($order['pay_method']) . '</div>';
            echo '<div><strong>Status:</strong> ' . htmlspecialchars($order['order_status']) . '</div>';
            echo '<div><strong>Payment Status:</strong> ' . htmlspecialchars($order['pay_status']) . '</div>';
            echo '</div>';
        }
    }
    exit;
}
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
        <div id="orderTableContainer">
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
                    <?php while($order = $orders->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['date']) ?></td>
                        <td><?= htmlspecialchars($order['invoice_number']) ?></td>
                        <td><?= htmlspecialchars($order['title']) ?></td>
                        <td><?= htmlspecialchars($order['quantity']) ?></td>
                        <td>₱<?= htmlspecialchars($order['price']) ?></td>
                        <td>₱<?= htmlspecialchars($order['subtotal_amount']) ?></td>
                        <td><?= htmlspecialchars($order['order_type']) ?></td>
                        <td><?= htmlspecialchars($order['pay_method']) ?></td>
                        <td><?= htmlspecialchars($order['order_status']) ?></td>
                        <td><?= htmlspecialchars($order['pay_status']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <a href="index.php" class="btn btn-secondary">Back to Home</a>
    </div>

    <script>
        // AJAX request to fetch orders
        function fetchOrders() {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'path_to_your_php_file.php?ajax=true', true);
            xhr.onload = function() {
                if (this.status === 200) {
                    document.getElementById('orderTableContainer').innerHTML = this.responseText;
                }
            };
            xhr.send();
        }

        // Call fetchOrders on page load
        document.addEventListener('DOMContentLoaded', function() {
            fetchOrders();
        });
    </script>
</body>
</html>