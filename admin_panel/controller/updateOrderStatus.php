<?php
include_once "../config/dbconnect.php";

$order_id = (int)$_POST['record'];
$new_status = isset($_POST['new_status']) ? (int)$_POST['new_status'] : null;

// Validate status transition
if ($new_status !== null) {
    $allowed_transitions = [
        0 => [1],  // Pending -> Processing
        1 => [2],  // Processing -> Delivered
        2 => []    // Delivered (no further changes)
    ];

    // Get current status
    $current_status_result = $conn->query("SELECT order_status FROM orders WHERE orders_id=$order_id");
    if ($current_status_result && $current_status_result->num_rows > 0) {
        $current_status = (int)$current_status_result->fetch_assoc()['order_status'];

        // Check if transition is allowed
        if (in_array($new_status, $allowed_transitions[$current_status])) {
            $sql = "UPDATE orders SET order_status = $new_status WHERE orders_id=$order_id";
            if ($conn->query($sql)) {
                echo "Order status updated!";
            } else {
                echo "Update failed: " . $conn->error;
            }
        } else {
            echo "Invalid status transition";
        }
    } else {
        echo "Order not found";
    }
} else {
    echo "Missing status parameter";
}
?>