<?php
    //thiết lập kết nối
    $conn = initConnection();
    //Chuẩn bị câu truy vấn lấy tất cả các thành viên.
    $sqlAllUser = "SELECT * FROM users";
    //Thực thi câu truy vấn.
    $queryAllUser = mysqli_query($conn, $sqlAllUser);
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><svg class="glyph stroked home">
                        <use xlink:href="#stroked-home"></use>
                    </svg></a></li>
            <li class="active">Danh sách người dùng</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Danh sách người dùng</h1>
        </div>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table data-toolbar="#toolbar" data-toggle="table">
                        <thead>
                            <tr>
                                <th data-sortable="true">ID</th>
                                <th data-sortable="true">Họ và Tên</th>
                                <th data-sortable="true">Email</th>
                                <th data-sortable="true">Trạng Thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            //Lấy dữ liệu
                            if(mysqli_num_rows($queryAllUser) > 0) { 
                                while($row = mysqli_fetch_assoc($queryAllUser)) {
                            ?>
                                <tr>
                                    <td><?php echo $row['user_id']; ?></td>
                                    <td><?php echo $row['user_name']; ?></td>
                                    <td><?php echo $row['user_email']; ?></td>
                                    <td>
                                        <?php 
                                            if($row['isDeleted'] == 1) {
                                                echo '<span class="label label-danger">Tạm Dừng</span>';
                                            }else{
                                                echo '<span class="label label-success">Hoạt Động</span>';
                                            }
                                        ?>
                                    </td>
                                    <td class="form-group">
                                        <a href="index.php?page=edit_user&user_id=<?php echo $row['user_id']; ?>" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i></a>
                                        <a href="index.php?page=delete_user&user_id=<?php echo $row['user_id']; ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
                                    </td>
                                </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div><!--/.row-->
</div> <!--/.main-->