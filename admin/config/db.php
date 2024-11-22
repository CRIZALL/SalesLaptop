<?php

define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME', 'project');
define('DB_HOST','localhost');$conn = null;

function initConnection() {
    global $conn;
    $conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    //mysqli_connect trả về TRUE nếu kết nối được thiết lập và ngược lại.
    if(!$conn) {
        die("Kết nối thất bại" + mysqli_connect_error());
    }else{
        mysqli_set_charset($conn, 'UTF8');
    }
    return $conn;
}

// method: closeConnection()
// desc: Hàm ngắt kết nối đến CSDL
// @param: 
// result: Ngắt kết nối đến CSDL

function closeConnection() {
    global $conn;
    if($conn) {
        mysqli_close($conn);
    }
}
