<?php
// Select a date range to generate a backlog of data

function generate_backlog($data_id)
{
    global $wpdb;
    $query = 'SELECT * FROM ' . $wpdb->prefix . "eey_reporting_websites WHERE ID = $data_id";
    $results = $wpdb->get_results($query)[0];



?>
    <h1>Generating Backlog for <?php echo $results->domain_name ?></h1>

    <form method="post" id="add-site-form">
        <div style="display:none;">
            <label>Domain Name</label>
            <input type="text" name="domain_name" value=<?php echo $results->domain_name ?> />
        </div>

        <h3>Select Date Range</h3>

        <label>Start Date</label>
        <p>How far back do you want to go?</p>
        <input type="date" name="start_date" />

        <button type="submit" name="generate_backlog">Generate Backlog</button>
    </form>
<?php
}





function eey_reporting_generate_backlog()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'eey_reporting_data_logs';

    $EEY_domain_name = $_POST['domain_name'];
    $EEY_start_date = $_POST['start_date'];


    if (isset($_POST['generate_backlog'])) {

        include_once plugin_dir_path(__DIR__) . 'google-analytics.php';

        // Function to get all the dates in given range 
        function getDatesFromRange($start, $end, $format = 'Y-m-d')
        {

            // Declare an empty array 
            $array = array();

            // Variable that store the date interval 
            // of period 1 Month
            $interval = new DateInterval('P1M');

            $realEnd = new DateTime($end);
            $realEnd->add($interval);

            $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

            // Use loop to store date into array 
            foreach ($period as $date) {
                $array[] = $date->format($format);
            }

            // Return the array elements 
            return $array;
        }

        $EEY_end_date = current_time('Y-m-d');
        // Function call with passing the start date and end date 
        $dates = getDatesFromRange($EEY_start_date, $EEY_end_date);


        $query = 'SELECT * FROM ' . $wpdb->prefix . "eey_reporting_websites WHERE domain_name = '$EEY_domain_name'";
        $result = $wpdb->get_results($query)[0];

        print_r($result);

        die();

        // foreach ($dates as $date) {
        //     $report = new GA_API();
        //     $report->
        // }

        var_dump($Date);
        // var_dump($Date);

        die();
        // $wpdb->update(
        //     $table_name,
        //     array(
        //         'domain_name' => $EEY_domain_name,
        //         'trello_board_id' => $EEY_trello_board_id,
        //         'ga_view_id' => $EEY_ga_view_id
        //     ),
        //     array('domain_name' => $EEY_domain_name),
        //     array(
        //         '%s',
        //         '%s',
        //         '%s'
        //     )
        // );
    }
}
