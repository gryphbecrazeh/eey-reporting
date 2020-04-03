<?php

function confirm_delete_website($data_id)
{
    global $wpdb;

    $query = 'SELECT domain_name FROM ' . $wpdb->prefix . "eey_reporting_websites WHERE ID = $data_id";

    $results = $wpdb->get_results($query)[0];
?>
    <h2>Are you SURE you would like to <span style="color:red">DELETE</span> <?php echo $results->domain_name ?>?</h2>
    <form method="post">
        <label>Please type in <?php echo $results->domain_name ?> to proceed with <span style="color:red">DELETEING</span> <?php echo $results->domain_name ?></label>
        <input type="text" placeholder="<?php echo $results->domain_name ?>" name="confirm_deletion" />
        <input type="text" name="domain_name" value="<?php echo $results->domain_name ?>" style="display:none;">
        <button type="submit" name="delete_website">Delete Website</button>
    </form>
<?php
}

function eey_reporting_delete_website()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'eey_reporting_websites';

    $EEY_domain_name = $_POST['domain_name'];
    $EEY_confirm_deletion = $_POST['confirm_deletion'];
    if (isset($_POST['delete_website'])) {
        if ($EEY_domain_name == $EEY_confirm_deletion) {

            $wpdb->delete(
                $table_name,
                array(
                    'domain_name' => $EEY_domain_name,
                ),
                array(
                    '%s',
                )
            );
        }
    }
}
