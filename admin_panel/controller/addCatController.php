<?php
    include_once "../config/dbconnect.php";
    
    if(isset($_POST['upload']))
    {
        $catname = $_POST['c_name'];
        $insert = mysqli_query($conn,"INSERT INTO category (Category_NAME) VALUES ('$catname')");
        if(!$insert)
        {
            echo "error: " . mysqli_error($conn);
        }
        else
        {
            echo "Category added successfully.";
        }
    }
?>