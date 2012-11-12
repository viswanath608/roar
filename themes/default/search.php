<?php theme_include('partials/header'); ?>

	<h3>Search</h3>

	<div class="gs-row">
		<div class="gs gs-1-3">
		<?php echo Form::open('search'); ?>
			<p><label>Search Term<br>
			<?php echo Form::search('query', Input::old('query'), array('class' => 'gs-4-5')); ?></label></p>

			<p><?php echo Form::button('Search', array('type' => 'submit', 'class' => 'btn')); ?></p>
		<?php echo Form::close(); ?>
		</div>

		<div class="gs gs-2-3">
			<?php if(search_has_results()): ?>
			<ul class="unstyled posts">
				<?php while(search_results()): ?>
				<li>
					<div id="post-<?php echo post_id(); ?>"><?php echo post_body(); ?></div>

					<p><em>by <a href="<?php echo post_user_url(); ?>"><?php echo post_user(); ?></a> posted at <?php echo post_date(); ?></em></p>

					<p><a href="<?php echo post_quote_url(); ?>">Quote</a> <a href="<?php echo post_report_url(); ?>">Report</a></p>
				</li>
				<?php endwhile; ?>
			</ul>

			<aside class="paging"><?php echo search_paging(); ?></aside>
			<?php endif; ?>
		</div>
	</div>



<?php theme_include('partials/footer'); ?>