<?php





function generate_report($ID)
{
    global $wpdb;


    $query = 'SELECT * FROM ' . $wpdb->prefix . "eey_reporting_websites WHERE ID = '$ID'";
    $result = $wpdb->get_results($query)[0];
    $plugin_url = ABSPATH . 'wp-content/plugins/eey-reporting';
    include_once $plugin_url . '/includes/trello-api.php';
    $trello = new TRELLO_API();
    $trello->RenderResults($result->trello_board_id);
}