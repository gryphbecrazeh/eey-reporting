<?php
// Settings

class EEY_REPORTING_SETTINGS_Class
{
    public $plugin;

    function __construct($base_name)
    {
        $this->plugin = $base_name;
    }

    function register()
    {
        add_action('admin_menu', array($this, 'eey_reporting_add_admin_pages'));

        add_filter("plugin_action_links_$this->plugin", array($this, 'dashboard_link'));
    }

    public function eey_reporting_add_admin_pages()
    {
        // Include Actions
        include_once __DIR__ . '/forms/add_site.php';
        include_once __DIR__ . '/forms/edit_site.php';
        include_once __DIR__ . '/forms/delete_site.php';

        add_menu_page('EEY Reporting', 'EEY Reporting', 'manage_options', 'eey_reporting_plugin', array($this, 'admin_index'), '
            dashicons-format-aside', 110);
        add_submenu_page('eey_reporting_plugin', 'Add Website', 'Add Website', 'manage_options', 'add_website', 'eey_reporting_add_website');

        // CRUD Actions
        eey_reporting_insert_website();
        eey_reporting_update_website();
        eey_reporting_delete_website();
    }

    public function dashboard_link($links)
    {
        $settings_link = '<a href="admin.php?page=eey_reporting_plugin">Dashboard</a>';

        array_push($links, $settings_link);

        return $links;
    }

    public function admin_index()
    {
        require_once __DIR__ . '/templates/admin.php';
    }
}
