<?php echo $header; ?>

			<h1><?php echo __('metadata.metadata'); ?></h1>

			<?php echo $messages; ?>

			<section class="content">

				<form method="post" action="<?php echo url('metadata'); ?>" novalidate>

					<input name="token" type="hidden" value="<?php echo $token; ?>">

					<fieldset>
						<p>
							<label for="sitename"><?php echo __('metadata.sitename'); ?>:</label>
							<input id="sitename" name="sitename" value="<?php echo Input::old('sitename', $meta['sitename']); ?>">
							
							<em><?php echo __('metadata.sitename_explain'); ?></em>
						</p>

						<p>
							<label for="description"><?php echo __('metadata.sitedescription'); ?>:</label>
							<input id="description" name="description" value="<?php echo Input::old('description', $meta['description']); ?>">
							
							<em><?php echo __('metadata.sitedescription_explain'); ?></em>
						</p>
					</fieldset>
					
					<p class="buttons">
						<button type="submit"><?php echo __('metadata.save'); ?></button>
					</p>
					
				</form>
			</section>

<?php echo $footer; ?>