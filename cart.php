<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart | View Cart</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- font awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="boxcenter">
        <div class="row mb header">
            <h1>LAPTOP WORLD</h1>
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

        <div class="row mb">
            <form action="process_cart.php?action=checkout" method="post">
                <div class="boxtrai mr">
                    <div class="row">
                        <h1>THÔNG TIN NHẬN HÀNG</h1>
                        <table class="thongtinnhanhang">
                            <tr>
                                <td width="20%">Họ tên</td>
                                <td><input type="text" name="name"></td>
                            </tr>
                            <tr>
                                <td>Địa chỉ</td>
                                <td><input type="text" name="address"></td>
                            </tr>
                            <tr>
                                <td>Điện thoại</td>
                                <td><input type="text" name="phone"></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><input type="text" name="mail"></td>
                            </tr>
                        </table>
                    </div>

                    <!-----------cart----------------- -->
                    <div class="row">
                        <h1>GIỎ HÀNG</h1>

                        <?php
                        //Kết nối tới cơ sở dữ liệu
                        include_once "admin/config/db.php";
                        $conn = initConnection();

                        //Mở session
                        session_start();
                        $total = 0;

                        //Lấy ra ID của product
                        if (isset($_GET['id'])) {
                            $prd_id = $_GET['id'];
                        }
                        ?>

                        <!--	Cart	-->
                        <?php
                        //Kiểm tra xem biến $_SESSION['cart'] có tồn tại không
                        if (isset($_SESSION['gioHang'])) {
                        ?>
                            <section class="cart">
                                <div class="container">
                                    <div class="cart-content">
                                        <div class="cart-content-left">
                                            <table>
                                                <tr>
                                                    <th>Sản phẩm</th>
                                                    <th>Tên sản phẩm</th>
                                                    <th>Số lượng</th>
                                                    <th>Thành tiền($)</th>
                                                    <th>xóa</th>
                                                </tr>
                                                <?php
                                                if (isset($_SESSION['gioHang'])) {
                                                    $product_qty = 0;

                                                    //Viết vòng lặp để xuất ra màn hình thông tin các sản phẩm 
                                                    //đã được người dùng chọn mua
                                                    foreach ($_SESSION['gioHang'] as $product) {
                                                        $product_qty += $product['qty'];
                                                        $subTotal = $product['price'] * $product['qty'];
                                                        $total +=  $subTotal;

                                                ?>
                                                    <tr>
                                                        <td class="col-2">
                                                            <img class="w-100" src="images/<?php echo $product['prd_img']; ?>" alt="error">
                                                        </td>
                                                        <td><?php echo $product['prd_name']; ?></td>
                                                        <td><input type="number" id="quantity" name="quantity[<?php echo $product['prd_id']; ?>]" class="rounded-1 text-center col-6" value="<?php echo $product['qty']; ?>" min="1"></td>
                                                        <td>
                                                            <b>
                                                                <?php echo $subTotal; ?>$
                                                            </b>
                                                        </td>
                                                        <td>
                                                            <a href="#" onclick="return check()">
                                                                <i class="fa-solid fa-circle-xmark fa-xl"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </table>
                                        </div>

                                        <div class="cart-content-right-button">
                                            <button type="sumbit" name="sbm">THANH TOÁN</button>
                                        </div>
                                    </div>
                                </div>
                            </section>

                        <?php
                        } else {
                            echo '<div id="my-cart"><h3>Hiện chưa có sản phẩm!</h3></div>';
                        }
                        ?>
                    </div>
                </div>
            </form>

            <div class="boxphai">
                <div class="row mb">
                    <div class="boxtitle">DANH MỤC</div>
                    <div class="boxcontent2 menudoc">
                        <ul>
                            <li><a href="#">Laptop</a></li>
                            <li><a href="#">Laptop Gaming</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-------------footer---------------->
        <div class="row mb footer">
            <p>&copy; 2023 Siêu thị trực tuyến. All rights reserved.</p>
        </div>
    </div>
</body>

</html>