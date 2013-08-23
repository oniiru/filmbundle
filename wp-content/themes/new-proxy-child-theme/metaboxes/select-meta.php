<div class="my_meta_control">
 

	<label>Post Type</label><br/>
	
	<?php $mb->the_field('type'); ?>
	<select name="<?php $mb->the_name(); ?>">
		<option value="Post"<?php $mb->the_select_state('Post'); ?>>Post</option>
		<option value="tv"<?php $mb->the_select_state('tv'); ?>>tv</option>
	</select>
	<br>
		<?php $mb->the_field('youtube'); ?>
		<input type="text" placeholder="Embed" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>


</div>