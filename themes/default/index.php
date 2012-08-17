<?php theme_include('partials/header'); ?>

	<ul>
	<?php while(forums()): ?>
	<li>
		<h3><a href="<?php echo forum_url(); ?>"><?php echo forum_title(); ?></a></h3>
		<p><?php echo forum_description(); ?></p>
	</li>
	<?php endwhile; ?>
	</ul>

<?php theme_include('partials/footer'); ?>