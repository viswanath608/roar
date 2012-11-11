<?php theme_include('partials/header'); ?>

	<h3><?php echo user_name(); ?></h3>

	<div class="gs-row">
		<div class="gs gs-1-3">
			<p>Registered on <?php echo user_registered(); ?></p>

			<?php if(user_has_twitter()): ?>
			<p>Twitter <a href="<?php echo user_twitter_url(); ?>">@<?php echo user_username(); ?></a></p>
			<?php endif; ?>

			<p>Total posts <?php echo user_total_posts(); ?></p>
		</div>

		<div class="gs gs-2-3">
			<ul class="unstyled posts">
				<?php while(user_recent_posts()): ?>
				<li>
					<h3><a href="<?php echo post_url(); ?>"><?php echo post_title(); ?></a></h3>

					<?php echo post_body(); ?>
				</li>
				<?php endwhile; ?>
			</ul>
		</div>
	</div>

<?php theme_include('partials/footer'); ?>