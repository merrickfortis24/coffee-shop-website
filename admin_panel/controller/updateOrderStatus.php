<?php

    include_once "../config/dbconnect.php";
   
    $order_id=$_POST['record'];
    // Toggle order_status (0->1, 1->0)
    $sql = "UPDATE orders SET order_status = IF(order_status=0,1,0) WHERE orders_id='$order_id'";
    if(mysqli_query($conn, $sql)){
        echo "Order status updated!";
    } else {
        echo "Failed to update order status.";
    }
    
?>