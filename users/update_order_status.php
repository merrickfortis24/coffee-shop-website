<?php
session_start();
include("db.php");

header('Content-Type: application/json');

try {
    if (!isset($_SESSION['username'])) {
        throw new Exception('User not authenticated');
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    $data = json_decode(file_get_contents('php://input'), true);
    $invoice = $data['invoice'] ?? null;
    $newStatus = $data['status'] ?? null;

    if (!$invoice || $newStatus === null) {
        throw new Exception('Missing required parameters');
    }

    // Update order status
    $stmt = $con->prepare("UPDATE orders SET order_status = ? WHERE invoice_number = ?");
    $stmt->bind_param("is", $newStatus, $invoice);
    
    if (!$stmt->execute()) {
        throw new Exception("Failed to update order status: " . $stmt->error);
    }

    echo json_encode(['success' => true, 'message' => 'Order status updated']);
    
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>