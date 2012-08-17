<?php theme_include('partials/header'); ?>

	<h3>Search</h3>

	<?php echo Form::open(base_url() . 'search'); ?>

	<fieldset>
		<p><label>Search Term<br>
		<?php echo Form::input('query', Input::old('query')); ?></label></p>

		<?php echo Form::submit('submit', 'Search'); ?>
	</fieldset>

	<?php echo Form::close(); ?>

	<?php if(search_has_results()): ?>
	<ul>
		<?php while(search_results()): ?>
		<li>
			<h3><a href="<?php echo post_url(); ?>"><?php echo post_title(); ?></a></h3>

			<?php echo post_body(); ?>
		</li>
		<?php endwhile; ?>
	</ul>

	<?php echo search_paging(); ?>

	<?php endif; ?>

<?php theme_include('partials/footer'); ?>