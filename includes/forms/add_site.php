<?php

function eey_reporting_add_website()
{


?>
    <h1>Add a Website</h1>

    <form method="post" id="add-site-form">
        <div>
            <label>Domain Name</label>
            <input type="text" name="domain_name" />
        </div>


        <h3>Trello</h3>

        <label>Trello Board ID</label>
        <p>( Found on Show Menu -> More -> https://trello.com/b/[Trello Board ID] )</p>
        <input type="text" name="trello_board_id" />
<!-- 
        <h3>Google Analytics</h3>

        <div> <label>Google Analytics View ID</label>
            <p>(ex: "196072291")</p>
            <input type="text" name="ga_view_id" />
        </div> -->
        <button type="submit" name="add_website">Add Website</button>
    </form>

<?php


}
function eey_reporting_insert_website()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'eey_reporting_websites';

    $EEY_domain_name = $_POST['domain_name'];
    $EEY_trello_board_id = $_POST['trello_board_id'];
    $EEY_ga_view_id = $_POST['ga_view_id'];

    if (isset($_POST['add_website'])) {

        $wpdb->insert(
            $table_name,
            array(
                'domain_name' => $EEY_domain_name,
                'trello_board_id' => $EEY_trello_board_id,
                'ga_view_id' => $EEY_ga_view_id,
            ),
            array(
                '%s',
                '%s',
                '%s'
            )
        );
    }
}
