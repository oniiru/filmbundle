<!-- Create a header in the default WordPress 'wrap' container -->
<div class="wrap">
    <div id="icon-options-general" class="icon32"></div>
    <h2>PWYW PubNub</h2>

    <?php if ($published) { ?>
    <div class="updated">
        <p>Published to the FilmBundle channel.</p>
    </div>
    <?php } ?>

    <form method='post' action=''>
        <h3>Publish</h3>
        <p>Manually publish the latest data to the PubNub channel. Useful for testing
        </p>
        <?php submit_button('Publish', 'primary'); ?>
    </form>
</div><!-- .wrap -->
