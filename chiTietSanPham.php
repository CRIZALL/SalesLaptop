<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="giohang">
        <a href="cart.html"><img src="images/cart.png"></a>
    </div>
    <div class="boxcenter">
        <div class="row mb header">
            <h1> SIÊU THỊ TRỰC TUYẾN</h1>

        </div>
        <div class="row mb menu">
            <ul>
                <li><a href="index.php">Trang chủ</a></li>
                <li><a href="cart.php">Giỏ hàng</a></li>
                <li><a href="#">Liên hệ</a></li>
                <li><a href="#">Góp ý</a></li>
                <li><a href="#">Hỏi đáp</a></li>
            </ul>
        </div>
        <div class="row mb ">
            <div class="boxtrai mr">
                <div class="row">
                    <div class="banner">
                        <img src="images/Banner 1.webp" alt="">
                    </div>
                </div>

                <style>
                    .card-img-top {
                        width: 500px;
                        height: 500px;
                    }
                </style>

                <?php
                if (isset($_GET['id'])) {
                    //Lấy id từ URL
                    $id = $_GET['id'];

                    //Kết nối tới cơ sở dữ liệu
                    include_once "admin/config/db.php";
                    $conn = initConnection();

                    //Thực hiện câu truy vấn để lấy ra thông tin sản phẩm
                    $sqlPrd = "SELECT * FROM products WHERE prd_id = '$id'";
                    $queryPrd = mysqli_query($conn, $sqlPrd);

                    //Nếu tìm thấy sản phẩm
                    if (mysqli_num_rows($queryPrd) > 0) {
                        $product = mysqli_fetch_assoc($queryPrd);

                        //Nếu không tìm thấy sản phẩm
                    } else {
                        header("location: index.php");
                    }
                    $conn = closeConnection();
                }
                ?>

                <div class="row">
                    <form action="process_cart.php?action=add&prd_id=<?php echo $product['prd_id']; ?>" method="post">
                    <div class="col-md-6 col-lg-5 mb-4">
                        <div class="card">
                            <img src="images/<?php echo $product['prd_image']; ?>" class="card-img-top" alt="...">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-7 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h1 class="text-danger text-center"><?php echo $product['prd_name']; ?></h1>
                                <h1 class="text-danger text-center">1000$</h1>
                                <ul>
                                    <h2>✔ Bảo hành chính hãng 24 tháng.</h2>
                                    <h2>✔ Hỗ trợ đổi mới trong 7 ngày. </h2>
                                    <h2>✔ Windows bản quyền tích hợp.</h2>
                                    <h2>✔ Miễn phí giao hàng toàn quốc.</h2>
                                </ul>
                            </div>

                            <div class="card-footer bg-white">
                                <button type="submit" class="btn btn-danger px-5">Mua ngay</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                </div>
            </div>
        </div>
    </div>

    <div class="row mb footer">
        Copyright © 2023 - MINH HUY
    </div>
</body>

</html>