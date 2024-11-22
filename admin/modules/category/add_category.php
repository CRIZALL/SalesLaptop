<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
<?php
if (isset($_POST['sbm'])) {
	$cat_name = $_POST['cat_name'];
	//1. Kiểm tra danh mục đã tồn tại trong csdl hay chưa?
	//1.1. Chuẩn bị kết nối tới CSDL
	$conn = initConnection();
	//1.2. Chuẩn bị câu truy vấn
	$sqlCheckExists = "SELECT * FROM categories WHERE cat_name = '$cat_name'";
	//1.3. Thực thi truy vấn
	$queryCheckExists = mysqli_query($conn, $sqlCheckExists);
	//1.4. Kiểm tra danh mục đã tồn tại hay chưa?
	if (mysqli_num_rows($queryCheckExists) > 0) {
		//1.4.1. Nếu trong csdl đã có bản ghi cùng tên với tên mới thì thông báo lỗi.
		$error = '<div class="alert alert-danger">Danh mục đã tồn tại !</div>';
	} else {
		// 2. Thêm danh mục vào CSDL
		// 2.1. Chuẩn bị câu truy vấn
		$sqlInsertCategory = "INSERT INTO categories(cat_name)
							  VALUES ('$cat_name')";
		// 2.2. Thực thi câu truy vấn
	    $queryInsertCategory = mysqli_query($conn, $sqlInsertCategory);
		if($queryInsertCategory) {
			// 2.3. Chuyển hướng về trang danh sách.
			header("location:index.php?page=category");
		}else{
			$insertFailed = '<div class="alert alert-danger">Thêm danh mục không thành công !</div>';
		}
		
	}
}
?>
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="index.php?page=add_category"><svg class="glyph stroked home">
						<use xlink:href="#stroked-home"></use>
					</svg></a></li>
			<li><a href="">Quản lý danh mục</a></li>
			<li class="active">Thêm danh mục</li>
		</ol>
	</div><!--/.row-->

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Thêm danh mục</h1>
		</div>
	</div><!--/.row-->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="col-md-8">
						<?php
							//  Lỗi danh mục đã tồn tại
							if (isset($error)) {
								echo $error;
							}
							// Lỗi thêm bản ghi không thành công
							if(isset($insertFailed)) {
								echo $insertFailed;
							}
						?>
						<form action="" role="form" method="post">
							<div class="form-group">
								<label>Tên danh mục:</label>
								<input required type="text" name="cat_name" class="form-control" placeholder="Tên danh mục...">
							</div>
							<button type="submit" name="sbm" class="btn btn-success">Thêm mới</button>
							<button type="reset" class="btn btn-default">Làm mới</button>
						</form>
					</div>
				</div>
			</div>
		</div><!-- /.col-->
	</div> <!--/.main-->