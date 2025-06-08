<?php

include('includes/header.php');
include('includes/navbar.php');
include('includes/db_connect.php');

$query = "SELECT * FROM product";
$result = mysqli_query($conn, $query);
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Manage Products</h1>
    <a href="add_product.php" class="btn btn-primary mb-3">Add Product</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['Product_ID'] ?></td>
                <td><?= $row['Product_name'] ?></td>
                <td><?= $row['Product_desc'] ?></td>
                <td><?= $row['Created_At'] ?></td>
                <td><?= $row['Updated_At'] ?></td>
                <td>
                    <a href="edit_product.php?id=<?= $row['Product_ID'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_product.php?id=<?= $row['Product_ID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this product?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>