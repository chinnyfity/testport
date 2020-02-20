<!DOCTYPE html>
<html lang="en">
<head>
	<title>Administrator | TestPort</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link href="<?=base_url()?>images/logo2.png" rel="shortcut icon" type="image/png">
	
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>login_library/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>login_library/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>login_library/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>login_library/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>login_library/css/main.css">
</head>
<body>
	<input type="hidden" value="<?=base_url(); ?>" id="txtsite_url">
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-form-title" style="background-image: url(<?=base_url();?>login_library/images/bg-01.jpg);">
					<span class="login100-form-title-1">
						Administrator
					</span>
				</div>

				<form class="login100-form validate-form" autocomplete="off" action="javascript:;">
					<div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
						<span class="label-input100">Username</span>
						<input class="input100" type="text" name="username" placeholder="Enter username">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
						<span class="label-input100">Password</span>
						<input class="input100" type="password" name="pass" placeholder="Enter password">
						<span class="focus-input100"></span>
					</div>

					<div class="flex-sb-m w-full p-b-30">
						<div class="contact100-form-checkbox">
							<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
							<label class="label-checkbox100" for="ckb1">
								Remember me
							</label>
						</div>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>
				</form>
				<div class="alert alert-danger alert_msg"></div>
				<br>
			</div>
		</div>
	</div>
	
	<script src="<?=base_url();?>login_library/vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="<?=base_url();?>login_library/js/main.js"></script>

</body>
</html>