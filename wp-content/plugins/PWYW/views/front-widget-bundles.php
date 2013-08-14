<div class='pwyw-bundle'>
    <div class='presentation'>
        <h2><?php echo $bundle->title; ?></h2>
        <p class='description'>
            <?php echo $bundle->description; ?>
        </p>
        <div class='pwyw-purchase'>
            <a id='pwyw-purchase-button' class='btn btn-large btn-success'>Purchase</a>
            <div class='pwyw-countdown'>
                <div class='remaining'>Time Remaining</div>
                <?php
                    $atts = array(
                        't'           => $bundle->end_time,
                        'days'        => 'd',
                        'hours'       => 'h',
                        'minutes'     => 'm',
                        'seconds'     => 's',
                        'omitweeks'   => 'true',
                        'style'       => 'pwyw',
                        'jsplacement' => 'inline'
                    );
                    echo tminuscountdown($atts);
                ?>
            </div>
        </div>

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

    <!-- Start: Details for the films -->
    <div class='pwyw-bundle-info'>
        <div class='pwyw-slider-wrap' data-container='.pwyw-films' data-single='.pwyw-film'>
            <div class='pwyw-previous'></div>
            <div class='pwyw-next'></div>

            <div class='pwyw-films pwyw-nav-header'>
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

        <div class='pwyw-dark-section'>
            <div class='pwyw-slider-wrap'>
                <div class='pwyw-films'>
                    <?php
                    foreach ($bundle->films as $film) {
                        $data = array(
                            'film' => $film,
                            'averagePrice' => $averagePrice
                        );
                        echo Pwyw_View::make('front-widget-film', $data);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- End: Details for the films -->

    <!-- Start: Details for the charities -->
    <div class='pwyw-charity-info'>
        <div class='pwyw-slider-wrap' data-container='.pwyw-charities' data-single='.pwyw-charity'>
            <div class='pwyw-previous'></div>
            <div class='pwyw-next'></div>

            <div class='pwyw-charities pwyw-nav-header'>
                <?php
                foreach ($bundle->charities as $charity) { ?>
                    <div class='pwyw-charity' data-id='<?php echo $charity->id; ?>'>
                        <h3><?php echo $charity->title; ?></h3>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class='pwyw-dark-section'>
            <div class='pwyw-slider-wrap'>
                <div class='pwyw-charities'>
                    <?php
                    foreach ($bundle->charities as $charity) {
                        $data = array('charity' => $charity);
                        echo Pwyw_View::make('front-widget-charity', $data);
                    }
                    ?>
                </div>

            </div>
        </div>
    </div>
    <!-- End: Details for the charities -->

    <div class='pwyw-bundle-footer pwyw-clearfix'>
        <div class='charities'>
            <?php
            // Build the row of charity logos
            foreach ($bundle->charities as $charity) {
                echo "<a class='pwyw-charity-show' data-id='{$charity->id}'>".
                     "<img src='{$charity->image}' alt='{$charity->title}' />".
                     "</a>";
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
