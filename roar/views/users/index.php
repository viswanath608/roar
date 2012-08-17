<?php echo $header; ?>

			<h1><?php echo __('users.users', 'Users'); ?></h1>

			<nav>
				<ul>
					<li><a href="<?php echo url('users/add'); ?>"><?php echo __('users.create_user', 'Create a new user'); ?></a></li>
				</ul>
			</nav>

			<?php echo $messages; ?>

			<section class="content">
				<ul class="list">
					<?php foreach($users->results as $user): ?>
					<li>
						<p><a href="<?php echo url('users/edit/' . $user->id); ?>"><?php echo $user->real_name; ?></a></p>

						<span class="status"><?php echo $user->status; ?></span>
					</li>
					<?php endforeach; ?>
				</ul>

				<?php echo $users->links(); ?>
			</section>

<?php echo $footer; ?>