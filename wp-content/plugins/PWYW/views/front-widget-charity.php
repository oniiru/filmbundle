<div class='pwyw-charity' data-id='<?php echo $charity->id; ?>'>

    <div class='pwyw-clearfix'>
        <div class='embed'>
            <?php echo $charity->embed; ?>
        </div>

        <div class='right'>
			<h4>About <?php echo $charity->title; ?></h4>
            <?php echo $charity->description; ?>
            <a class='more' target="_blank" href='<?php echo $charity->url; ?>'>Website</a>
        </div>
    </div>

</div>
