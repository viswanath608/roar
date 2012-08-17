<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo __('common.manage', 'Manage'); ?> <?php echo Config::get('meta.sitename'); ?></title>

		<link rel="stylesheet" href="<?php echo asset('css/styles.css'); ?>">
	</head>
	<body>

		<header id="top">
			<h2><a id="logo" href="<?php echo url('posts'); ?>">Anchor CMS</a></h2>

			<?php if($user = Auth::user()): ?>
			<nav>
				<ul>
					<li><a href="<?php echo url('posts'); ?>"><?php echo __('common.posts', 'Posts'); ?></a></li>
					<li><a href="<?php echo url('pages'); ?>"><?php echo __('common.pages', 'Pages'); ?></a></li>
					<li><a href="<?php echo url('comments'); ?>"><?php echo __('common.comments', 'Comments'); ?></a></li>
					<li><a href="<?php echo url('categories'); ?>"><?php echo __('common.categories', 'Categories'); ?></a></li>
					<li><a href="<?php echo url('users'); ?>"><?php echo __('common.users', 'Users'); ?></a></li>
					<li><a href="<?php echo url('metadata'); ?>"><?php echo __('common.metadata', 'Metadata'); ?></a></li>
					<li><a href="<?php echo url('extend'); ?>"><?php echo __('common.extend', 'Extend'); ?></a></li>
				</ul>
			</nav>

			<p>
				<?php echo __('common.logged_in_as', 'Logged in as'); ?> <strong><?php echo $user->real_name; ?></strong>. 
				<a href="<?php echo url('logout'); ?>"><?php echo __('common.logout', 'Logout'); ?></a>
			</p>
			<?php endif; ?>
		</header>

