<?php
//B1. Kết nối đến CSDL
$conn = initConnection();
//B2. Chuẩn bị câu truy vấn
$sqlAllCategories = "SELECT * FROM categories";

$limit = 5;
$queryCategoryTotal = mysqli_query($conn, $sqlAllCategories);
$totalRecords = mysqli_num_rows($queryCategoryTotal);
$totalPage = ceil($totalRecords / $limit);

if (isset($_GET['p'])) {
	$p = $_GET['p'];
} else {
	$p = 1;
}

if ($p < 1) {
	$p = 1;
}
if ($p > $totalPage && $totalPage > 1) {
	$p = $totalPage;
}

//Công thức dùng để phân trang
$start = ($p - 1) * $limit;
$sqlCategory = "SELECT * FROM categories
	LIMIT $start,$limit";

//B3. Thực thi câu truy vấn
$queryCategory = mysqli_query($conn, $sqlCategory);
$numberOfCategory = mysqli_num_rows($queryCategory);
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><svg class="glyph stroked home">
						<use xlink:href="#stroked-home"></use>
					</svg></a></li>
			<li class="active">Quản lý danh mục</li>
		</ol>
	</div><!--/.row-->

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Quản lý danh mục</h1>
		</div>
	</div><!--/.row-->
	<div id="toolbar" class="btn-group">
		<a href="index.php?page=add_category" class="btn btn-success">
			<i class="glyphicon glyphicon-plus"></i> Thêm danh mục
		</a>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<table data-toolbar="#toolbar" data-toggle="table">
						<thead>
							<tr>
								<th data-field="id" data-sortable="true">ID</th>
								<th>Tên danh mục</th>
								<th>Trạng thái</th>
								<th>Hành động</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if ($numberOfCategory > 0) {
								while ($row = mysqli_fetch_assoc($queryCategory)) {
							?>
							<tr class="text-center">
								<td>
									<?php echo $row['cat_id']; ?>
								</td>
								<td>
									<?php echo $row['cat_name']; ?>
								</td>
								<td>
									<?php
									if ($row['isDeleted'] == 0) {
										echo '</p class="text-success"> Hoạt Động <p>';
									} else {
										echo '</p class="text-danger"> Tạm Dừng <p>';
									}
									?>
								</td>
								<td class="form-group">
									<a href="index.php?page=edit_category&id=<?php echo $row['cat_id']; ?>" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i></a>
									<a href="index.php?page=delete_category&id=<?php echo $row['cat_id']; ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
								</td>
							</tr>
							<?php
								}
							}
							?>
						</tbody>
					</table>
				</div>

			<div id="pagination" class="mx-3">
			<ul class="pagination">
			<!-- Trang Trước -->
			<?php
			if ($p > 1) {
				$prev = $p - 1;
			?>
				<li class="page-item <?php if ($i ==  $p) echo 'active'; ?>">
					<a class="page-link text-success" href="index.php?page=category&p=<?php echo $prev; ?>">Previous</a>
				</li>
			<?php
			}
			?>

			<!-- Các trang giữa -->
			<?php
			for ($i = 1; $i <= $totalPage; $i++) {
			?>
				<li class="page-item <?php if ($i ==  $p) echo 'active'; ?> ">
					<a class="page-link" href="index.php?page=category&p=<?php echo $i; ?>">
						<?php echo $i; ?>
					</a>
				</li>
			<?php
			}
			?>

			<!-- Trang Sau -->
			<?php
			if ($p < $totalPage && $totalPage > 1) {
				$next = $p + 1;
			?>
				<li class="page-item <?php if ($i ==  $p) echo 'active'; ?>">
					<a class="page-link text-success" href="index.php?page=category&p=<?php echo $next; ?>">Next</a>
				</li>
			<?php
			}
			?>
			</ul>
			</div>

			</div>
		</div>
	</div><!--/.row-->
</div> <!--/.main-->