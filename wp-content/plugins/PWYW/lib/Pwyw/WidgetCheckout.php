<?php
/**
 * Adds widget.
 */
class Pwyw_WidgetCheckout extends WP_Widget
{

    /**
     * Register widget with WordPress.
     */
    public function __construct()
    {
        parent::__construct(
            'pwyw_checkout',
            'PWYW Checkout',
            array('description' => 'Displays the checkout options for PWYW bundles.')
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
        $pwyw = Pwyw::getInstance();
        $pwyw_data = $pwyw->pwyw_get_bundle_info();
        $payment = $pwyw_data['payment_info'];

        // Prepare data
        $totalSales = isset($payment->total_sales) ?
                      $payment->total_sales : '0';
        $averagePrice = isset($payment->avg_price) ? 
                        number_format($payment->avg_price, 2) : '0.00';
        $totalPayments = isset($payment->total_payments) ?
                         number_format($payment->total_payments, 2) : '0.00';

        $data = array(
            'bundle'        => $pwyw_data,
            'totalSales'    => $totalSales,
            'averagePrice'  => '$'.$averagePrice,
            'totalPayments' => '$'.$totalPayments
        );

        echo $before_widget;
        echo Pwyw_View::make('front-widget-checkout', $data);
        echo $after_widget;
    }
}
