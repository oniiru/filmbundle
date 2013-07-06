<script type='text/javascript'>
    <?php
    // Hold an object with all films and information.
    echo "var pwyw_films = {$filmsJson};";
    ?>
</script>
<div class='pwyw-bundle'>
    <h2><?php echo $bundle->title; ?></h2>
    <p class="description">
        Here would a description be inserted if we had one in the database...
    </p>

    <div class="shelf">
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
                previous
            </div>
            <div class='pwyw-next'>
                next
            </div>
            <div class='pwyw-tabs'>
                <h3>film title</h3>
                <a class='tab'>overview</a>
                <a class='tab'>reviews</a>
                <a class='tab'>special features</a>
            </div>
        </div>

        <div class="pwyw-info-content">
            <div class="pwyw-info-content-container">
            Etiam tristique condimentum neque sed aliquet. Mauris nunc elit, tincidunt id molestie sed, sollicitudin eget nibh. Vivamus porta leo sit amet ullamcorper bibendum. Curabitur sed dignissim mauris. Donec in iaculis est, pharetra vestibulum sapien. Vestibulum vel purus velit. Integer purus ligula, aliquam eu risus ac, consectetur consequat neque. Morbi aliquam lectus laoreet aliquet ullamcorper. In viverra, est sed dictum condimentum, sapien mauris cursus turpis, et viverra nibh neque in lacus. Suspendisse nec ipsum aliquet, blandit lorem et, tincidunt tellus. Suspendisse sollicitudin nibh id risus auctor, nec feugiat est mattis. Fusce in interdum dui. Duis eget turpis porttitor, tincidunt arcu nec, bibendum nisl. Vestibulum sed lectus nisl.
            </div>
        </div>
    </div>
</div>
