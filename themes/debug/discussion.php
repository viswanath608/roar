<?php theme_include('partials/header'); ?>

	<div class="gs-open">
		<div class="gs gs-1-2">
			<h3><?php echo discussion_title(); ?></h3>

			<p>Posted in <a href="<?php echo category_url(); ?>"><?php echo category_title(); ?></a>
			by <a href="<?php echo discussion_created_by_url(); ?>"><?php echo discussion_created_by(); ?></a></p>
		</div>
		<div class="gs gs-1-2">
			<p class="pull-right"><a class="btn" href="<?php echo discussion_vote_url(); ?>">Up Vote <span class="votes"><?php echo discussion_votes(); ?></span> </a></p>
		</div>
	</div>

	<aside class="paging"><?php echo discussion_paging(); ?></aside>

	<div class="gs-open">
		<div class="gs gs-1-3">
			<ul class="unstyled categories">
				<?php while(categories()): ?>
				<li>
					<h3><a href="<?php echo category_url(); ?>"><?php echo category_title(); ?></a></h3>
					<p><?php echo category_description(); ?></p>
				</li>
				<?php endwhile; ?>
			</ul>
		</div>

		<div class="gs gs-2-3">
			<ul class="unstyled posts">
				<?php while(posts()): ?>
				<li>
					<div id="post-<?php echo post_id(); ?>"><?php echo post_body(); ?></div>

					<div class="gs-open">
						<span class="pull-left"><em>by <a href="<?php echo post_user_url(); ?>"><?php echo post_user(); ?></a> posted at <?php echo post_date(); ?></em></span>

						<span class="pull-right"><a href="<?php echo post_quote_url(); ?>">Quote</a> <a href="<?php echo post_report_url(); ?>">Report</a></span>
					</div>
				</li>
				<?php endwhile; ?>
			</ul>

			<aside class="paging"><?php echo discussion_paging(); ?></aside>

			<?php echo Form::open(discussion_url()); ?>
				<h3>Add your reply</h3>

				<p><?php echo Form::textarea('reply'); ?><br>
				<small><em><a href="http://daringfireball.net/projects/markdown/syntax/">Markdown Syntax</a></em></small></p>

				<p><?php echo Form::button(array('type' => 'submit', 'class' => 'btn', 'content' => 'Reply')); ?></p>
			<?php echo Form::close(); ?>
		</div>
	</div>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
	<script>
		(function() {
			var a = $('a[href*=#quote-]');

			var strip = function(html) {
				return html.replace(/(<([^>]+)>)/ig, '');
			};

			var quote = function() {
				var item = $(this), id = item.attr('href').split('-').pop();
				var content = $('#post-' + id).html().split(/\r\n|\r|\n/);
				var quote = '';

				for(var line = 0; line < content.length; line++) {
					quote += '> ' + strip(content[line]) + "\n";
				}

				var textarea = $('form textarea');
				
				textarea.val(quote);
				textarea.scrollIntoView(true);

				return false;
			};

			a.bind('click', quote);
		}());
	</script>

<?php theme_include('partials/footer'); ?>