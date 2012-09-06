<?php echo $header; ?>

			<h1><?php echo __('users.log_in', 'Log in'); ?></h1>

			<?php echo $messages; ?>

			<section class="content">

				<form method="post" action="<?php echo url('login'); ?>">

					<input name="token" type="hidden" value="<?php echo $token; ?>">
					
					<fieldset>
						<p>
							<label for="user"><?php echo __('users.username', 'Username'); ?>:</label>
							<input autocapitalize="off" name="user" id="user" value="<?php echo Input::filter('user'); ?>">
						</p>
						
						<p>
							<label for="pass"><?php echo __('users.password', 'Password'); ?>:</label>
							<input type="password" name="pass" id="pass">
							
							<em><a href="<?php echo url('amnesia'); ?>"><?php echo __('users.forgotten_password', 'Forgotten your password?'); ?></a></em>
						</p>

						<p class="buttons">
							<button type="submit"><?php echo __('users.login', 'Login'); ?></button>
							<a href="<?php echo site(); ?>">Back to <?php echo Config::get('settings.forum_name'); ?></a>
						</p>
					</fieldset>
				</form>

			</section>

<?php echo $footer; ?>