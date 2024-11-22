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
        <a href="cart.php"><img src="images/cart.png"></a>
    </div>
    <div class="boxcenter">
        <div class="row mb header">
            <h1>LAPTOP WORLD</h1>

        </div>
        <div class="row mb menu">
            <ul>
                <li><a href="index.php">Trang chủ</a></li>
                <li><a href="cart.php">Giỏ hàng</a></li>
            </ul>
        </div>
        <div class="row mb ">
            <div class="boxtrai mr">
                <div class="row">
                    <div class="banner">
                        <img src="images/Banner 1.webp" alt="">
                    </div>
                </div>

                <div class="row">
                <?php
                if (isset($_GET['category'])) {
                    //Kết nối tới cơ sở dữ liệu
                    include_once "admin/config/db.php";
                    $conn = initConnection();

                    //Lấy ra danh mục trên URL
                    $category = $_GET['category'];

                    //Thực hiện câu truy vấn
                    $sqlProduct = "SELECT * FROM products p INNER JOIN categories c
                    ON p.cat_id = c.cat_id
                    WHERE c.cat_name = '$category' ";

                    $queryProduct = mysqli_query($conn, $sqlProduct);
                    $conn = closeConnection();

                } else {
                    //Kết nối tới cơ sở dữ liệu
                    include_once "admin/config/db.php";
                    $conn = initConnection();

                    //Thực hiện câu truy vấn
                    $sqlProduct = "SELECT * FROM products p INNER JOIN categories c
                    ON p.cat_id = c.cat_id ";

                    $queryProduct = mysqli_query($conn, $sqlProduct);
                    $conn = closeConnection();
                }

                while ($result = mysqli_fetch_assoc($queryProduct)) {
                ?>
                <form action="chiTietSanPham.php?id=<?php echo $result['prd_id']; ?>" method="post">
                    <div class="boxsp mr">
                        <div class="row img"><img src="images/<?php echo $result['prd_image']; ?>" alt="error"></div>
                        <p><span><?php echo  $result['prd_price']; ?></span>$</p>
                        <p><?php echo $result['prd_name']; ?></p>
                        <button type="submit">Đặt hàng</button>
                    </div>
                </form>
                <?php
                }
                ?>
                </div>
            </div>

            <div class="boxphai">
                <div class="row mb">
                    <div class="boxtitle">DANH MỤC</div>
                    <div class="boxcontent2 menudoc">
                        <ul>
                            <li>
                                <a href="#">Laptop</a>
                            </li>
                            <li>
                                <a href="#">Laptop Gaming</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="row">
                    <div class="boxtitle">TOP 10 YÊU THÍCH</div>
                    <div class="row boxcontent">
                        <div class="row mb10 top10">
                            <img src="images/2.webp" alt="">
                            <a href="#">Laptop Dell Inspiron 15 3520 N5I5122W1 Black</a>
                        </div>
                        <div class="row mb10 top10">
                            <img src="images/1.jpg" alt="">
                            <a href="#">Laptop MSI Prestige 13 Evo A13M 081VN</a>
                        </div>
                        <div class="row mb10 top10">
                            <img src="images/3.webp" alt="">
                            <a href="#">Laptop Dell Vostro 3430 71011900</a>
                        </div>
                        <div class="row mb10 top10">
                            <img src="images/4.webp" alt="">
                            <a href="#">Laptop Lenovo Ideapad Slim 5 Light 14ABR8 82XS002JVN</a>
                        </div>
                        <div class="row mb10 top10">
                            <img src="images/5.webp" alt="">
                            <a href="#">Laptop Asus Vivobook Pro 15 OLED M6500QC MA002W</a>
                        </div>
                        <div class="row mb10 top10">
                            <img src="images/6.webp" alt="">
                            <a href="#">Laptop ASUS Vivobook 14X OLED A1403ZA KM066W</a>
                        </div>
                        <div class="row mb10 top10">
                            <img src="images/7.webp" alt="">
                            <a href="#">Laptop Dell Latitude 3520 P108F001 70280543</a>
                        </div>
                        <div class="row mb10 top10">
                            <img src="images/8.webp" alt="">
                            <a href="#">Laptop Lenovo V15 G3 ABA 82TV002KVN</a>
                        </div>
                        <div class="row mb10 top10">
                            <img src="images/9.webp" alt="">
                            <a href="#">Laptop MSI Modern 14 C11M 011VN</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row mb footer">
            Copyright © 2023 - MINH HUY
        </div>
    </div>

</body>

</html>