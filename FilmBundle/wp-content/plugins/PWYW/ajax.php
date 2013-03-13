<?php

require_once ('../../../wp-config.php');
if (is_plugin_active('PWYW/PWYW.php')) {
    if (check_ajax_referer('pwyw_ajax') ) {
        if (isset($_REQUEST['bid']) && (int)$_REQUEST['bid'] > 0) {
            require_once( ABSPATH . 'wp-content/plugins/PWYW/PWYW.php' );
            $pwyw = new pwyw();

            $pwyw_info = $pwyw->pwyw_get_bundle_info($bid);
            if (!empty($pwyw_info)) {
                echo json_encode($pwyw_info);
                exit;
            }
        }

        echo 'ERROR';
    }
}
?>
