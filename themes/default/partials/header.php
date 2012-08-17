<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
		<title><?php echo forum_name(); ?></title>

		<!--[if lt IE 9]>
		<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<link rel="stylesheet" href="<?php echo theme_url('assets/css/styles.css'); ?>">
		
		<script src="//code.jquery.com/jquery-latest.min.js"></script>
		<script src="<?php echo theme_url('assets/js/roar.js'); ?>"></script>
	</head>
	<body>

		<header id="top">
			<a id="home-link" href="<?php echo base_url(); ?>"><?php echo forum_name(); ?></a>

			<nav>
				<ul>
					<li><a href="<?php echo base_url(); ?>">Home</a></li>
					<li><a class="search-link" href="<?php echo base_url() . 'search'; ?>">Search</a></li>
				</ul>

				<?php if(Auth::guest()): ?>
				<ul>
					<li>
						<a href="<?php echo base_url() . 'sign-in-with-twitter'; ?>">Sign in with Twitter</a><br>
						<small><a href="<?php echo base_url() . 'register'; ?>">Dont have Twitter? Register here</a></small>
					</li>
					<li><a href="<?php echo base_url() . 'login'; ?>">Login to <?php echo forum_name(); ?></a></li>
				</ul>
				<?php else: ?>
				<ul>
					<li>
						<a href="<?php echo base_url() . 'profiles/' . Auth::user()->username; ?>">My Account</a>
						<a href="<?php echo base_url() . 'logout'; ?>">Logout</a>
					</li>
				</ul>
				<?php endif; ?>
			</nav>
		</header>

		<?php echo Notify::read(); ?>
		
		<div id="content">