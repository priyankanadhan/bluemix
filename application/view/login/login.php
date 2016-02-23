<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="Blue Mix Admin Panel" />
<meta name="author" content="" />

<title>Blue Mix - Login</title>

<!--link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Arimo:400,700,400italic"-->
<link rel="stylesheet"
	href="<?php echo URL_LENCO; ?>css/fonts/linecons/css/linecons.css">
<link rel="stylesheet"
	href="<?php echo URL_LENCO; ?>css/fonts/fontawesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo URL_LENCO; ?>css/bootstrap.css">
<link rel="stylesheet" href="<?php echo URL_LENCO; ?>css/xenon-core.css">
<link rel="stylesheet"
	href="<?php echo URL_LENCO; ?>css/xenon-forms.css">
<link rel="stylesheet"
	href="<?php echo URL_LENCO; ?>css/xenon-components.css">
<link rel="stylesheet"
	href="<?php echo URL_LENCO; ?>css/xenon-skins.css">
<link rel="stylesheet" href="<?php echo URL_LENCO; ?>css/custom.css">

<script src="<?php echo URL_LENCO; ?>js/jquery-1.11.1.min.js"></script>

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

<style>
.loginWrong {
	color: #E81D02;
}
</style>
</head>
<?php $imageUrl=URL."images/login_backgrd.jpg";?>
<body class="page-body login-page login-light" style="background-image:url('/public/images/login_backgrd.jpg')">


	<div class="login-container">

		<div class="row">

			<div class="col-sm-6" style="float:right;">

				<script type="text/javascript">
					jQuery(document).ready(function($)
					{
						// Reveal Login form
						setTimeout(function(){ $(".fade-in-effect").addClass('in'); }, 1);
	
	
						// Validation and Ajax action
						$("form#login").validate({
							rules: {
								username: {
									required: true
								},
	
								passwd: {
									required: true
								}
							},
	
							messages: {
								username: {
									required: 'Please enter your username.'
								},
	
								passwd: {
									required: 'Please enter your password.'
								}
							},
	
							// Form Processing via AJAX
							submitHandler: function(form)
							{
								
                                $form.submit();
                                /*show_loading_bar(70); // Fill progress bar to 70% (just a given value)
	
								var opts = {
									"closeButton": true,
									"debug": false,
									"positionClass": "toast-top-full-width",
									"onclick": null,
									"showDuration": "300",
									"hideDuration": "1000",
									"timeOut": "5000",
									"extendedTimeOut": "1000",
									"showEasing": "swing",
									"hideEasing": "linear",
									"showMethod": "fadeIn",
									"hideMethod": "fadeOut"
								};
                                
								$.ajax({
									url: "data/login-check.php",
									method: 'POST',
									dataType: 'json',
									data: {
										do_login: true,
										username: $(form).find('#username').val(),
										passwd: $(form).find('#passwd').val(),
									},
									success: function(resp)
									{
										show_loading_bar({
											delay: .5,
											pct: 100,
											finish: function(){
	
												// Redirect after successful login page (when progress bar reaches 100%)
												if(resp.accessGranted)
												{
																									window.location.href = 'dashboard-1.html';
																								}
																						}
										});
	
										
										// Remove any alert
										$(".errors-container .alert").slideUp('fast');
	
	
										// Show errors
										if(resp.accessGranted == false)
										{
											$(".errors-container").html('<div class="alert alert-danger">\
												<button type="button" class="close" data-dismiss="alert">\
													<span aria-hidden="true">&times;</span>\
													<span class="sr-only">Close</span>\
												</button>\
												' + resp.errors + '\
											</div>');
	
	
											$(".errors-container .alert").hide().slideDown();
											$(form).find('#passwd').select();
										}
																		}
								});*/
	
							}
						});
	
						// Set Form focus
						$("form#login .form-group:has(.form-control):first .form-control").focus();
					});
				</script>

				<!-- Errors container -->
				<div class="errors-container"></div>

				<!-- Add class "fade-in-effect" for login form effect -->
				<form method="post" role="form" id="login"
					class="login-form fade-in-effect" action="/login/index">

					<div class="login-header">


						<p>Dear user, log in to Photo Op !</p>
					</div>


					<div class="form-group">
						<label class="control-label" for="username">Username</label> <input
							type="text" class="form-control" name="username" id="username"
							autocomplete="off" />
					</div>

					<div class="form-group">
						<label class="control-label" for="passwd">Password</label> <input
							type="password" class="form-control" name="passwd" id="passwd"
							autocomplete="off" />
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-primary  btn-block text-left">
							<i class="fa-lock"></i> Log In
						</button>
						<a href="/events/register">Or Sign Up With Photo Op</a>
					</div>
                    <?php
																				if ($success == false) {
																					?>
					<div class="loginWrong">
						Credentials are Wrong!

						<!--div class="info-links">
							<a href="#">ToS</a> -
							<a href="#">Privacy Policy</a>
						</div-->

					</div>
                    <?php } ?>
	
				</form>

				<div class="external-login" style="width: 70%; padding-left: 25%;color:red;">
					<a href="<?php echo $authurl;?>" class="gplus"> <i class="fa-google-plus"></i> Login
						with Google Plus
					</a>

				</div>

			</div>

		</div>

	</div>



	<!-- Bottom Scripts -->
	<script src="<?php echo URL_LENCO; ?>js/bootstrap.min.js"></script>
	<script src="<?php echo URL_LENCO; ?>js/TweenMax.min.js"></script>
	<script src="<?php echo URL_LENCO; ?>js/resizeable.js"></script>
	<script src="<?php echo URL_LENCO; ?>js/joinable.js"></script>
	<script src="<?php echo URL_LENCO; ?>js/xenon-api.js"></script>
	<script src="<?php echo URL_LENCO; ?>js/xenon-toggles.js"></script>
	<script
		src="<?php echo URL_LENCO; ?>js/jquery-validate/jquery.validate.min.js"></script>
	<script src="<?php echo URL_LENCO; ?>js/toastr/toastr.min.js"></script>


	<!-- JavaScripts initializations and stuff -->
	<script src="<?php echo URL_LENCO; ?>js/xenon-custom.js"></script>

</body>
</html>
