<?php echo $header; ?>

			<h1><?php echo __('posts.posts', 'Posts'); ?></h1>

			<nav>
				<ul>
					<li><a href="<?php echo url('posts/add'); ?>"><?php echo __('posts.create_post', 'Create a new post'); ?></a></li>
				</ul>
			</nav>

			<?php echo $messages; ?>

			<section class="content">
			<?php if($posts->count): ?>
				<ul class="list">
					<?php foreach($posts->results as $article): ?>
					<li>
						<p><a href="<?php echo url('posts/edit/' . $article->id); ?>"><?php echo Str::limit($article->title, 4); ?></a></p>

						<p><?php echo __('posts.created'); ?> <time><?php echo Date::format($article->created); ?></time>
						<?php echo __('posts.by'); ?> <?php echo $article->author; ?></p>

						<span class="status"><?php echo $article->status; ?></span>
					</li>
					<?php endforeach; ?>
				</ul>

				<?php echo $posts->links(); ?>
			<?php else: ?>
				<p><a href="<?php echo url('posts/add'); ?>"><?php echo __('posts.noposts', 'No posts just yet. Why not write a new one?'); ?></a></p>
			<?php endif; ?>
			</section>

<?php echo $footer; ?>