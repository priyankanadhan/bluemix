<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="Lenco Admin Panel" />
<meta name="author" content="" />

<title>Currents Retail</title>

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
<link rel="stylesheet" href="<?php echo URL_LENCO; ?>css/flexslider.css">
<link rel="stylesheet"
	href="<?php echo URL_LENCO; ?>css/fonts/meteocons/css/meteocons.css">
<link rel="stylesheet" href="<?php echo URL_LENCO; ?>css/custom.css">
<link rel="stylesheet"
	href="<?php echo URL_LENCO; ?>/js/dropzone/css/dropzone.css">
<script src="<?php echo URL_LENCO; ?>js/jquery-1.11.1.min.js"></script>

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
<script type="text/javascript">
        var pathToImageCategories = "<?php echo URL_LENCO; ?>";
    </script>

</head>
<body class="page-body">

	<div class="page-container">
		<!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->

		<!-- Add "fixed" class to make the sidebar fixed always to the browser viewport. -->
		<!-- Adding class "toggle-others" will keep only one menu item open at a time. -->
		<!-- Adding class "collapsed" collapse sidebar root elements and show only icons. -->
		<div class="sidebar-menu toggle-others collapsed">

			<div class="sidebar-menu-inner">

				<header class="logo-env">

					<!-- logo -->
					<div class="logo">
						<a href="#" class="logo-expanded"> <img
							src="<?php echo URL_LENCO; ?>images/logo@2x.png" width="80"
							alt="" />
						</a> <a href="#" class="logo-collapsed"> <img
							src="<?php echo URL_LENCO; ?>images/logo-collapsed@2x.png"
							width="40" alt="" />
						</a>
					</div>

					<!-- This will toggle the mobile menu and will be visible only on mobile devices -->
					<div class="mobile-menu-toggle visible-xs">
						<!--a href="#" data-toggle="user-info-menu">
							<i class="fa-bell-o"></i>
							<span class="badge badge-success">7</span>
						</a-->

						<a href="#" data-toggle="mobile-menu"> <i class="fa-bars"></i>
						</a>
					</div>

					<!-- This will open the popup with user profile settings, you can use for any purpose, just be creative -->
					<!--div class="settings-icon">
						<a href="#" data-toggle="settings-pane" data-animate="true">
							<i class="linecons-cog"></i>
						</a>
					</div-->


				</header>

				<!-- Sidebar User Info Bar - Added in 1.3 -->
				<section class="sidebar-user-info">
					<div class="sidebar-user-info-inner">
						<a href="#" class="user-profile"> <img
							src="<?php echo URL_LENCO; ?>images/user-4.png" width="60"
							height="60" class="img-circle img-corona" alt="user-pic" /> <span>
								<strong><?php //echo $_SESSION['name']." ".$_SESSION[''];?></strong>
								<?php if($_SESSION['sess_username']=="admin"){?>Page admin <?php } ?>
							</span>
						</a>

						<ul class="user-links list-unstyled">
							<li class="logout-link"><a href="/login/changepassword"
								title="Change Password"> <i class="fa-key">&nbsp;Change Password</i>
							</a></li>
							<li class="logout-link"><a href="/login/logout" title="Log out">
									<i class="fa-power-off">&nbsp;Logout</i>
							</a></li>
						</ul>
					</div>
				</section>


				<ul id="main-menu" class="main-menu">
					<!-- add class "multiple-expanded" to allow multiple submenus to open -->
					<!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
					 <?php if($_SESSION['role'] == '1'){?>
					<li><a href="/dashboard/index" alt="Dashboard" title="Dashboard"> <i
							class="fa-dashboard"></i> <span class="title">Dashboard</span>
					</a></li>
					 <?php }?> 
					 <?php if($_SESSION['role'] == '4'){?>	
					<li><a href="/empdashboard/index" alt="Dashboard" title="Dashboard">
							<i class="fa-dashboard"></i> <span class="title">Dashboard</span>
					</a></li>
                 <?php }?> 
                   <?php if($_SESSION['role'] == '1'){?>
                    <li><a href="/products/index" alt="Products - Admin"
						title="Products - Admin"> <i class="linecons-star"></i> <span
							class="title">Products - Admin</span>
					</a></li>
					<li><a href="/categories/index" alt="Categories" title="Categories">
							<i class="linecons-database"></i> <span class="title">Categories</span>
					</a></li>
					<?php }?> 
					
                    <li><a href="/customers/index" alt="Customer List"
						title="Customer List"> <i class="linecons-cog"></i> <span
							class="title">Customer List</span>
					</a></li>		
					<?php if($_SESSION['role'] == '2'){?>
					<li><a href="/dashboard/storeDashboard"> <i class="fa-dashboard"></i> <span
							class="title">Dashboard</span>
					</a></li>	
					<?php }?> 
					<?php if($_SESSION['role'] == '1'){?>
					<li><a href="/employee/index" alt="Employees" title="Employees"> <i
							class="fa-group"></i> <span class="title">Employee Details</span>
					</a></li><?php }?>
					
					<?php if($_SESSION['role'] == '1'){?>
					<li><a href="/builtin/index" alt="Daily Updates" title="Daily Updates"> <i
							class="meteocons-sun-inv"></i> <span class="title">Built In Board Page</span>
					</a></li><?php }?>
					<?php if($_SESSION['role'] != '1'){?>
                    <li><a href="/builtin/dailyUpdates" alt="Daily Updates"
						title="Daily Updates"> <i class="linecons-photo"></i> <span class="title">Built
								In Board</span>
					</a></li>
                    <?php }?>
				</ul>
				<?php if($_SESSION['role'] == '1' || $_SESSION['role'] == '4' || $_SESSION['role'] == '2'){?>
				<ul id="main-menu" class="main-menu">
					<li class="active opened active"><a href="#" alt="Reports"
						title="Reports"> <i class="linecons-note"></i> <span
							class="title">Reports</span>
					</a>
						<ul>
							<li><a href="/dashboard/storeWiseLead" alt="Store Wise Leads"
								title="Store Wise Leads"> <span class="title">Store Wise Leads</span>
							</a></li>
							<li><a href="/dashboard/employeeWiseLead"
								alt="Employee Wise Leads" title="Employee Wise Leads"><span
									class="title">Employee Wise Leads</span> </a></li>
							<li><a href="/dashboard/storeWiseDemoView" alt="Store Wise Demo"
								title="Store Wise Demo"><span class="title">Store Wise Demo</span>
							</a></li>
							<li><a href="/dashboard/employeeWiseDemoView"
								alt="Employee Wise Demo" title="Employee Wise Demo"><span
									class="title">Employee Wise Demo</span> </a></li>
							<li><a href="/dashboard/storeWiseSourceView"
								alt="Store Wise Source" title="Store Wise Source"><span
									class="title">Store Wise Source</span> </a></li>
						</ul></li>
				</ul><?php }?> 
			</div>

		</div>

		<div class="main-content">

			<nav class="navbar user-info-navbar" role="navigation">
				<!-- User Info, Notifications and Menu Bar -->

				<!-- Left links for user info navbar -->
				<ul class="user-info-menu left-links list-inline list-unstyled">

					<li class="hidden-sm hidden-xs"><a href="#" data-toggle="sidebar">
							<i class="fa-bars"></i>
					</a></li>
				</ul>


				<!-- Right links for user info navbar -->
				<ul class="user-info-menu right-links list-inline list-unstyled">

					<li class="dropdown user-profile"><a href="#"
						class="dropdown-toggle" data-toggle="dropdown"> <img
							src="<?php echo URL_LENCO; ?>images/user-4.png" alt="user-image"
							class="img-circle img-inline userpic-32" width="28" /> <span>
								<?php echo $_SESSION['name']." "."";//$_SESSION[''];?>
								<i class="fa-angle-down"></i>
						</span>
					</a>

						<ul class="dropdown-menu user-profile-menu list-unstyled">
							<li class="last"><a href="/login/logout"> <i class="fa-lock"></i>
									Logout
							</a></li>
						</ul></li>

				</ul>

			</nav>