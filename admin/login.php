<?php 
	session_start();
	/**
	 * Nếu như người dùng đã đăng nhập thì sẽ tồn tại $_SESSION['user_logged']
	 * => isset($_SESSION['user_logged']) = true
	 * Nếu như người dùng chưa đăng nhập thì sẽ không tồn tại $_SESSION['user_logged']
	 * => isset($_SESSION['user_logged']) = false
	 */

	 /**
	  * Nếu người dùng đã đăng nhập thì không cho phép người dùng quay trở lại trang login
	  */

	if(isset($_SESSION['user_logged'])) {
		header("location:index.php");
	}
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
<link href="public/css/styles.css" rel="stylesheet">

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->
<style>
	.error-text {
		font-size: 13px;
	}
</style>
</head>

<body>
	
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">Online Mobile Shop - Administrator</div>
				<div class="panel-body">
					<?php 
						if(isset($_SESSION['error']['invalid_account'])) {
							echo $_SESSION['error']['invalid_account'];
							unset($_SESSION['error']['invalid_account']);
						}
					?>
					<form action="login-process.php" role="form" method="post">
						<fieldset>
							<div class="form-group">
								<input class="form-control" placeholder="E-mail" name="mail" 
								value="<?php if(isset($_SESSION['old_email'])) {echo $_SESSION['old_email'];} ?>" type="email" autofocus>
								<?php 
									if(isset($_SESSION['error']['mail'])) {
										echo $_SESSION['error']['mail'];
										unset($_SESSION['error']['mail']);
									}
								?>
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Mật khẩu" name="pass" type="password" value="">
								<?php 
									if(isset($_SESSION['error']['pass'])) {
										echo $_SESSION['error']['pass'];
										unset($_SESSION['error']['pass']);
									}
								?>
							</div>
							<div class="checkbox">
								<label>
									<input name="remember" type="checkbox" value="Remember Me">Nhớ tài khoản
								</label>
							</div>
							<button type="submit" class="btn btn-primary">Đăng nhập</button>
						</fieldset>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->	
</body>

</html>
