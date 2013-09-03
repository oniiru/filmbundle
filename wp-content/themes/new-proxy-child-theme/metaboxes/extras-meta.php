<?php global $wpalchemy_media_access; ?>

<div class="my_meta_control">
	
	<p class="soft-warning" style="display:none;color:red">Remember to click save to save your new sort order! </p>
		
 	<label>Special Features</label>
	<?php while($mb->have_fields_and_multi('extra-feature')): ?>
		
	<?php $mb->the_group_open(); ?>
 
		<?php $mb->the_field('extra_embed'); ?>
		<label>Embed Code</label>
		<p><input style="display:inline-block; width:500px" type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/></p>
 
		<?php $mb->the_field('extra_title'); ?>
		<label>Title</label>
		<p><input style="display:inline-block; width:500px" type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/></p>

		<?php $mb->the_field('run_time'); ?>
		<label>Run Time</label>
		<p><input style="display:inline-block; width:500px" type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/></p>
		
			<?php $mb->the_field('backgroundimage'); ?>
			    <?php $wpalchemy_media_access->setGroupName('img-n'. $mb->get_the_index())->setInsertButtonLabel('Insert'); ?>
	
			    <p>
					<label>Background Image</label>
			        <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
			        <?php echo $wpalchemy_media_access->getButton(); ?>
			    </p>
				<a href="#" class="dodelete button">Remove</a>
 
	<?php $mb->the_group_close(); ?>
	<?php endwhile; ?>
 
	<p style="margin-bottom:15px; padding-top:5px;"><a href="#" class="docopy-extra-feature button">One More!</a></p>
	<p></p>
	<input type="submit" class="button" name="save" value="Save`">
	<a style="" href="#" class="dodelete-extra-feature button">Remove All</a>
		
	
	
	<script type="text/javascript">
	// <![CDATA[]
	jQuery(function($) {
		$("#wpa_loop-extra-feature").sortable({
			change: function(){
				
				$('.soft-warning').show();
			}
		
		});
		
		
	});
	// ]]>
	</script>
	
	
</div>
