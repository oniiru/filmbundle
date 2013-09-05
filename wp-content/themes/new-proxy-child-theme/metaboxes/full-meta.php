<div class="my_meta_control">
	
	<label>Full Embed</label>
 
	<p>
		<input type="text" name="<?php $metabox->the_name('fullembed'); ?>" value="<?php $metabox->the_value('fullembed'); ?>"/>
	</p>
	<label>Trailer Embed</label>
 
	<p>
		<input type="text" name="<?php $metabox->the_name('trailerembed'); ?>" value="<?php $metabox->the_value('trailerembed'); ?>"/>
	</p>
		
	<?php $mb->the_field('abvaccessonly'); ?>
	<input type="checkbox" name="<?php $mb->the_name(); ?>" value="above"<?php $mb->the_checkbox_state('above'); ?>/> Only available to above average purchases?<br/>
	
	<?php global $wpalchemy_media_access; ?>
	
	<?php $mb->the_field('fullimage'); ?>
	    <?php $wpalchemy_media_access->setGroupName('nn4')->setInsertButtonLabel('Insert'); ?>
	
	    <p>
			<label>Full Embed Image</label>
	        <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
	        <?php echo $wpalchemy_media_access->getButton(); ?>
	    </p>
		
		<?php $mb->the_field('trailerimage'); ?>
	    <?php $wpalchemy_media_access->setGroupName('nn5')->setInsertButtonLabel('Insert'); ?>
	
	    <p>
			<label>Trailer Embed Image</label>
	        <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
	        <?php echo $wpalchemy_media_access->getButton(); ?>
	    </p>
		
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
		
		<label>Synopsis</label>
 
		<p>
			<textarea style="height:200px" type="text" name="<?php $metabox->the_name('synopsis'); ?>" value="<?php $metabox->the_value('synopsis'); ?>"> <?php $metabox->the_value('synopsis'); ?></textarea>
		</p>
		<label>Run-time (in Min.)</label>
 
		<p>
			<input type="text" name="<?php $metabox->the_name('runtime'); ?>" value="<?php $metabox->the_value('runtime'); ?>"/>
		</p>
		<label>Rating</label>
 
		<p>
			<input type="text" name="<?php $metabox->the_name('rating'); ?>" value="<?php $metabox->the_value('rating'); ?>"/>
		</p>
		<label>Genres</label>
 
		<p>
			<input type="text" name="<?php $metabox->the_name('genres'); ?>" value="<?php $metabox->the_value('genres'); ?>"/>
		</p>
		
		<?php $mb->the_field('filmmakerimg'); ?>
		    <?php $wpalchemy_media_access->setGroupName('filmmakerimg')->setInsertButtonLabel('Insert'); ?>
	
		    <p>
				<label>Filmmaker Image</label>
		        <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
		        <?php echo $wpalchemy_media_access->getButton(); ?>
		    </p>
			<label>Note From the Filmmaker</label>
 
			<p>
				<textarea style="height:200px" type="text" name="<?php $metabox->the_name('note'); ?>" value="<?php $metabox->the_value('note'); ?>"> <?php $metabox->the_value('note'); ?></textarea>
			</p>
		
			<label>Filmmaker Name</label>
 
			<p>
				<input type="text" name="<?php $metabox->the_name('filmmakername'); ?>" value="<?php $metabox->the_value('filmmakername'); ?>"/>
			</p>
		
			
			<label>Twitter</label>
 
			<p>
				<input type="text" name="<?php $metabox->the_name('filmmakertwit'); ?>" value="<?php $metabox->the_value('filmmakertwit'); ?>"/>
			</p>
			
			<label>Facebook</label>
 
			<p>
				<input type="text" name="<?php $metabox->the_name('filmmakerface'); ?>" value="<?php $metabox->the_value('filmmakerface'); ?>"/>
			</p>
			
		 	<label>The credits</label>
			<?php while($mb->have_fields_and_multi('credits')): ?>
		
			<?php $mb->the_group_open(); ?>
 
				<?php $mb->the_field('creditname'); ?>
				<label>Name</label>
				<p><input style="display:inline-block; width:500px" type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/></p>
 
				<?php $mb->the_field('creditjob'); ?>
				<label>Job</label>
				<p><input style="display:inline-block; width:500px" type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/></p>

			
						<a href="#" class="dodelete button">Remove</a>
 
			<?php $mb->the_group_close(); ?>
			<?php endwhile; ?>
 
			<p style="margin-bottom:15px; padding-top:5px;"><a href="#" class="docopy-credits button">One More!</a></p>
			<p></p>
			<input type="submit" class="button" name="save" value="Save`">
			<a style="" href="#" class="dodelete-credits button">Remove All</a>
	
			<script type="text/javascript">
			// <![CDATA[]
			jQuery(function($) {
				$("#wpa_loop-credits").sortable({
					change: function(){
				
						$('.soft-warning').show();
					}
		
				});
		
		
			});
			// ]]>
			</script>
			
			<label>Aspect Ratio</label><br/>
	
					<?php $mb->the_field('aspect'); ?>
					<select name="<?php $mb->the_name(); ?>">
		
						<option value="56.25%"<?php $mb->the_select_state('56.25%'); ?>>16:9</option>
						<option value="75%"<?php $mb->the_select_state('75%'); ?>>4:3</option>
						<option value="54.05%"<?php $mb->the_select_state('54.05%'); ?>>1.85:1</option>
						<option value="41.84%"<?php $mb->the_select_state('41.84%'); ?>>2.39:1</option>
						
						
						
					</select>
			
		
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