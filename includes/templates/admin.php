<h1>East End Yovth Reporting Plugin</h1>
<?php
// Render out all websites here
global $wpdb;

$query = 'SELECT ID, domain_name FROM ' . $wpdb->prefix . 'eey_reporting_websites';

$websites = $wpdb->get_results($query);

foreach ($websites as $website) {
?>
    <div class="website-container">
        <div class="website-domain"><?php echo $website->domain_name; ?></div>
        <div class="actions-container">
            <button data_id="<?php echo $website->ID; ?>">Generate Report</button>
            <button data_id="<?php echo $website->ID; ?>">Edit</button>
            <button data_id="<?php echo $website->ID; ?>">Delete</button>
        </div>
    </div>
<?php
}

?>