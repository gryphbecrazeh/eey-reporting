<?php





function generate_report($ID)
{
    global $wpdb;


    $query = 'SELECT * FROM ' . $wpdb->prefix . "eey_reporting_websites WHERE ID = '$ID'";
    $result = $wpdb->get_results($query)[0];

    echo $result->domain_name;

    $plugin_url = ABSPATH . 'wp-content/plugins/eey-reporting';
    include_once $plugin_url . '/includes/trello-api.php';
    include_once $plugin_url . '/includes/google-analytics.php';
    $trello = new TRELLO_API();
    $trello->RenderResults($result->trello_board_id);
    $google = new GA_API();
    $google->report($result->ga_view_id);
}
