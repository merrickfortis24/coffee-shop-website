<?php

    include_once "../config/dbconnect.php";
    $order_id = $_POST['record'];
    // Toggle pay_status (0->1, 1->0)
    $sql = "UPDATE orders SET pay_status = IF(pay_status=0,1,0) WHERE orders_id='$order_id'";
    if(mysqli_query($conn, $sql)){
        echo "Payment status updated!";
    } else {
        echo "Failed to update payment status.";
    }

?>