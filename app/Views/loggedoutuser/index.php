<!doctype html>
<html lang="en" class="no-js">

<head>
	<?php include('header.php'); ?>
</head>

<body>
	<div class="login-page bk-img">
		<div class="form-content">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<h1 class="text-center text-bold mt-4x" style="color:white">Maiden Drop Login</h1>
						<div class="well row pt-2x pb-3x bk-light">
							<div class="col-md-8 col-md-offset-2">
								<form method="post" action="<?php echo base_url('home/check_login') ?>">
									<label class="text-uppercase text-sm">Username</label>
									<input type="text" placeholder="Username" name="username" class="form-control mb" required>

									<label class="text-uppercase text-sm">Password</label>
									<input type="password" placeholder="Password" name="password" class="form-control mb" required>
									<button class="btn btn-primary btn-block" name="login" type="submit">LOGIN</button>
								</form>
							</div>
						</div>
						<b style="color: white !important;">
							<a target="_blank" href="<?php echo base_url() . '/terms_and_conditions.html' ?>">Terms and Conditions</a>&nbsp;&nbsp;&nbsp;
							<a target="_blank" href="<?php echo base_url() . '/fee_refund_and_cancellation_policy.html' ?>">Fee Refund and Cancellation Policy</a>&nbsp;&nbsp;&nbsp;
							<a target="_blank" href="<?php echo base_url() . '/privacy_policy.html' ?>">Privacy Policy</a>&nbsp;&nbsp;&nbsp;
							<a target="_blank" href="<?php echo base_url() . '/about_us.html' ?>">About Us</a>
							<br />
							<br />
							Address: Plot No. 3, Rd Number 12, Madhapur, Telangana - 500081 <br />
							Phone: 9121144137
						</b>

					</div>
				</div>
			</div>
		</div>

	</div>
</body>

</html>