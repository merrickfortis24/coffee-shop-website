<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'db.php';

// Get order details from POST request
$orderDetails = json_decode(file_get_contents('php://input'), true);

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
foreach ($orderDetails as $order) {
    $title = $con->real_escape_string($order['title']);
    $price = floatval($order['price']);
    $quantity = intval($order['quantity']);
    $subtotal = floatval($order['subtotal_amount']);
    $invoice = $con->real_escape_string($order['invoice_number']);
    $pay_method = $con->real_escape_string($order['pay_method']);
    $date = date('Y-m-d');

    $sql = "INSERT INTO orders (title, price, quantity, subtotal_amount, date, invoice_number, user_id, pay_method, order_status, pay_status)
            VALUES ('$title', $price, $quantity, $subtotal, '$date', '$invoice', $user_id, '$pay_method', 'Pending', 'Unpaid')";

    if (!$con->query($sql)) {
        echo "Error: " . $con->error;
    }
}

$con->close();
echo "Orders added successfully!";
?>

<script>
$(document).on('click', '.btn-buy', function() {
    if (cart.length === 0) {
        alert('Your cart is empty!');
        return;
    }
    // Get selected payment method
    let pay_method = $('input[name="pay_method"]:checked').val();

    // Prepare order details
    let invoiceNumber = "INV-" + Math.floor(Math.random() * 1000000);
    let orderDetails = cart.map(item => ({
        title: item.Product_name,
        price: item.Price,
        quantity: item.qty,
        subtotal_amount: (item.Price * item.qty),
        invoice_number: invoiceNumber,
        pay_method: pay_method
    }));

    // Send to server
    fetch('add_to_database.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(orderDetails)
    })
    .then(res => res.text())
    .then(data => {
        alert('Order placed!');
        cart = [];
        renderCart();
    })
    .catch(err => {
        alert('Order failed!');
        console.error(err);
    });
});
</script>