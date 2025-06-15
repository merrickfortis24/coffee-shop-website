<div class="container">
<table class="table table-striped order-details-table">
    <colgroup>
      <col style="width: 5%;">
      <col style="width: 15%;">
      <col style="width: 15%;">
      <col style="width: 10%;">
      <col style="width: 10%;">
      <col style="width: 25%;">
      <col style="width: 20%;">
    </colgroup>
    <thead>
        <tr>
            <th>S.N.</th>
            <th>Product Image</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Address</th>
            <th>Phone Number</th>
        </tr>
    </thead>
    <tbody>
    <?php
        include_once "../config/dbconnect.php";
        $ID = $_GET['orderID'];

        // Join orders with products (assuming you match title with product_name)
        $sql = "SELECT o.title, o.quantity, o.price, o.street, o.barangay, o.city, o.phone,
                       p.product_name, p.product_image
                FROM orders o
                JOIN product p ON o.title = p.product_name
                WHERE o.orders_id = $ID";

        $result = $conn->query($sql);
        $count = 1;

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $fullAddress = $row['street'] . ', ' . $row['barangay'] . ', ' . $row['city'];
    ?>
                <tr>
                    <td><?= $count ?></td>
                    <td><img height="80px" src="<?= $row["product_image"] ?>"></td>
                    <td><?= $row["product_name"] ?></td>
                    <td><?= $row["quantity"] ?></td>
                    <td><?= $row["price"] ?></td>
                    <td><?= $fullAddress ?></td>
                    <td><?= $row["phone"] ?></td>
                </tr>
    <?php
                $count++;
            }
        } else {
            echo "<tr><td colspan='7'>No records found.</td></tr>";
        }
    ?>
    </tbody>
</table>
</div>
