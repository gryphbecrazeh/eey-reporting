<?php
global $wpdb;

$params = $_GET;
$data_id = $params['data_id'];

// Get Website
$table_name = $wpdb->prefix . 'eey_reporting_websites';
$query = "SELECT * FROM $table_name WHERE ID = $data_id";
$website = $wpdb->get_results($query)[0];

// Get report logs
$table_name = $wpdb->prefix . 'eey_reporting_data_logs';
$query = "SELECT * FROM $table_name WHERE domain_name = $website->domain_name";
$reports = $wpdb->get_results($query);

$report;
?>

<section class="cover">
    <div class="container">
        <div class="logo small"></div>
        <h1>WEBSITE REPORTING</h1>
        <div class="date"><?php echo "$report->month $report->year" ?></div>
        <div class="client"><?php echo $report->domain_name ?></div>
    </div>
</section>
<section class="updates+notes">
    <h1>UPDATES + NOTES</h1>
    <div class="container">
        <div class="report-column"><strong>CITATIONS LOG</strong>
            <ul class="citations-log">
                <?php
                foreach ($report->citations as $citation) {
                ?>
                    <li><?php echo "$citation" ?></li>
                <?php
                }
                ?>
            </ul>
        </div>
        <div class="report-column"><strong>CHANGE LOG</strong>
            <ul class="change-log">
                <?php
                foreach ($report->trello as $trello) {
                ?>
                    <li> <?php echo "$trello" ?></li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
</section>
<seciton class="audience-overview">
    <div class="title">
        <strong>AUDIENCE OVERVIEW</strong>
        <strong><?php echo "$report->start_month, $report->start_year - $report->end_month, $report->end_year" ?></strong>
    </div>
</seciton>
<section class="channel-overview">
    <div class="top-channel">
    </div>
    <div class="users-conversions"></div>
    <div class="aquisition-behavior-conversions"></div>
</section>
<section class="website-preformance">
    <div class="preformance-report">
        <div class="title">
            <strong>PREFORMANCE REPORT</strong>
            <strong>Lastest preformance Report for: <?php echo "$report->domain_name" ?></strong>
        </div>
    </div>
    <div class="mobile-desktop-preformance-overview">
        <div class="title"><strong>MOBILE + DESKTOP PREFORMANCE OVERVIEW</strong></div>
    </div>
</section>
<section class="close">
    <div class="container">
        <div class="logo large"></div>
    </div>
</section>