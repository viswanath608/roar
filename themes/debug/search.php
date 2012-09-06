<?php theme_include('partials/header'); ?>

	<h3>Search</h3>

	<div class="gs-open">
		<div class="gs gs-1-3">
		<?php echo Form::open(base_url() . 'search'); ?>
			<p><label>Search Term<br>
			<?php echo Form::input(array('class' => 'gs-4-5', 'name' => 'query'), Input::old('query')); ?></label></p>

			<p><?php echo Form::button(array('type' => 'submit', 'class' => 'btn', 'content' => 'Search')); ?></p>
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