<div class='pwyw-bundle'>
    <div class='presentation'>
        <h2><?php echo $bundle->title; ?></h2>
        <p class='description'>
            <?php echo $bundle->description; ?>
        </p>

        <div class='shelf'>
            <?php
            // Build the row of movie covers that slide down information
            foreach ($bundle->films as $film) {
                // Place the ones below average here
                if ($film->rating === 'below') {
                    echo "<a class='pwyw-bundle-show' data-id='{$film->id}'>".
                         "<img src='{$film->image}' alt='{$film->title}' />".
                         "</a>";
                }
            }
            ?>
        </div>
    </div>

    
    <div class='pwyw-bundle-info'>
        <div class='pwyw-films-wrap'>
            <div class='pwyw-previous'>
                <a>previous</a>
            </div>
            <div class='pwyw-next'>
                <a>next</a>
            </div>

            <div class='pwyw-films pwyw-film-header'>
                <?php
                foreach ($bundle->films as $film) { ?>
                    <div class='pwyw-film' data-id='<?php echo $film->id; ?>'>
                        <h3><?php echo $film->title; ?></h3>
                        <div class='pwyw-tabs'>
                            <a class='tab selected' data-tab='overview'>Overview</a>
                            <a class='tab' data-tab='reviews'>Reviews</a>
                            <a class='tab' data-tab='specialfeatures'>Special Features</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class='pwyw-film-section'>
            <div class='pwyw-films-wrap'>
                <div class='pwyw-films'>
                    <?php
                    foreach ($bundle->films as $film) {
                        $data = array('film' => $film);
                        echo Pwyw_View::make('front-widget-film', $data);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>


    <div class='pwyw-bundle-footer pwyw-clearfix'>
        <div class='charities'>
            <?php
            // Build the row of charity logos
            foreach ($bundle->charities as $charity) {
                echo "<img src='{$charity->image}' alt='{$charity->title}' />";
            }
            ?>
        </div>
        <div class='films'>
        <?php
            // Build the row of above average films
            foreach ($bundle->films as $film) {
                // Place the ones below average here
                if ($film->rating === 'above') {
                    echo "<a class='pwyw-bundle-show' data-id='{$film->id}'>".
                         "<img src='{$film->image}' alt='{$film->title}' />".
                         "</a>";
                }
            }
            ?>
        </div>
    </div>
</div>
