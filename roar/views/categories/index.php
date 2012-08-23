<?php echo $header; ?>

			<h1><?php echo __('categories.categories', 'Categories'); ?></h1>

			<nav>
				<ul>
					<li><a href="<?php echo url('categories/add'); ?>">
						<?php echo __('categories.create_category', 'Create a new category'); ?></a></li>
				</ul>
			</nav>

			<?php echo $messages; ?>

			<section class="content">
				<ul class="list">
					<?php foreach($categories->results as $category): ?>
					<li>
						<a href="<?php echo url('categories/edit/' . $category->id); ?>"><?php echo Str::limit($category->title, 4); ?></a>
					</li>
					<?php endforeach; ?>
				</ul>

				<?php echo $categories->links(); ?>
			</section>

<?php echo $footer; ?>