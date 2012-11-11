<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
		<title><?php echo site_name(); ?></title>

		<!--[if lt IE 9]>
		<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<link rel="stylesheet" href="<?php echo theme_url('assets/css/normalize.css'); ?>">
		<link rel="stylesheet" href="<?php echo theme_url('assets/css/grid.css'); ?>">
		<link rel="stylesheet" href="<?php echo theme_url('assets/css/styles.css'); ?>">
		<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans">
	</head>
	<body>

		<header>
			<section class="container">
				<a class="logo" href="<?php echo base_url(); ?>"><?php echo site_name(); ?></a>

				<nav>
					<ul class="unstyled">
						<li><a href="<?php echo base_url(); ?>">Home</a></li>
						<li><a href="<?php echo base_url() . 'search'; ?>">Search</a></li>
						<?php if(user_guest()): ?>
						<li><a href="<?php echo base_url() . 'sign-in-with-twitter'; ?>">Sign in with Twitter</a></li>
						<li><a href="<?php echo base_url() . 'register'; ?>">Dont have Twitter? Register here</a></li>
						<li><a href="<?php echo base_url() . 'login'; ?>">Login to <?php echo site_name(); ?></a></li>
						<?php else: ?>
						<li><a href="<?php echo base_url() . 'profiles/' . Auth::user()->username; ?>">My Account</a></li>
						<li><a href="<?php echo base_url() . 'logout'; ?>">Logout</a></li>
						<?php endif; ?>
					</ul>
				</nav>
			</section>
		</header>

		<section class="container">

			<?php echo notifications(); ?>

