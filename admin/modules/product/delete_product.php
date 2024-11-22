<?php
//thiết lập kết nối tới CSDL
$conn = initConnection();

if (isset($_GET['id'])) {
    $prd_id = $_GET['id'];

    //Chuẩn bị câu truy vấn
    $sqlCheckExists = "SELECT * FROM products WHERE prd_id = $prd_id";

    // Thực thi câu truy vấn
    $queryCheckExists = mysqli_query($conn, $sqlCheckExists);

    //Lấy dữ liệu bản ghi
    if (mysqli_num_rows($queryCheckExists) > 0) {
        //Chuẩn bị câu truy vấn
        $sqlDeleteProduct = "UPDATE products SET prdDeleted = 1 WHERE prd_id = $prd_id";

        //Thực thi câu truy vấn
        $queryDeleteProduct = mysqli_query($conn, $sqlDeleteProduct);
        header("location:index.php?page=product");
    } 

} else {
    //Không tìm thấy bản ghi nào có giá trị là $_GET['id']
    header("location:index.php?page=product");
}
closeConnection();
