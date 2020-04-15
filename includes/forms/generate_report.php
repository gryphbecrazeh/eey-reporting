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

    include_once $plugin_url . '/includes/forms/ga_inc/ga_report_class.php';
    ?>
    <form action="post"></form>
    
    
    <?php
    
    $trello = new TRELLO_API();
    $trello_report = $trello->getData($result->trello_board_id);
    // Serialize the received report
    $serialized_trello_report = serialize($trello_report);

    // $unserialized = unserialize($serialized_trello_report);

    // $trello->RenderResults($unserialized);

    die();

    $google = new GA_API();
    $google->report($result->ga_view_id);
}
