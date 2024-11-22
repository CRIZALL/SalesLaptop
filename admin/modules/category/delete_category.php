<?php 
//thiết lập kết nối tới CSDL
$conn = initConnection();

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        //Chuẩn bị câu truy vấn
        $sqlCheckExists = "SELECT * FROM categories WHERE cat_id = $id";
        // Thực thi câu truy vấn
        $queryCheckExists = mysqli_query($conn, $sqlCheckExists);

        //Lấy dữ liệu bản ghi
        if (mysqli_num_rows($queryCheckExists) > 0) {
            $sqlDeleteMembers = "UPDATE categories SET isDeleted = 1 WHERE cat_id = $id";
            $queryDeleteMembers = mysqli_query($conn,$sqlDeleteMembers);

            if (!$queryDeleteMembers) {
                $_SESSION['error_DeleteMembers'] = '<div class="alert alert-danger">Danh mục này không tồn tại!</div>';
                header("location:index.php?page=category");
            }else {
                header("location:index.php?page=category");
            }

        } else {
            //Nếu không tìm được bản ghi nào có giá trị là $_GET['id']
            header("location:index.php?page=category");
        }
    }
closeConnection();