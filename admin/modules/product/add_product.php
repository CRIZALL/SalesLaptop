<?php 
    //kết nối đến CSDL
    $conn = initConnection();
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><svg class="glyph stroked home">
                        <use xlink:href="#stroked-home"></use>
                    </svg></a></li>
            <li><a href="">Quản lý sản phẩm</a></li>
            <li class="active">Thêm sản phẩm</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Thêm sản phẩm</h1>
        </div>
    </div><!--/.row-->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-6">
                        <form action="modules/product/add_product_process.php" role="form" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Tên sản phẩm</label>
                                <input required name="prd_name" class="form-control" placeholder="">
                            </div>

                            <div class="form-group">
                                <label>Giá sản phẩm</label>
                                <input required name="prd_price" type="number" min="0" class="form-control">
                            </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ảnh sản phẩm</label>
                            <input required name="prd_image" type="file" onchange="preview();">
                            <br>
                            <div>
                                <img src="../images/no_img.png" id="prd_image" width="150" height="200">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Danh mục</label>
                            <?php 
                                $sqlCategories = "SELECT * FROM categories ORDER BY cat_id";
                                $queryCategories = mysqli_query($conn, $sqlCategories);
                            ?>
                            <select name="cat_id" class="form-control">
                                <?php 
                                    while($row = mysqli_fetch_assoc($queryCategories)) {
                                        echo '<option value='.$row['cat_id'].'>'.$row['cat_name'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select name="prd_status" class="form-control">
                                <option value=0 >Còn hàng</option>
                                <option value=1 >Hết hàng</option>
                            </select>
                        </div>

                        <button name="sbm" type="submit" class="btn btn-success">Thêm mới</button>
                        <button type="reset" class="btn btn-default">Làm mới</button>
                    </div>
                    </form>
                </div>
            </div>
        </div><!-- /.col-->
    </div><!-- /.row -->
</div> <!--/.main-->

<script>
    function preview() {
        prd_image.src=URL.createObjectURL(event.target.files[0]);
    }
</script>