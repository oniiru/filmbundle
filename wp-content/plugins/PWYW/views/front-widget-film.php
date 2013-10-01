<div class='pwyw-film' data-id='<?php echo $film->id; ?>'>

    <!-- OVERVIEW -->
    <div class='pwyw-tab-overview'>
        <?php if ($film->rating === 'above') { ?>
			<div class="centerthis">
        <div style ="margin:10px" class='pwyw-beat-average'>
            Beat the current average of 
            <span class='pwyw-average-amount'><?php echo $averagePrice; ?></span>
            to get this amazing film with your purchase!
        </div>
	</div>
        <?php } ?>
        <div class='pwyw-clearfix'>
            <div class='embed'>
                <?php echo $film->embed; ?>
            </div>

            <div class='right'>
                <div class='logline'><?php echo $film->logline; ?></div>
                <hr/>
				<div class="bottomfilmdeets">
					<p style="font-family:'museo300', sans-serif">Genre(s): <span class='genre'><?php echo $film->genre; ?></span> 
                | Runtime: <span class='runtime'><?php echo $film->runtime; ?></span></p>
            <p>    Director: <span class='director'><?php echo $film->director; ?></span></p>
           <p style="font-family:'museo300', sans-serif">     Writer(s): <span class='writers'><?php echo $film->writers; ?></span></p>
             <p>   Stars: <span class='stars'><?php echo $film->stars; ?></span></p>
            <p>    <a href='<?php echo $film->website; ?>' target="_blank" class='website'>Website</a></p>
			</div>
            </div>
        </div>

        <div style="background-image:url('<?php echo $film->filmmaker_image; ?>');" class='pwyw-note filmmaker pwyw-clearfix'>
            <span>A note from the filmmaker</span>
            <p class='filmmaker_note'><?php echo $film->filmmaker_note; ?></p>
            <p class='filmmaker_name'>- <?php echo $film->filmmaker_name; ?></p>
        </div>

        <div style="background-image:url('<?php echo $film->curator_image; ?>');" class='pwyw-note curator pwyw-clearfix'>
            <span>A note from the curator</span>
            <p class='curator_note'><?php echo $film->curator_note; ?></p>
            <p class='curator_name'>- <?php echo $film->curator_name; ?></p>
        </div>
    </div>

    <!-- REVIEWS -->
    <div class='pwyw-tab-reviews'>
        <?php
        $ctr = 0;
        foreach ($film->reviews as $review) { ?>

            <div class='pwyw-review'>
                <div class='review'>
                    <?php echo $review->review; ?>
                    <a target="_blank"href='<?php echo $review->link; ?>'>Read the full review...</a>
					<div class="triangle"></div>
                </div>

                <div class='pwyw-review-author pwyw-clearfix'>
                    <img src='<?php echo $review->image; ?>' />
                    <div class='pwyw-review-author-info'>
                        <div class='author'><?php echo $review->author; ?></div>
                        <div class='publication'><?php echo $review->publication; ?></div>
                    </div>
                </div>	
            </div>
        <?php
            $ctr++;
           
        }
        ?>
    </div>

    <!-- SPECIAL FEATURES -->
    <div class='pwyw-tab-specialfeatures'>
        <div class='pwyw-beat-average'>
            Pay more than then the current average of
            <span class='pwyw-average-amount'><?php echo $averagePrice; ?></span>
            to get these great special features too!
        </div>
        <?php
        foreach ($film->features as $feature) { ?>
            <div class='pwyw-special-feature'>
                <div style="background-image:url('<?php echo $feature->image; ?>')" class='special-feature pwyw-clearfix'>
                    <div class='title'><?php echo $feature->title; ?></div>
                    <div class='subtitle'><?php echo $feature->subtitle; ?></div>
                    <div class='runtime'>Runtime: <?php echo $feature->runtime; ?></div>
                </div>
            </div>
        <?php
            $ctr++;
            if ($ctr % 2 == 0) {
                echo '<div class="pwyw-clearfix"></div>';
            }
        }
        ?>
    </div>

</div>
