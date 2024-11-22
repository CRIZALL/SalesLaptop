<?php
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        case 'add':
            addToCart();
            break;
        case 'update':
            UpdateCart();
            break;
        case 'checkout':
            checkOutCart();
            break;
        case 'delete':
            deleteCart();
            break;
    }
} else {
    header("location: cart.php");
}

//thêm vào giỏ hàng
function addToCart()
{
    //Kết nối tới database
    include_once "admin/config/db.php";
    $conn = initConnection();

    //Khởi động session
    session_start();

    //Lấy ra id của product
    $prd_id = $_GET['prd_id'];

    //thực hiện câu truy vấn để lấy dữ liệu product
    $sqlPrd = "SELECT * FROM products p
    WHERE p.prd_id = '$prd_id'";

    $queryPrd = mysqli_query($conn, $sqlPrd);
    $product = mysqli_fetch_assoc($queryPrd);

    if (isset($_GET['prd_id'])) {

        //Thực hiện tính lấy ra giá tiền sản phẩm
        $price = $product['prd_price'];

        if (isset($_SESSION['gioHang'])) {
            // Nếu trong giỏ hàng đã có sản phẩm
            $myItem = [];
            foreach ($_SESSION['gioHang'] as $product) {
                $myItem[] = $product['prd_id'];
            }

            // Nếu sản phẩm đã tồn tại trong giỏ hàng (mua cùng 1 sản phẩm nhiều lần)
            if (in_array($_GET['prd_id'], $myItem)) {

                //Cập nhật SESSiON để hiển thị trong Cart.php
                $_SESSION['gioHang'][$prd_id]['qty']++;
                // die("OK-1");

            } else {
                //thực hiện câu truy vấn để lấy dữ liệu product
                $sqlPrd = "SELECT * FROM products p
                WHERE p.prd_id = '$prd_id'";

                $queryPrd = mysqli_query($conn, $sqlPrd);
                $product = mysqli_fetch_assoc($queryPrd);
                
                // Nếu trong giỏ Đã Tồn Tại Sản Phẩm Rồi Nhưng người dùng lại mua thêm hàng mới 
                $_SESSION['gioHang'][$prd_id] = array(
                    'prd_id' => $_GET['prd_id'],
                    'prd_name' => $product['prd_name'],
                    'prd_img' => $product['prd_image'], 
                    'price' => $price,
                    'qty' => 1
                );

                // die("OK-2");              
            }

        } else {
            // Nếu sản phẩm chưa tồn tại trong giỏ hàng
            $_SESSION['gioHang'][$prd_id] = array(
                'prd_id' => $_GET['prd_id'],
                'prd_name' => $product['prd_name'],
                'prd_img' => $product['prd_image'],
                'price' => $price,
                'qty' => 1
            );
            // die("OK-3");
        }
        header("location: cart.php");
    }
}

//cập nhật vào giỏ hàng
function UpdateCart()
{
    $add_total = 0;
    foreach ($_POST['quantity'] as $cart_id => $qty) {
        $_SESSION['gioHang'][$cart_id]['qty'] = $qty;
        $add_total += $qty;
    }
    header("location: cart.php");
}

//xóa sản phẩm khỏi giỏ hàng
function deleteCart()
{
    if (isset($_GET['cart_id'])) {
        $cart_id = $_GET['cart_id'];

        //Xóa sản phẩm có id = số trên URL
        unset($_SESSION['cart'][$cart_id]);

        //Trường hợp giỏ hảng rỗng (Chưa mua bất kì sản phẩm nào) => Xóa toàn bộ giỏ hàng.
        if (empty($_SESSION['cart'])) {
            unset($_SESSION['cart']);
        }
        header("location: cart.php");

    } else {
        header("location: cart.php");
    }
}

