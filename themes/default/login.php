<?php theme_include('partials/header'); ?>

	<h3>Login</h3>

	<?php echo Form::open('login'); ?>

	<fieldset>
		<p><label>Username<br>
		<?php echo Form::text('username', Input::old('username')); ?></label></p>

		<p><label>Password<br>
		<?php echo Form::password('password'); ?></label></p>

		<?php echo Form::submit('Login'); ?>
	</fieldset>

	<?php echo Form::close(); ?>

<?php theme_include('partials/footer'); ?>