<?php
$conn = initConnection();
//Lấy dữ liệu cũ
if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$sqlOldCategory = "SELECT * FROM categories WHERE cat_id = $id";
	$queryOldCategory = mysqli_query($conn, $sqlOldCategory);
	if (mysqli_num_rows($queryOldCategory) > 0) {
		$result = mysqli_fetch_assoc($queryOldCategory);
	} else {
		header("location:index.php?page=category");
	}

	//Sửa category
	if (isset($_POST['sbm'])) {
		$cat_name = $_POST['cat_name'];
		$isDeleted = $_POST['isDeleted'];

		$sqlCheckExists = "SELECT * FROM categories WHERE cat_name = '$cat_name' AND cat_id != $id";
		$queryCheckExists = mysqli_query($conn, $sqlCheckExists);

		if (mysqli_num_rows($queryCheckExists) > 0) {
			$error = '<div class="alert alert-danger">Danh mục đã tồn tại !</div>';

		} else {
			$sqlUpdateCategory = "UPDATE categories SET cat_name = '$cat_name', isDeleted = '$isDeleted' WHERE cat_id = '$id' ";
			$queryUpdateCategory = mysqli_query($conn, $sqlUpdateCategory);
			header("location:index.php?page=category");
		}
	}
} else {
	header("location:index.php?page=category");
}

?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><svg class="glyph stroked home">
						<use xlink:href="#stroked-home"></use>
					</svg></a></li>
			<li><a href="">Quản lý danh mục</a></li>
			<li class="active">Danh mục 1</li>
		</ol>
	</div><!--/.row-->

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Danh mục: <?php echo $result['cat_name']; ?></h1>
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
						?>
						<form role="form" method="post">
							<div class="form-group">
								<label>Tên danh mục:</label>
								<input type="text" name="cat_name" required value="<?php echo $result['cat_name']; ?>" class="form-control" placeholder="Tên danh mục...">
							</div>

							<div class="form-group">
								<label>Trạng Thái:</label>

								<select name="isDeleted" class="form-control">
									<option value="0" <?php if ($result['isDeleted'] == 0) {
															echo 'selected';
														} ?>>Hoạt Động</option>
									<option value="1" <?php if ($result['isDeleted'] == 1) {
															echo 'selected';
														} ?>>Tạm Dừng</option>
								</select>
							</div>

							<button type="submit" name="sbm" class="btn btn-primary">Cập nhật</button>
							<button type="reset" class="btn btn-default">Làm mới</button>
						</form>
					</div>
				</div>
			</div>
		</div><!-- /.col-->
	</div> <!--/.main-->
</div>