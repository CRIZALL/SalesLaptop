<?php 
    //kết nối csdl
    $conn = initConnection();
    /**
     * LẤY DỮ LIỆU CŨ
     */

    if(isset($_GET['id'])) {
        
        $prd_id = $_GET['id'];
        $sqlOldProduct = "SELECT * FROM products WHERE prd_id = $prd_id";
        $queryOldProduct = mysqli_query($conn, $sqlOldProduct);
        if(mysqli_num_rows($queryOldProduct) > 0) {
            $product = mysqli_fetch_assoc($queryOldProduct);
            /**
             * SỬA THÔNG TIN
             */
            if(isset($_POST['sbm'])) {
                $prd_name = $_POST['prd_name'];
                $prd_price = $_POST['prd_price'];
                $cat_id = $_POST['cat_id'];
                $prdDeleted = $_POST['prdDeleted'];

                if(isset($_FILES['prd_image']['name']) && $_FILES['prd_image']['name'] != '') {
                    $file_name = $_FILES['prd_image']['name'];
                    $file_tmp_name = $_FILES['prd_image']['tmp_name'];
                    move_uploaded_file($file_tmp_name, '../images/'.$file_name);

                }else{
                    $file_name = $product['prd_image'];
                }

                $sqlUpdateProduct = "UPDATE products SET 
                                    prd_name = '$prd_name',
                                    prd_price = '$prd_price',
                                    cat_id = '$cat_id',
                                    prdDeleted = 'prdDeleted',
                                    prd_image = '$file_name' WHERE prd_id = $prd_id";
                mysqli_query($conn, $sqlUpdateProduct);
                header("location:index.php?page=product");
            }
        }else{
            header("location:index.php?page=edit_product&id=$prd_id");
        }
    }else{
        header("location:index.php?page=product");
    }
    


?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><svg class="glyph stroked home">
                        <use xlink:href="#stroked-home"></use>
                    </svg></a></li>
            <li><a href="">Quản lý sản phẩm</a></li>
            <li class="active"><?php echo $product['prd_name']; ?></li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Sản phẩm: <?php echo $product['prd_name']; ?></h1>
        </div>
    </div><!--/.row-->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-6">
                        <form role="form" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Tên sản phẩm</label>
                                <input type="text" name="prd_name" required class="form-control" value="<?php echo $product['prd_name']; ?>" placeholder="">
                            </div>

                            <div class="form-group">
                                <label>Giá sản phẩm</label>
                                <input type="number" name="prd_price" required value="<?php echo $product['prd_price']; ?>" class="form-control">
                            </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ảnh sản phẩm</label>
                            <input type="file" name="prd_image" onchange="preview();">
                            <br>
                            <div>
                                <img src="../images/<?php echo $product['prd_image']; ?>" id="prd_image" width="150" height="200">
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
                                ?>
                                    <option  <?php 
                                            if($row['cat_id'] == $product['cat_id']) {
                                                echo "selected";
                                            }
                                        ?>  value="<?php echo $row['cat_id']; ?>"> <?php echo $row['cat_name']; ?></option>
                                <?php      
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select name="prdDeleted" class="form-control">
                                <option <?php if($product['prdDeleted'] == 1) {echo 'selected'; } ?>  value=1>Hết hàng</option>
                                <option <?php if($product['prdDeleted'] == 0) {echo 'selected'; } ?> value=0>Còn hàng</option>
                            </select>
                        </div>

                        <button type="submit" name="sbm" class="btn btn-primary">Cập nhật</button>
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