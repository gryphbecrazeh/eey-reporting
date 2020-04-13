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

// Includes
include_once __DIR__ . '/includes/options.php';
#require_once 'includes/google-analytics.php';
#require_once 'includes/trello-api.php';


if (!class_exists('EEY_REPORTING_Class')) {
    class EEY_REPORTING_Class
    {
        public $plugin;

        function __construct()
        {
            // Define the plugin base
            $this->plugin = plugin_basename(__FILE__);
            $options = new EEY_REPORTING_SETTINGS_Class($this->plugin);
            $options->register();

            // Add Item(s) to menu bar
            add_action('admin_bar_menu', array($this, 'eey_reporting_add_toolbar_items'), 100);

            // Include scripts necessary to run, Register front end assets
            add_action('wp_enqueue_scripts', array($this, 'eey_reporting_include_scripts'));

            // Include AJAX actions
            add_action('wp_ajax_eey_pagespeed_report', array($this, 'eey_reporting_page_speed'));
            add_action('wp_ajax_nopriv_eey_pagespeed_report', array($this, 'eey_reporting_page_speed'));

            // Include pagespeed data SHORTCODE
            add_shortcode('eey_pagespeed', array($this, 'eey_reporting_page_speed_2'));

            // Activation Scripts

            // Add Tables to Database
            register_activation_hook(__FILE__, array($this, 'create_plugin_databases_table'));
        }

        // Setup database
        public function create_plugin_databases_table()
        {
            global $wpdb;
            // Websites Table
            $table_name = $wpdb->prefix . 'eey_reporting_websites';
            // Define tables and fields
            $eey_reporting_query = "CREATE TABLE $table_name(
                    id int(10) NOT NULL AUTO_INCREMENT,
                    domain_name varchar (100) DEFAULT '',
                    trello_board_id varchar (100) DEFAULT '',
                    ga_view_id varchar (100) DEFAULT '',
                    PRIMARY KEY (id)
                )";

            require_once(ABSPATH . "wp-admin/includes/upgrade.php");
            // Add Table
            dbDelta($eey_reporting_query);

            // Settings Table
            $table_name = $wpdb->prefix . 'eey_reporting_settings';
            // Define tables and fields
            $eey_reporting_query = "CREATE TABLE $table_name(
                    id int(10) NOT NULL AUTO_INCREMENT,
                    trello_api_key varchar (500) DEFAULT '',
                    trello_default_token varchar (500) DEFAULT '',
                    trello_oauth_secret varchar (500) DEFAULT '',
                    ga_type varchar (500) DEFAULT '',
                    ga_project_id varchar (500) DEFAULT '',
                    ga_private_key_id varchar (500) DEFAULT '',
                    ga_private_key varchar (5000) DEFAULT '',
                    ga_client_email varchar (500) DEFAULT '',
                    ga_client_id varchar (500) DEFAULT '',
                    ga_auth_uri varchar (500) DEFAULT '',
                    ga_token_uri varchar (500) DEFAULT '',
                    ga_auth_provider_x509_cert_url varchar (500) DEFAULT '',
                    ga_client_x509_cert_url varchar (500) DEFAULT '',
                    PRIMARY KEY (id)
                )";

            require_once(ABSPATH . "wp-admin/includes/upgrade.php");
            // Add Table
            dbDelta($eey_reporting_query);



            // Logs Table
            $table_name = $wpdb->prefix . 'eey_reporting_data_logs';
            // Define tables and fields
            $eey_reporting_query = "CREATE TABLE $table_name(
                    id int(10) NOT NULL AUTO_INCREMENT,
                    domain_name varchar (100) DEFAULT '',
                    trello_report_values MEDIUMTEXT DEFAULT '',
                    google_analytics_values MEDIUMTEXT DEFAULT '',
                    report_date DATE,
                    PRIMARY KEY (id)
                )";

            require_once(ABSPATH . "wp-admin/includes/upgrade.php");
            // Add Table
            dbDelta($eey_reporting_query);
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
