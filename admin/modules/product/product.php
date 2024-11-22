<?php 
    //B1. Thiết lập kết nối
    $conn = initConnection();
    $limit = 5; //Số bản ghi trên một trang
    //Lấy tổng số bản ghi của bảng product
    $sqlTotalRecords = "SELECT * FROM products";
    $queryTotalRecords = mysqli_query($conn, $sqlTotalRecords);
    $totalRecords = mysqli_num_rows($queryTotalRecords); //tổng số bản ghi trong bảng Product.
    //Tổng số trang
    $totalPages = ceil($totalRecords/ $limit);
    //Lấy trang hiện tại.
    /**
     * Nếu như tồn tại tham số current_page trên đường dẫn thì lấy giá trị của nó.
     * Còn nếu như không tồn tại tham số current_page thì gán mặc định trang đó là trang số 1.
     */
    if(isset($_GET['current_page'])) {
        $current_page = $_GET['current_page'];
    }else{
        $current_page = 1;
    }

    //Khi người dùng bấm vào nút trở về trang trước.
    if($current_page < 1) {
        $current_page = 1;
    }

    //Khi người dùng bấm vào nút sang trang sau.
    if($current_page > $totalPages && $totalPages > 1) {
        $current_page = $totalPages;
    }

    //Tìm biến $start
    $start = ($current_page - 1) * $limit;

    //B2. Chuẩn bị câu truy vấn
    $sqlAllProducts = "SELECT * FROM products p INNER JOIN categories c ON p.cat_id = c.cat_id WHERE prdDeleted != 1
                       ORDER BY p.prd_id LIMIT $start,$limit";
    //B3. Thực thi truy vấn
    $queryAllProducts = mysqli_query($conn, $sqlAllProducts);
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><svg class="glyph stroked home">
                        <use xlink:href="#stroked-home"></use>
                    </svg></a></li>
            <li class="active">Danh sách sản phẩm</li>
        </ol>
    </div>
    <!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Danh sách sản phẩm</h1>
        </div>
    </div>
    <!--/.row-->

    <div id="toolbar" class="btn-group">
        <a href="index.php?page=add_product" class="btn btn-success">
            <i class="glyphicon glyphicon-plus"></i> Thêm sản phẩm
        </a>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table data-toolbar="#toolbar" class="table" data-toggle="table">
                        <thead>
                            <tr>
                                <th data-field="id" data-sortable="true">ID</th>
                                <th data-field="name" data-sortable="true">Tên sản phẩm</th>
                                <th data-field="price" data-sortable="true">Giá</th>
                                <th>Ảnh sản phẩm</th>
                                <th>Trạng thái</th>
                                <th>Danh mục</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                if(mysqli_num_rows($queryAllProducts) > 0) {
                                    while($product = mysqli_fetch_assoc($queryAllProducts)) {
                            ?>
                                <tr>
                                    <td><?php echo $product['prd_id']; ?></td>
                                    <td><?php echo $product['prd_name']; ?></td>
                                    <td><?php echo number_format($product['prd_price'], 0, ',','.'); ?> VNĐ</td>
                                    <td style="text-align: center" id="product-img"><img width="90" height="120" src="../images/<?php echo $product['prd_image']; ?>" /></td>
                                    <td>
                                        <?php 
                                            if($product['prdDeleted'] == 1) {
                                                echo '<span class="label label-danger">Hết hàng</span>';
                                            }else{
                                                echo '<span class="label label-success">Còn hàng</span>';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $product['cat_name']; ?>
                                    </td>
                                    <td class="form-group">
                                        <a href="index.php?page=edit_product&id=<?php echo $product['prd_id']; ?>" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i></a>
                                        <a href="index.php?page=delete_product&id=<?php echo $product['prd_id']; ?>" class="btn btn-danger" onclick = "return xoa();"><i class="glyphicon glyphicon-remove"></i></a>
                                    </td>
                                </tr>
                            <?php                    
                                    }
                                }
                            ?>

                        </tbody>
                    </table>
                </div>

                <div class="panel-footer">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php 
                                if($current_page > 1) {
                                $prev = $current_page - 1;
                            ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?page=product&current_page=<?php echo $prev; ?>">&laquo;</a>
                                </li>
                            <?php
                                }
                            ?>
                            
                            <!-- In các trang -->
                            <?php for($i= 1; $i <= $totalPages; $i++) {
                            ?>
                                <li class="page-item <?php if($i == $current_page) {echo 'active';} ?>">
                                    <a class="page-link" href="index.php?page=product&current_page=<?php echo $i; ?>">
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php
                            }
                            ?>
                            
                            <?php 
                                if($current_page < $totalPages) {
                                $next = $current_page + 1;
                            ?>
                                <li class="page-item"><a class="page-link" href="index.php?page=product&current_page=<?php echo $next; ?>">&raquo;</a></li>
                            <?php
                                }
                            ?>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </div>
    <!--/.row-->
</div>
<!--/.main-->

<?php 
    function xoa() {
        return confirm("Bạn có chắc chắn xóa?");
    }

?>