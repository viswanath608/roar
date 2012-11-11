<?php theme_include('partials/header'); ?>

	<div class="gs-row">
		<h3 class="gs gs-1-2"><?php echo category_title(); ?></h3>

		<p class="gs gs-1-2"><a class="btn pull-right" href="<?php echo discussion_create_url(); ?>">Start a new discussion</a></p>
	</div>

	<div class="gs-row">
		<div class="gs gs-1-3">
			<ul class="unstyled categories">
				<?php while(categories()): ?>
				<li>
					<h3><a href="<?php echo category_url(); ?>"><?php echo category_title(); ?></a></h3>
					<p><?php echo category_description(); ?></p>
				</li>
				<?php endwhile; ?>
			</ul>
		</div>

		<div class="gs gs-2-3">
			<ul class="unstyled discussions">
				<?php while(discussions()): ?>
				<li>
					<?php if(discussion_unread()): ?><h3 class="title unread"><?php else: ?><h3 class="title"><?php endif; ?>
					<a href="<?php echo discussion_url(); ?>"><?php echo discussion_title(); ?></a></h3>

					<p><?php echo discussion_description(); ?></p>

					<p>Started by <a href="<?php echo discussion_created_by_url(); ?>"><?php echo discussion_created_by(); ?></a> at <?php echo discussion_created(); ?></p>
					<p>Last post by <a href="<?php echo discussion_lastpost_by_url(); ?>"><?php echo discussion_lastpost_by(); ?></a> at <?php echo discussion_lastpost(); ?></p>

					<div class="stats">
						<div class="stat replies"><span>Total replies</span> <?php echo discussion_replies(); ?></div>
						<div class="stat views"><span>Total views</span> <?php echo discussion_views(); ?></div>
						<div class="stat votes"><span>Votes</span> <?php echo discussion_votes(); ?></div>
					</div>
				</li>
				<?php endwhile; ?>
			</ul>
		</div>
	</div>

<?php theme_include('partials/footer'); ?>