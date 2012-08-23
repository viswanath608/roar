<?php echo $header; ?>

			<h1><?php echo __('pages.pages', 'Pages'); ?></h1>

			<nav>
				<ul>
					<li><a href="<?php echo url('pages/add'); ?>"><?php echo __('pages.create_page', 'Create a new page'); ?></a></li>
				</ul>
			</nav>

			<?php echo $messages; ?>

			<section class="content">
				<ul class="list">
					<?php foreach($pages->results as $page): ?>
					<li>
						<p><a href="<?php echo url('pages/edit/' . $page->id); ?>"><?php echo Str::limit($page->name, 4); ?></a></p>

						<span class="status"><?php echo $page->status; ?></span>
					</li>
					<?php endforeach; ?>
				</ul>

				<?php echo $pages->links(); ?>
			</section>

<?php echo $footer; ?>