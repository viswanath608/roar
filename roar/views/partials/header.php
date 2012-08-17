<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo __('common.manage', 'Manage'); ?> <?php echo Config::get('settings.forum_name'); ?></title>

		<link rel="stylesheet" href="<?php echo asset('css/styles.css'); ?>">
	</head>
	<body>

		<header>
			<h2><a href="<?php echo url('dashboard'); ?>">Roar Forum</a></h2>

			<?php if($user = Auth::user()): ?>
			<nav>
				<ul>
					<li><a href="<?php echo url('dashboard'); ?>"><?php echo __('common.dashboard', 'Dashboard'); ?></a></li>
					<li><a href="<?php echo url('forums'); ?>"><?php echo __('common.forums', 'Forums'); ?></a></li>
					<li><a href="<?php echo url('users'); ?>"><?php echo __('common.users', 'Users'); ?></a></li>
				</ul>
			</nav>

			<p>
				<?php echo __('common.logged_in_as', 'Logged in as'); ?> <strong><?php echo $user->name; ?></strong>. 
				<a href="<?php echo url('logout'); ?>"><?php echo __('common.logout', 'Logout'); ?></a>
			</p>
			<?php endif; ?>
		</header>

