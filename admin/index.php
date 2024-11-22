<?php
session_start();
include_once "config/db.php";
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Online Mobile Shop - Administrator</title>
	<link href="public/css/bootstrap.min.css" rel="stylesheet">
	<link href="public/css/datepicker3.css" rel="stylesheet">
	<link href="public/css/bootstrap-table.css" rel="stylesheet">
    <!-- font awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link href="public/css/styles.css" rel="stylesheet">

	<!--Icons-->
	<script src="public/js/lumino.glyphs.js"></script>
</head>

<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><span>Mobile</span>Shop</a>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user">
								<use xlink:href="#stroked-male-user"></use>
							</svg> Admin <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#"><svg class="glyph stroked male-user">
										<use xlink:href="#stroked-male-user"></use>
									</svg> Hồ sơ</a></li>
							<li><a href="logout.php"><svg class="glyph stroked cancel">
										<use xlink:href="#stroked-cancel"></use>
									</svg> Đăng xuất</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div><!-- /.container-fluid -->
	</nav>

	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<form role="search">
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Search">
			</div>
		</form>
		<ul class="nav menu">
			<li class="<?php if (!isset($_GET['page'])) echo 'active'; ?>"><a href="index.php"><svg class="glyph stroked dashboard-dial">
						<use xlink:href="#stroked-dashboard-dial"></use>
					</svg> Dashboard</a></li>

			<li class="<?php if (isset($_GET['page']) && $_GET['page'] == 'user') echo 'active'; ?>"><a href="index.php?page=user"><svg class="glyph stroked male user ">
						<use xlink:href="#stroked-male-user" />
					</svg>Quản lý người dùng</a></li>

			<li class="<?php if (isset($_GET['page']) && $_GET['page'] == 'product') echo 'active'; ?>"><a href="index.php?page=product"><svg class="glyph stroked open folder">
						<use xlink:href="#stroked-open-folder" />
					</svg>Quản lý sản phẩm</a></li>

			<li class="<?php if (isset($_GET['page']) && $_GET['page'] == 'category') echo 'active'; ?>"><a href="index.php?page=category"><svg class="glyph stroked open folder">
						<use xlink:href="#stroked-open-folder" />
					</svg>Danh Mục</a></li>

			<li class="<?php if (isset($_GET['page']) && $_GET['page'] == 'order') echo 'active'; ?>"><a href="index.php?page=order"><svg class="glyph stroked open folder">
						<use xlink:href="#stroked-open-folder" />
					</svg>Quản lý Đơn Hàng</a></li>
		</ul>

	</div><!--/.sidebar-->
	<!-- MAIN -->
	<?php
	if (isset($_GET['page'])) {
		$page = strtolower($_GET['page']); //chuyển sang chữ thường
		switch ($page) {
				// Module user
			case 'user':
				include_once "modules/user/user.php";
				break;
			case 'add_user':
				include_once "modules/user/add_user.php";
				break;
			case 'edit_user':
				include_once "modules/user/edit_user.php";
				break;
			case 'delete_user':
				include_once "modules/user/delete_user.php";
				break;

				// Module product
			case 'product':
				include_once "modules/product/product.php";
				break;
			case 'add_product':
				include_once "modules/product/add_product.php";
				break;
			case 'edit_product':
				include_once "modules/product/edit_product.php";
				break;
			case 'delete_product':
				include_once "modules/product/delete_product.php";
				break;
				
				// Module category
			case 'category':
				include_once "modules/category/category.php";
				break;
			case 'add_category':
				include_once "modules/category/add_category.php";
				break;
			case 'edit_category':
				include_once "modules/category/edit_category.php";
				break;
			case 'delete_category':
				include_once "modules/category/delete_category.php";
				break;

				// Module order
			case 'order':
				include_once "modules/order/order.php";
				break;
		}
	} else {
		include_once "modules/admin.php";
	}

	?>
	<!-- ./MAIN -->
	<script src="public/js/jquery-1.11.1.min.js"></script>
	<script src="public/js/bootstrap.min.js"></script>
	<script src="public/js/bootstrap-table.js"></script>
</body>

</html>