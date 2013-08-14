<?php
/**
 * Adds widget.
 */
class Pwyw_WidgetBundles extends WP_Widget
{

    /**
     * Register widget with WordPress.
     */
    public function __construct()
    {
        parent::__construct(
            'pwyw_bundles',
            'PWYW Bundles',
            array('description' => 'Presents film from PWYW bundles.')
        );

        add_action('wp_head', array(&$this, 'head'));
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
        // Bundle Film Data
        $bundles = Pwyw_Bundles::getInstance();
        $bundle = $bundles->getActiveBundle();

        // Bundle Payment Data
        $pwyw = Pwyw::getInstance();
        $pwywData = $pwyw->pwyw_get_bundle_info();
        $payment = $pwywData['payment_info'];
        $averagePrice = isset($payment->avg_price) ? 
                        number_format($payment->avg_price, 2) : '0.00';

        $data = array(
            'bundle' => $bundle,
            'averagePrice' => '$'.$averagePrice,
            'assetsUrl' => plugins_url('/assets/', Pwyw::FILE),
        );

        echo $before_widget;
        echo Pwyw_View::make('front-widget-bundles', $data);
        echo $after_widget;
    }

    // -------------------------------------------------------------------------
    // Additional Methods
    // -------------------------------------------------------------------------

    public function head()
    {
        $bundles = Pwyw_Bundles::getInstance();
        $bundle = $bundles->getActiveBundle();

        echo "
        <style type='text/css'>
            .pwyw-bundle .presentation {
                background: url('{$bundle->bg_image}') no-repeat center center fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }
        </style>
        ";
    }


}
