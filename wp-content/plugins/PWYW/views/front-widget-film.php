<div class='pwyw-film' data-id='<?php echo $film->id; ?>'>

    <!-- OVERVIEW -->
    <div class='pwyw-tab-overview'>
        <div class='pwyw-clearfix'>
            <div class='embed'>
                <?php echo $film->embed; ?>
            </div>

            <div class='right'>
                <div class='logline'><?php echo $film->logline; ?></div>
                <br/>
                Genre(s): <span class='genre'><?php echo $film->genre; ?></span> 
                | Runtime: <span class='runtime'><?php echo $film->runtime; ?></span>
                <hr/>
                Director: <span class='director'><?php echo $film->director; ?></span><br/>
                Writer(s): <span class='writers'><?php echo $film->writers; ?></span><br/>
                Stars: <span class='stars'><?php echo $film->stars; ?></span><br/>
                <a href='<?php echo $film->website; ?>' class='website'>Website</a>
            </div>
        </div>

        <div class='pwyw-note filmmaker pwyw-clearfix'>
            <img src='<?php echo $film->filmmaker_image; ?>' />
            <span>A note from the filmmaker</span>
            <p class='filmmaker_note'><?php echo $film->filmmaker_note; ?></p>
            <p class='filmmaker_name'><?php echo $film->filmmaker_name; ?></p>
        </div>

        <div class='pwyw-note curator pwyw-clearfix'>
            <img src='<?php echo $film->curator_image; ?>' />
            <span>A note from the curator</span>
            <p class='curator_note'><?php echo $film->curator_note; ?></p>
            <p class='curator_name'><?php echo $film->curator_name; ?></p>
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
                    <a href='<?php echo $review->link; ?>'>Read the full review</a>
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
            if ($ctr % 2 == 0) {
                echo '<div class="pwyw-clearfix"></div>';
            }
        }
        ?>

    </div>


    <!-- SPECIAL FEATURES -->
    <div class='pwyw-tab-specialfeatures'>
        <?php
        foreach ($film->features as $feature) { ?>
            <div class='pwyw-special-feature'>
                <img src='<?php echo $feature->image; ?>' />
                <div class='title'><?php echo $feature->title; ?></div>
                <div class='subtitle'><?php echo $feature->subtitle; ?></div>
            </div>
        <?php } ?>
    </div>

</div>
