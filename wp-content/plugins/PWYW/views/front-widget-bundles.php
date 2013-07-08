<script type='text/javascript'>
    <?php
    // Hold an object with all films and information.
    echo "var pwyw_films = {$filmsJson};";
    ?>
</script>
<div class='pwyw-bundle'>
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
    
    <div class='pwyw-bundle-info'>
        <div class='pwyw-info-header pwyw-clearfix'>
            <div class='pwyw-previous'>
                <a>previous</a>
            </div>
            <div class='pwyw-next'>
                <a>next</a>
            </div>
            <div class='pwyw-tabs'>
                <h3>film title</h3>
                <a class='tab' data-tab='overview'>Overview</a>
                <a class='tab' data-tab='reviews'>Reviews</a>
                <a class='tab' data-tab='specialfeatures'>Special Features</a>
            </div>
        </div>

        <div class='pwyw-info-content'>
            <div class='pwyw-info-content-container'>
                <div class="pwyw-tab-overview">
                    <?php echo Pwyw_View::make('front-bundles-overview'); ?>
                </div>
                <div class="pwyw-tab-reviews"></div>
                <div class="pwyw-tab-specialfeatures"></div>
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
                    echo "<img src='{$film->image}' alt='{$film->title}' />";
                }
            }
            ?>
        </div>
    </div>
</div>
