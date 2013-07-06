<script type='text/javascript'>
    <?php
    // Hold an object with all films and information.
    echo "var pwyw_films = {$filmsJson};";
    ?>
</script>
<div class='pwyw-bundle'>
    <h2><?php echo $bundle->title; ?></h2>
    <p class='description'>
        Here would a description be inserted if we had one in the database...
    </p>

    <div class='shelf'>
        <?php
        // Build the row of movie covers that slide down information
        foreach ($bundle->films as $film) {
            // Place the ones below average here
            if ($film->rating === 'below') {
                echo "<a class='pwyw-bundle-show' data-id='{$film->id}'>".
                     "{$film->title}</a>";
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
                <a class='tab' data-tab='overview'>overview</a>
                <a class='tab' data-tab='reviews'>reviews</a>
                <a class='tab' data-tab='specialfeatures'>special features</a>
            </div>
        </div>

        <div class='pwyw-info-content'>
            <div class='pwyw-info-content-container'>
                <div class="pwyw-tab-overview">
                    overview
                </div>
                <div class="pwyw-tab-reviews">
                    reviews
                </div>
                <div class="pwyw-tab-specialfeatures">
                    special features
                </div>
            </div>
        </div>
    </div>
</div>
