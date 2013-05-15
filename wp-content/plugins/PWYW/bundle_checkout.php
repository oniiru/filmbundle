<?php



require_once ('../../../wp-config.php');

if (is_plugin_active('PWYW/PWYW.php')) {
 //   if (check_ajax_referer('pwyw_bundle_checkout') ) {

        if ($_REQUEST['action'] == 'checkout' && (int) $_REQUEST['bid'] > 0) {
       
            $_SESSION['pwyw_user_alias'] = null;
            $_SESSION['is_twitter_alias'] = null;

            if(!empty($_REQUEST['alias'])&&strlen($_REQUEST['alias'])<200){
                $_SESSION['is_twitter_alias'] = (int)$_REQUEST['is_twitter'];
                $_SESSION['pwyw_user_alias'] = strip_tags(trim($_REQUEST['alias']));
            }

            $_SESSION['pwyw_bundle']  = '';
            $_SESSION['pwyw_bundle'][(int)$_REQUEST['bid']]['categories'] = $_REQUEST['categories'];
            $_SESSION['pwyw_bundle'][(int)$_REQUEST['bid']]['user'] = get_current_user_id();
            
            $_SESSION['pwyw_bundle_price'] = (float) $_REQUEST['c_price'];
            $avg_scheme = get_bundle_levels_scheme((int) $_REQUEST['bid']);
            if ($avg_scheme) {
                $avg_price = get_average_price((int) $_REQUEST['bid']);
                $mid = 2;

                if (!empty($avg_price)) {
                    if ($avg_price >= (float) $_REQUEST['c_price']) {
                        $mid = $avg_scheme->belowaverage;
                    } else {
                        $mid = $avg_scheme->aboveaverage;
                    }
                    $_SESSION['pwyw_bundle'][(int)$_REQUEST['bid']]['avg_price'] = $avg_price;
                    $_SESSION['pwyw_bundle'][(int)$_REQUEST['bid']]['bundle_level'] = $mid;
                    $url = get_site_url().'/membership-account/membership-checkout/?level='.$mid;
                    header("Location:".$url);
                    exit();
                }
            }
    //    }
    }

    $_SESSION['pwyw_bundle_price'] = 0;
    die;
}

function get_average_price($bid) {
    global $wpdb;
    $customer_payment = $wpdb->prefix . "pwyw_payment_info";
    $bundles = $wpdb->prefix . "pwyw_bundles";

    $result = $wpdb->get_results(
            $wpdb->prepare(
                    "SELECT AVG(`sum`) as average_price FROM  {$customer_payment} WHERE `bundle` = %d GROUP BY `bundle` ", $bid
            )
    );

    $avg_price = number_format($result[0]->average_price, 2);

//    if ((float)$avg_price<=0) {
//        $result = $wpdb->get_results(
//                $wpdb->prepare(
//                        "SELECT suggested_val_2 as default_price FROM  {$bundles} WHERE `id` = %d", $bid
//                )
//        );
//        $avg_price = number_format($result[0]->default_price, 2);
//    }

    return $avg_price;
}

function get_bundle_levels_scheme($bid) {
    global $wpdb;
    $bundles = $wpdb->prefix . "pwyw_bundles";
    $result = $wpdb->get_results(
            $wpdb->prepare(
                    "SELECT `belowaverage`,`aboveaverage` FROM  {$bundles} WHERE `id` = %d", $bid
            )
    );

    return $result[0];
}