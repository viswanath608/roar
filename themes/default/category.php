<?php theme_include('partials/header'); ?>

	<h3><?php echo category_title(); ?></h3>
	
	<p><a href="<?php echo discussion_create_url(); ?>">Start a new topic</a></p>

	<ul>
	<?php while(discussions()): ?>
	<li>
		<h3><a href="<?php echo discussion_url(); ?>"><?php echo discussion_title(); ?></a></h3>

		<p><?php echo discussion_description(); ?></p>

		<p>Started by <a href="<?php echo discussion_created_by_url(); ?>"><?php echo discussion_created_by(); ?></a> at <?php echo discussion_created(); ?></p>
		<p>Last post by <a href="<?php echo discussion_lastpost_by_url(); ?>"><?php echo discussion_lastpost_by(); ?></a> at <?php echo discussion_lastpost(); ?></p>

		<?php if(discussion_has_tags()): ?>
		<p>Tags <?php echo discussion_tags(); ?></p>
		<?php endif; ?>

		<p>Total replies <?php echo discussion_replies(); ?></p>
		<p>Total views <?php echo discussion_views(); ?></p>
		<p>Votes <?php echo discussion_votes(); ?></p>
	</li>
	<?php endwhile; ?>
	</ul>

<?php theme_include('partials/footer'); ?>