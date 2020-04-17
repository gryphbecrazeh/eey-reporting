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
                <div class="button"> <a href="admin.php?page=eey_reporting_plugin&action=generate_csv&data_id=<?php echo $website->ID ?>">Generate CSV</a>
                </div>
                <div class="button"> <a href="admin.php?page=eey_reporting_plugin&action=edit_site&data_id=<?php echo $website->ID ?>">Edit Site</a>
                </div>
                <div class="button"> <a href="admin.php?page=eey_reporting_plugin&action=delete_site&data_id=<?php echo $website->ID ?>">Delete Site</a>
                </div>
                <!-- <div class="button"> <a href="admin.php?page=eey_reporting_plugin&action=generate_backlog&data_id=<?php echo $website->ID ?>">Generate Backlog</a>
                </div> -->
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
    case 'generate_backlog':
        include_once $plugin_url . '/includes/forms/generate_backlog.php';
        generate_backlog($params['data_id']);
        break;
    case 'generate_csv':
        include_once $plugin_url . '/includes/forms/generate_csv.php';
        eey_reporting_generate_csv_form($params['data_id']);
        break;
}
