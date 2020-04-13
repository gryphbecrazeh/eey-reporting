<?php

// Load the Google API PHP Client Library.
$google_autoload = plugin_dir_path(__DIR__) . 'vendor/autoload.php';
require_once plugin_dir_path(__DIR__) . 'vendor/autoload.php';

class GA_API
{
  /**
   * Initializes an Analytics Reporting API V4 service object.
   *
   * @return An authorized Analytics Reporting API V4 service object.
   */
  protected function initializeAnalytics()
  {
    global $wpdb;

    // Required Config file by Google
    $KEY_FILE_LOCATION = plugin_dir_path(__DIR__) . '/includes/config/My Project-b774a516a946.json';

    // Get the latest settings and update the config file
    $table_name = $wpdb->prefix . 'eey_reporting_settings';
    $query = "SELECT * FROM $table_name";
    $results = $wpdb->get_results($query)[0];

    $auth_config = array(
      'type' => $results->ga_type,
      'project_id' => $results->ga_project_id,
      'private_key_id' => $results->ga_private_key_id,
      'private_key' => $results->ga_private_key,
      'client_email' => $results->ga_client_email,
      'client_id' => $results->ga_client_id,
      'auth_uri' => $results->ga_auth_uri,
      'token_uri' => $results->ga_token_uri,
      'auth_provider_x509_cert_url' => $results->ga_auth_provider_x509_cert_url,
      'client_x509_cert_url' => $results->ga_client_x509_cert_url
    );

    // Update the JSON config file
    $config_file = fopen($KEY_FILE_LOCATION, 'w') or die("Unable to open JSON config file!");
    fwrite($config_file, stripslashes(json_encode($auth_config))) or die("Unable to write JSON config file!");
    fclose($config_file);


    // Create and configure a new client object.
    $client = new Google_Client();

    $client->setApplicationName("Hello Analytics Reporting");

    $client->setAuthConfig($KEY_FILE_LOCATION);

    $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);

    $analytics = new Google_Service_AnalyticsReporting($client);

    return $analytics;
  }


  /**
   * Queries the Analytics Reporting API V4.
   *
   * @param service An authorized Analytics Reporting API V4 service object.
   * @return The Analytics Reporting API V4 response.
   */
  protected function getReport($analytics, $VIEW_ID, $date)
  {
    // $startDate = date('Y-m-d', strtotime('-1 month'));
    // $startDate = date('Y-m-d', strtotime('2020-04-09'));
    $startDate = $date;
    // Get fields from class
    include_once plugin_dir_path(__DIR__) . 'includes/forms/ga_inc/ga_report_class.php';

    $get_request_fields = new GA_REPORT_FIELDS();
    $request_fields = $get_request_fields->mapMetrics($get_request_fields->report_fields);

    // Break down into an array to iterate through and get all options
    $chunks = array_chunk($request_fields, 10);

    $array = [];

    foreach ($chunks as $chunk) {

      // Create the DateRange object.
      $dateRange = new Google_Service_AnalyticsReporting_DateRange();

      // Get Data for specific date
      // DEV NOTE: maybe go Month by month
      $dateRange->setStartDate($startDate);
      // $dateRange->setEndDate("today");
      $dateRange->setEndDate($startDate);

      // Create the ReportRequest object.
      $request = new Google_Service_AnalyticsReporting_ReportRequest();
      $request->setViewId($VIEW_ID);
      $request->setDateRanges($dateRange);

      $request->setMetrics($chunk);

      $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
      $body->setReportRequests(array($request));
      $this->printResults(array($analytics->reports->batchGet($body)));
      // array_push($array, $analytics->reports->batchGet($body));
    }

    // return $array;
  }


  /**
   * Parses and prints the Analytics Reporting API V4 response.
   *
   * @param An Analytics Reporting API V4 response.
   */
  protected function printResults($reports_array)
  { ?>
    <ul>
      <?php

      foreach ($reports_array as $reports) {
        for ($reportIndex = 0; $reportIndex < count($reports); $reportIndex++) {
          $report = $reports[$reportIndex];
          $header = $report->getColumnHeader();

          $dimensionHeaders = $header->getDimensions();

          $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
          $rows = $report->getData()->getRows();

          for ($rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
            $row = $rows[$rowIndex];
            $dimensions = $row->getDimensions();
            $metrics = $row->getMetrics();
            for ($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); $i++) {
              print($dimensionHeaders[$i] . ": " . $dimensions[$i] . "\n");
            }
      ?>
            <?php

            for ($j = 0; $j < count($metrics); $j++) {
              $values = $metrics[$j]->getValues();
              for ($k = 0; $k < count($values); $k++) {
                $entry = $metricHeaders[$k];
            ?>
                <li><?php echo $entry->getName() ?>: <?php echo $values[$k] ?></li>
            <?php

              }
            }
            ?>
      <?php
          }
        }
      }
      ?>

    </ul>

<?php
  }


  public function report($view_id)
  {

    $analytics = $this->initializeAnalytics();

    $date = current_time('Y-m-d');

    $google_response = $this->getReport($analytics, $view_id, $date);
    return $this->printResults($google_response);
  }
}
