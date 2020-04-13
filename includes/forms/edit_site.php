<?php

function edit_site($data_id)
{
    global $wpdb;
    $query = 'SELECT * FROM ' . $wpdb->prefix . "eey_reporting_websites WHERE ID = $data_id";
    $results = $wpdb->get_results($query)[0];


?>
    <h1>Editing <?php echo $results->domain_name ?></h1>

    <form method="post" id="edit-site-form">
        <div style="display:none;">
            <label>Domain Name</label>
            <input type="text" name="domain_name" value=<?php echo $results->domain_name ?> />
        </div>


        <h3>Trello</h3>

        <label>Trello Board ID</label>
        <p>( Found on Show Menu -> More -> https://trello.com/b/[Trello Board ID] )</p>
        <input type="text" name="trello_board_id" value=<?php echo $results->trello_board_id ?> />

        <h3>Google Analytics</h3>

        <div> <label>Google Analytics View ID</label>
            <p>(ex: "196072291")</p>
            <input type="text" name="ga_view_id" value=<?php echo $results->ga_type ?> />
        </div>
        <button type="submit" name="edit_website">Update Website</button>
    </form>
<?php
}
function eey_reporting_update_website()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'eey_reporting_websites';

    $EEY_domain_name = $_POST['domain_name'];
    $EEY_trello_board_id = $_POST['trello_board_id'];
    $EEY_ga_view_id = $_POST['ga_view_id'];


    if (isset($_POST['edit_website'])) {

        $wpdb->update(
            $table_name,
            array(
                'domain_name' => $EEY_domain_name,
                'trello_board_id' => $EEY_trello_board_id,
                'ga_view_id' => $EEY_ga_view_id
            ),
            array('domain_name' => $EEY_domain_name),
            array(
                '%s',
                '%s',
                '%s'
            )
        );
    }
}
