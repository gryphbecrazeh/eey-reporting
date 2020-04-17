<?php

function eey_reporting_generate_csv_form($data_id)
{
    global $wpdb;
    $query = 'SELECT * FROM ' . $wpdb->prefix . "eey_reporting_websites WHERE ID = $data_id";
    $results = $wpdb->get_results($query)[0];


?>
    <h1>Generate a Trello CSV report</h1>

    <form method="post" id="generate-csv-form">
        <h3>Generating Report for <?php echo $results->domain_name ?></h3>
        <div style="display:none;">
            <label>Domain Name</label>
            <input type="text" name="domain_name" value=<?php echo $results->domain_name ?> />
        </div>
        <div style="display:none;">
            <label>Domain ID</label>
            <input type="text" name="data_id" value=<?php echo $data_id ?> />
        </div>
        <div>
            <label>Start Date</label>
            <input type="date" name='start'>
        </div>
        <div>
            <label>End Date</label>
            <input type="date" name='end'>
        </div>
        <button type="submit" name="generate_csv">Generate CSV</button>
    </form>

<?php


}

function eey_reporting_generate_csv()
{
    if (isset($_POST['generate_csv'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'eey_reporting_websites';
        $ID = $_POST['data_id'];
        $domain = $_POST['domain_name'];
        $date_start = $_POST['start'];
        $date_end = $_POST['end'];




        $query = "SELECT * FROM $table_name WHERE ID = '$ID'";
        $result = $wpdb->get_results($query)[0];

        $plugin_url = ABSPATH . 'wp-content/plugins/eey-reporting';

        include_once $plugin_url . '/includes/trello-api.php';

        $trello = new TRELLO_API();
        $trello_report = $trello->getData($result->trello_board_id);

        $trello->generateCSV($trello_report, $result->domain_name, array('start' => $date_start, 'end' => $date_end));
        die();

    }

}

