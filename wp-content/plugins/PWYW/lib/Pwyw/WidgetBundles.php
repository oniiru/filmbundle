<?php
/**
 * Adds widget.
 */
class Pwyw_WidgetBundles extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'pwyw_bundles',
            'PWYW Bundles',
            array('description' => 'Presents film from PWYW bundles.')
        );
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance)
    {
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        return $instance;
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {
        $bundles = Pwyw_Bundles::getInstance();
        $bundle = $bundles->getActiveBundle();

        // below average films (For shelf display)
        $belowFilms = array();
        foreach ($bundle->films as $film) {
            if ($film->rating === 'below') {
                array_push($belowFilms, $film);
            }
        }

        $data = array(
            'bundle' => $bundle,
            'filmsJson' => json_encode($belowFilms)
        );

        echo $before_widget;
        echo Pwyw_View::make('front-widget-bundles', $data);
        echo $after_widget;
    }
}
