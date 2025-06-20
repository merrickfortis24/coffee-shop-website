<div class="container p-5">

<h4>Edit Product Detail</h4>
<?php
    include_once "../config/dbconnect.php";
    $ID = $_POST['record'];
    $qry = mysqli_query($conn, "SELECT * FROM product WHERE Product_ID='$ID'");
    $numberOfRow = mysqli_num_rows($qry);
    if ($numberOfRow > 0) {
        while ($row1 = mysqli_fetch_array($qry)) {
            $catID = $row1["Category_ID"];
?>
<form id="update-Items" onsubmit="updateItems()" enctype='multipart/form-data'>
    <div class="form-group">
        <input type="text" class="form-control" id="product_id" value="<?=$row1['Product_ID']?>" hidden>
    </div>
    <div class="form-group">
        <label for="name">Product Name:</label>
        <input type="text" class="form-control" id="p_name" value="<?=$row1['Product_name']?>">
    </div>
    <div class="form-group">
        <label for="desc">Product Description:</label>
        <input type="text" class="form-control" id="p_desc" value="<?=$row1['Product_desc']?>">
    </div>
    <div class="form-group">
        <label for="price">Unit Price:</label>
        <input type="number" class="form-control" id="p_price" value="<?=$row1['Price']?>">
    </div>
    <div class="form-group">
        <label for="category">Category:</label>
        <select id="category" name="category" required>
            <option disabled>Select category</option>
            <?php
                $sql = "SELECT * FROM category";
                $result = $conn->query($sql);
                if ($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        // Pre-select the current category
                        $selected = ($row['Category_ID'] == $catID) ? "selected" : "";
                        echo "<option value='".$row['Category_ID']."' $selected>".$row['Category_NAME']."</option>";
                    }
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <img width='200px' height='150px' src='<?=$row1["product_image"]?>'>
        <div>
            <label for="file">Choose Image:</label>
            <input type="text" id="existingImage" class="form-control" value="<?=$row1['product_image']?>" hidden>
            <input type="file" id="newImage" value="">
        </div>
    </div>
    <div class="form-group">
        <button type="submit" style="height:40px" class="btn btn-primary">Update Item</button>
    </div>
<?php
        }
    }
?>
</form>

</div>