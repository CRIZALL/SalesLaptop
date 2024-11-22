<?php
    session_start();
    //Xử lý đăng nhập
    include_once "../config/db.php";
    
    //validate email
    if(empty($_POST['mail'])) {
        $_SESSION['error']['mail'] = '<div class="error-text text-danger">Email không được để trống!</div>';
        header("Location:login.php"); //nếu email chưa được nhập thì di chuyển về trang login.php
    }else{
        $mail = $_POST['mail'];
        $_SESSION['old_email'] =  $mail;
    }

    //validate password
    if(empty($_POST['pass'])) {
        $_SESSION['error']['pass'] = '<div class="error-text text-danger">Mật khẩu không được để trống!</div>';
        header("Location:login.php");//nếu password chưa được nhập thì di chuyển về trang login.php
    }else{
        $pass = $_POST['pass'];
    }

    //Thực hiện đăng nhập
    if(isset($mail) && isset($pass)) {
        //Thiết lập kết nối tới CSDL
        $conn = initConnection();
        //Chuẩn bị câu truy vấn kiểm tra tài khoản.
        $sqlLogin = "SELECT * FROM users WHERE user_mail='$mail' AND user_pass = '$pass'";
        //Thực hiện truy vấn đến CSDL
        $queryLogin = mysqli_query($conn, $sqlLogin);
        //Kiểm tra dữ liệu
        if(mysqli_num_rows($queryLogin) > 0) {
            $result = mysqli_fetch_assoc($queryLogin);
            //Lưu trữ thông tin vào session
            $_SESSION['user_logged']['id'] = $result['users_id'];
            $_SESSION['user_logged']['user_full'] = $result['user_full'];
            $_SESSION['user_logged']['user_email'] = $result['user_mail'];
            $_SESSION['user_logged']['user_level'] = $result['user_level'];
            header("Location:index.php");
        }else{
            $_SESSION['error']['invalid_account'] = '<div class="alert alert-danger">Tài khoản không hợp lệ !</div>';
            header("Location:login.php");
        }
        closeConnection();
    }
?>