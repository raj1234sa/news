<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Login :: Admin</title>
		<meta name="description" content="User login page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<link rel="stylesheet" href="<?php echo ADMIN_DIR_HTTP_CSS?>bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo ADMIN_DIR_HTTP_INCLUDE?>font-awesome/4.5.0/css/font-awesome.min.css" />
		<link rel="stylesheet" href="<?php echo ADMIN_DIR_HTTP_CSS?>fonts.googleapis.com.css" />
		<link rel="stylesheet" href="<?php echo ADMIN_DIR_HTTP_CSS?>ace.min.css" />
		<link rel="stylesheet" href="<?php echo ADMIN_DIR_HTTP_CSS?>ace-rtl.min.css" />
		<link rel="stylesheet" href="<?php echo ADMIN_DIR_HTTP_CSS?>login.css" />
	</head>
	<body class="login-layout light-login">
		<div class="main-container">
			<div class="main-content">
				<div class="row" style="height: 100vh">
					<div class="col-sm-10 col-sm-offset-1" style="height: 100%">
						<div class="login-container">
							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<i class="ace-icon fa fa-user"></i>
												Admin Login
											</h4>

											<div class="space-6"></div>

											<form action='' method='post'>
												<?php if(isset($message) && !empty($message)) { ?>
													<div class="alert alert-danger">
														<button type="button" class="close" data-dismiss="alert">
															<i class="ace-icon fa fa-times"></i>
														</button>
														<strong>Error!</strong> <?php echo $message ?>
													</div>
												<?php } ?>
												<input type="text" class="hide" value="<?php echo $backurl ?>" name="backUrl">
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" placeholder="Username" name="username" />
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" placeholder="Password" name="password" />
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>

													<div class="space"></div>

													<div class="clearfix">
														<button type="submit" class="width-35 pull-right btn btn-sm btn-primary" name="loginbtn">
															<i class="ace-icon fa fa-key"></i>
															<span class="bigger-110">Login</span>
														</button>
													</div>

													<div class="space-4"></div>
												</fieldset>
											</form>
										</div><!-- /.widget-main -->

										<div class="toolbar clearfix">
											<div>
												<a href="#" data-target="#forgot-box" class="forgot-password-link">
													<i class="ace-icon fa fa-arrow-left"></i>I forgot my password
												</a>
											</div>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.login-box -->
							</div><!-- /.position-relative -->
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.main-content -->
		</div><!-- /.main-container -->

		<!-- basic scripts -->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="<?php echo ADMIN_DIR_HTTP_JS ?>jquery-2.1.4.min.js"></script>
		<script src="<?php echo ADMIN_DIR_HTTP_JS ?>bootstrap.min.js"></script>
	</body>
</html>