//Thanh toán sản phẩm đã chọn
function checkOutCart()
{
    //Lấy các giá trị cần thiết cho các câu truy vấn bên dưới
    $user_name = $_POST['name'];
    $userPhone = $_POST['phone'];
    $user_email = $_POST['mail'];
    $address = htmlspecialchars($_POST['address']);
    include_once "admin/config/db.php";
    $conn = initConnection();
    session_start();

    //Bắt đầu câu truy vấn SQL vào table user để thực hiện xác thực
    $sqlUser = "SELECT * FROM users WHERE user_email = '$user_email'";
    $queryUser = mysqli_query($conn, $sqlUser);
    $result = mysqli_fetch_assoc($queryUser);

    if (mysqli_num_rows($queryUser) > 0) {
        $sqlUser = "SELECT * FROM users 
        WHERE user_name = '$user_name' AND user_email = '$user_email'";
        $queryPrd =  mysqli_query($conn, $sqlUser);
        $result = mysqli_fetch_assoc($queryPrd);

        $user_id = $result['user_id'];

        //Bắt đầu câu truy vấn SQL vào table orders
        $sqlOrder = "INSERT INTO orders(user_id, delivered_to, phone_number) 
        VALUES ('$user_id','$address','$userPhone')";
        mysqli_query($conn, $sqlOrder);
        $lastInsertedID = mysqli_insert_id($conn);

        //Thêm vào Order-detail: order_id, prd_size_id, qty, price
        foreach ($_SESSION['gioHang'] as $product) {
            $price = $product['price']; //Đơn giá sản phẩm lưu trong giỏ hàng
            $qty = $product['qty']; //Số lượng của từng sản phẩm lưu trong giỏ hàng
            $prd_id = $product['prd_id'];

            $sqlDetailOrder = "INSERT INTO orderdetail (order_id, prd_id, quantity, price) 
                                VALUES ($lastInsertedID, $prd_id, $qty, $price)";
            mysqli_query($conn, $sqlDetailOrder);
        }

        unset($_SESSION['gioHang']); //Xóa giỏ hàng sau khi mua xong
        $conn = closeConnection();
 
        header("location: cart.php");

    } else {
        //Thực hiện tạo 1 tài khoản cho khách hàng đã mua hàng
        $sqlUser = "INSERT INTO users (user_name, user_email) 
        VALUES ('$user_name', '$user_email')";
        mysqli_query($conn, $sqlUser);
        $lastInsertedID = mysqli_insert_id($conn);

        //Thực hiện câu truy vấn lấy ra thông tin của tài khoản user vừa tạo
        $sqlUser = "SELECT * FROM users 
        WHERE user_name = '$user_name' AND user_email = '$user_email'";
        $queryPrd =  mysqli_query($conn, $sqlUser);
        $result = mysqli_fetch_assoc($queryPrd);

        //Lấy ra id của tài khoản người dùng vừa tạo
        $user_id = $result['user_id'];

        //Bắt đầu câu truy vấn SQL vào table orders
        $sqlOrder = "INSERT INTO orders(user_id, delivered_to, phone_number) 
        VALUES ('$user_id','$address','$userPhone')";
        mysqli_query($conn, $sqlOrder);
        $lastInsertedID = mysqli_insert_id($conn);

        //Thêm vào Order-detail: order_id, prd_size_id, qty, price
        foreach ($_SESSION['gioHang'] as $product) {
            $price = $product['price']; //Đơn giá sản phẩm lưu trong giỏ hàng
            $qty = $product['qty']; //Số lượng của từng sản phẩm lưu trong giỏ hàng
            $prd_id = $product['prd_id'];

            $sqlDetailOrder = "INSERT INTO orderdetail (order_id, prd_id, quantity, price) 
                                VALUES ($lastInsertedID, $prd_id, $qty, $price)";
            mysqli_query($conn, $sqlDetailOrder);
        }

        unset($_SESSION['gioHang']); //Xóa giỏ hàng sau khi mua xong
        $conn = closeConnection();

        header("location: cart.php");
    };
}
?>