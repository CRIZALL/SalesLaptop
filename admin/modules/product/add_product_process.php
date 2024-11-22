<?php
   require_once "../../config/db.php";
   $conn = initConnection();
   $prd_name = $_POST['prd_name'];
   $prd_price = $_POST['prd_price'];
   $cat_id = $_POST['cat_id'];
   $prdDeleted = $_POST['prd_status'];

   if(isset($_FILES['prd_image']['name'])) {
       $file_name = $_FILES['prd_image']['name'];
       $file_tmp_name = $_FILES['prd_image']['tmp_name'];
       move_uploaded_file($file_tmp_name, '../../../images/'.$file_name);
   }

   $sqlInsert = "INSERT INTO products (prd_name,prd_price,cat_id,prdDeleted,prd_image)
                VALUES('$prd_name','$prd_price','$cat_id','$prdDeleted','$file_name')";
   $queryInsert = mysqli_query($conn, $sqlInsert);
   header("location:../../index.php?page=product");
?>