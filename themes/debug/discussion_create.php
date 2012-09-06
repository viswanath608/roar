<?php theme_include('partials/header'); ?>

	<?php echo Form::open(discussion_create_url()); ?>
		<h3>Create a new discussion</h3>

		<p><label>Category<br>
		<?php echo Form::select('category', $categories); ?></label></p>

		<p><label>Title<br>
		<?php echo Form::input('title'); ?></label></p>

		<p><label>Short Description<br>
		<?php echo Form::textarea('description'); ?></label></p>

		<p><label>Post<br>
		<?php echo Form::textarea('post'); ?></label></p>

		<p><?php echo Form::button(array('type' => 'submit', 'class' => 'btn', 'content' => 'Create Discussion')); ?></p>
	<?php echo Form::close(); ?>

<?php theme_include('partials/footer'); ?>