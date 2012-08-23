<?php theme_include('partials/header'); ?>

	<h3><?php echo forum_title(); ?></h3>
	
	<p><a href="<?php echo topic_create_url(); ?>">Start a new topic</a></p>

	<ul>
	<?php while(topics()): ?>
	<li>
		<h3><a href="<?php echo topic_url(); ?>"><?php echo topic_title(); ?></a></h3>

		<p><?php echo topic_description(); ?></p>

		<p>Started by <a href="<?php echo topic_created_by_url(); ?>"><?php echo topic_created_by(); ?></a> at <?php echo topic_created(); ?></p>
		<p>Last post by <a href="<?php echo topic_lastpost_by_url(); ?>"><?php echo topic_lastpost_by(); ?></a> at <?php echo topic_lastpost(); ?></p>

		<?php if(topic_has_tags()): ?>
		<p>Tags <?php echo topic_tags(); ?></p>
		<?php endif; ?>

		<p>Total replies <?php echo topic_replies(); ?></p>
		<p>Total views <?php echo topic_views(); ?></p>
		<p>Votes <?php echo topic_votes(); ?></p>
	</li>
	<?php endwhile; ?>
	</ul>

<?php theme_include('partials/footer'); ?>