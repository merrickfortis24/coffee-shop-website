<?php

$conn = mysqli_connect("localhost", "root", "", "coffee_shop");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>