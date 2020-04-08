<h1>East End Yovth Reporting Plugin</h1>
<?php
// Render out all websites here
global $wpdb;

// Render Out List of Websites
if (!isset($_GET['data_id'])) {
    $query = 'SELECT ID, domain_name FROM ' . $wpdb->prefix . 'eey_reporting_websites';
    $websites = $wpdb->get_results($query);

    foreach ($websites as $website) {

?>
        <div class="website-container">
            <div class="website-domain"><?php echo $website->domain_name; ?></div>
            <div class="actions-container">
                <!-- Replace these buttons with links to their respective form pages, where they will get the data based on the ID ex: <a href="__FILE__/includes/forms/edit_site.php?data_id=__DATA_ID__-->
                <!-- admin.php?data_id=__DATA_ID__ -->
                <!-- on admin.php if(isset($_POST['data_id'])) call generate_report.php function -->
                <div class="button"> <a href="admin.php?page=eey_reporting_plugin&action=generate_report&data_id=<?php echo $website->ID ?>">Generate Report</a>
                </div>
                <div class="button"> <a href="admin.php?page=eey_reporting_plugin&action=edit_site&data_id=<?php echo $website->ID ?>">Edit Site</a>
                </div>
                <div class="button"> <a href="admin.php?page=eey_reporting_plugin&action=delete_site&data_id=<?php echo $website->ID ?>">Delete Site</a>
                </div>
            </div>
        </div>

<?php
    }
    return 0;
}

$params = $_GET;
$plugin_url = ABSPATH . 'wp-content/plugins/eey-reporting';
switch ($params['action']) {
    case "generate_report":
        include_once $plugin_url . '/includes/forms/generate_report.php';
        generate_report($params['data_id']);
        break;
    case "edit_site":
        include_once $plugin_url . '/includes/forms/edit_site.php';
        edit_site($params['data_id']);
        break;
    case "delete_site":
        include_once $plugin_url . '/includes/forms/delete_site.php';
        confirm_delete_website($params['data_id']);
        break;
    case "update_settings":
        include_once $plugin_url . '/includes/templates/settings.php';
        eey_reporting_settings_page();
        break;
}
