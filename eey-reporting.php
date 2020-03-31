<?php
defined('ABSPATH') or die('Inaccessible');
/**
 * Plugin Name: East End Yovth Reporting
 * Plugin URI: http://www.cordine.site/
 * Description: A custom plugin built by Christopher Cordine
 * Version: 0.0.1
 * Author: Christopher Cordine
 * Author URI: http://www.cordine.site/
 */

global $wpdb;

// PLUGIN VERSION
defined('EEY_REPORTING_VERSION') or define('EEY_REPORTING_VERSION', '0.0.1');
// PLUGIN ADMIN SLUG
defined('EEY_REPORTING_SLUG') or define('EEY_REPORTING_SLUG', 'eey');
// PLUGIN'S TEXT DOMAIN
defined('EEY_REPORTING_TD') or define('EEY_REPORTING_TD', 'eey');
// PLUGIN IMAGE DIRECTORY
defined('EEY_REPORTING_IMG_DIR') or define('EEY_REPORTING_IMG_DIR', plugin_dir_url(__FILE__) . 'images');
// PLUGIN DIRECTORY URL
defined('EEY_REPORTING_URL') or define('EEY_REPORTING_URL', plugin_dir_url(__FILE__));
// PLUGIN JS DIRECTORY
defined('EEY_REPORTING_JS_DIR') or define('EEY_REPORTING_JS_DIR', plugin_dir_url(__FILE__) . 'js');
// PLUGIN CSS DIRECTORY
defined('EEY_REPORTING_CSS_DIR') or define('EEY_REPORTING_CSS_DIR', plugin_dir_url(__FILE__) . 'css');

if (!class_exists('EEY_REPORTING_Class')) {
    class EEY_REPORTING_Class
    {
        function __construct()
        {
            // Add Item(s) to menu bar
            add_action('admin_bar_menu', array($this, 'eey_reporting_add_toolbar_items'), 100);
            // Include scripts necessary to run, Register front end assets
            add_action('wp_enqueue_scripts', array($this, 'eey_reporting_include_scripts'));
            // Include AJAX actions
            add_action('wp_ajax_eey_pagespeed_report', array($this, 'eey_reporting_page_speed'));
            add_action('wp_ajax_nopriv_eey_pagespeed_report', array($this, 'eey_reporting_page_speed'));
            // Include pagespeed data SHORTCODE
            add_shortcode('eey_pagespeed', array($this, 'eey_reporting_page_speed_2'));
        }

        function eey_reporting_page_speed()
        {
            $base_url = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=";
            $target = "https://eastendyovth.com";
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $base_url . $target
            ]);

            $res = curl_exec($curl);

            $decodedRes = json_decode($res);
            $lighthouse_result = $decodedRes->lighthouseResult;
            $audits = get_object_vars($lighthouse_result->audits);
            // Cycle through each element and output the title and value
            foreach ($audits as $index => $value) {
            ?>
                <div>
                    <?php echo $value->title ?> : <?php echo $value->displayValue ?>
                </div>

            <?php
            }
            curl_close($curl);

            /*

            $google_uri_base = 'https://www.googleapis.com/webmasters/v3';
            $client_id = '258642766560-uv0tvs227beilrtceaco1tk7nth1p3p5.apps.googleusercontent.com';
            $client_secret = 'MffmMp-bzR44_a_-a5-4d4nQ';
            $api_key = "AIzaSyBhmbm2PC7uSvS2W1bfQ-xTNptpGOIQBjQ";
            $url = 'http://www.fallonfiberglass.com/';
            $url = preg_replace("/:/", "%3A", $url);
            $url = preg_replace("/\//", "%2F", $url);

            // Initialize cURL
            $curl = curl_init();

            // curl -H 'Content-Type: application/json' --data '{url: "http://fallonfiberglass.com"}' 'https://searchconsole.googleapis.com/v1/urlTestingTools/mobileFriendlyTest:run?key=AIzaSyBhmbm2PC7uSvS2W1bfQ-xTNptpGOIQBjQ'

            $headers = [
                "Authorization: Bearer $client_id",
                'Accept: application/json',
                'Content-Type: application/json'
            ];

            // Set Options
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_URL => "$google_uri_base/sites/query?key=$api_key",
                CURLOPT_USERAGENT => 'Codular Sample cURL Request'
            ]);

            $res = curl_exec($curl);
            // echo $res;

            curl_close($curl);
*/
        }

        function eey_reporting_page_speed_2()
        {
            ?>
            <div>
                <button class="pagespeed" onclick="">Click me to get your pagespeed insights</button>
                <div class="results"></div>
            </div>

<?php
        }
        function register_frontend_assets()
        {
            $frontend_js_obj = array(

                'default_error_message' => __('This field is required', EEY_REPORTING_TD),

                'ajax_url' => admin_url('admin-ajax.php'),

                'ajax_nonce' => wp_create_nonce('frontend-ajax-nonce'),

                'preview_img' => EEY_REPORTING_IMG_DIR . '/no-preview.png'

            );

            wp_localize_script('frontend.js', 'frontend_js_obj', $frontend_js_obj);
        }
        function eey_reporting_include_scripts()
        {
            // wp_register_style('eey_reporting_style.css', plugins_url('/css/eey_reporting_style.css', __FILE__));
            // wp_enqueue_style('eey_reporting_style.css');
            wp_enqueue_script('frontend.js', plugins_url('/js/frontend.js', __FILE__));
            EEY_REPORTING_Class::register_frontend_assets();
        }

        function eey_reporting_add_toolbar_items($admin_bar)
        {
            $admin_bar->add_menu(array(
                'id' => 'eey-adminbar',
                'title' => 'Reporting',
                'meta' => array(
                    'title' => __('EEY Custom Plugin'),
                ),
            ));
        }

        // from analytics

        // get

        // aquisition

        // and 

        // audience

    }
    $eey_reporting_obj = new EEY_REPORTING_Class();
}
