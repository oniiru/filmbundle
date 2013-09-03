<div class="my_meta_control">
	
	<label>Full Embed</label>
 
	<p>
		<input type="text" name="<?php $metabox->the_name('fullembed'); ?>" value="<?php $metabox->the_value('fullembed'); ?>"/>
	</p>
	<label>Trailer Embed</label>
 
	<p>
		<input type="text" name="<?php $metabox->the_name('trailerembed'); ?>" value="<?php $metabox->the_value('trailerembed'); ?>"/>
	</p>
	<?php global $wpalchemy_media_access; ?>
	
	<?php $mb->the_field('backgroundimage'); ?>
	    <?php $wpalchemy_media_access->setGroupName('nn2')->setInsertButtonLabel('Insert'); ?>
	
	    <p>
			<label>Background Image</label>
	        <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
	        <?php echo $wpalchemy_media_access->getButton(); ?>
	    </p>
		<label>Title</label>
 
		<p>
			<input type="text" name="<?php $metabox->the_name('title'); ?>" value="<?php $metabox->the_value('title'); ?>"/>
		</p>
		<label>Below Average</label><br/>
	
		<?php $mb->the_field('belowavg'); ?>
		<select name="<?php $mb->the_name(); ?>">
			<?php  // Get all available products
	                $args = array(
	                  'post_type' => 'download',
	                  'posts_per_page' => -1,
	                  'post_status' => 'any'
	                );
	                $products = get_posts($args);
					?>

			<?php foreach ($products as $product): ?>
			<option value="<?php echo $product->ID; ?>"<?php $mb->the_select_state($product->ID); ?>><?php echo $product->post_title; ?></option>
					<?php endforeach; ?>
		</select>
		

				<label>Above Average</label><br/>
		<?php $mb->the_field('aboveavg'); ?>
		<select name="<?php $mb->the_name(); ?>">
			<?php  // Get all available products
	                $args = array(
	                  'post_type' => 'download',
	                  'posts_per_page' => -1,
	                  'post_status' => 'any'
	                );
	                $products = get_posts($args);
					?>

			<?php foreach ($products as $product): ?>
			<option value="<?php echo $product->ID; ?>"<?php $mb->the_select_state($product->ID); ?>><?php echo $product->post_title; ?></option>
				<?php endforeach; ?>
		</select>
		
	
		
	</div>