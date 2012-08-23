<?php theme_include('partials/header'); ?>

	<h3><?php echo topic_title(); ?></h3>
	<p>Posted in <a href="<?php echo forum_url(); ?>"><?php echo forum_title(); ?></a></p>
	<p>Started by <a href="<?php echo topic_created_by_url(); ?>"><?php echo topic_created_by(); ?></a></p>

	<p><strong><?php echo topic_votes(); ?> Votes</strong> <a href="<?php echo topic_vote_url(); ?>">Up Vote</a></p>

	<?php echo topic_paging(); ?>

	<ul>
	<?php while(posts()): ?>
	<li>
		<div id="post-<?php echo post_id(); ?>"><?php echo post_body(); ?></div>

		<p><em>by <a href="<?php echo post_user_url(); ?>"><?php echo post_user(); ?></a> posted at <?php echo post_date(); ?></em></p>

		<p><a href="<?php echo post_quote_url(); ?>">Quote</a> <a href="<?php echo post_report_url(); ?>">Report</a></p>
	</li>
	<?php endwhile; ?>
	</ul>

	<?php echo topic_paging(); ?>

	<?php echo Form::open(topic_url()); ?>

	<fieldset>
		<legend>Add your reply</legend>

		<p><?php echo Form::textarea('reply'); ?><br>
		<small><em><a href="http://daringfireball.net/projects/markdown/syntax/">Markdown Syntax</a></em></small></p>

		<?php echo Form::submit('submit', 'Reply'); ?>
	</fieldset>

	<?php echo Form::close(); ?>

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