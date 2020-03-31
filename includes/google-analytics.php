<?php

// Load the Google API PHP Client Library.
require_once __DIR__ . '/../vendor/autoload.php';

class GA_API
{
  /**
   * Initializes an Analytics Reporting API V4 service object.
   *
   * @return An authorized Analytics Reporting API V4 service object.
   */
  protected function initializeAnalytics()
  {

    // Use the developers console and download your service account
    // credentials in JSON format. Place them in this directory or
    // change the key file location if necessary.
    $KEY_FILE_LOCATION = __DIR__ . '/../config/My Project-b774a516a946.json';

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
  protected function getReport($analytics, $VIEW_ID)
  {

    // Initialize a start date from 1 month ago
    $startDate = date('Y-m-d', strtotime('-1 month'));

    // Create the DateRange object.
    $dateRange = new Google_Service_AnalyticsReporting_DateRange();
    $dateRange->setStartDate($startDate);
    $dateRange->setEndDate("today");

    // Create the Metrics objects
    function generateMetrics($array)
    {
      $item = new Google_Service_AnalyticsReporting_Metric();
      $item->setExpression($array["expression"]);
      $item->setAlias($array["alias"]);
      return $item;
    }
    
    // $array  = array(
    //   "name" => "Sessions",
    //   "expression" => "ga:sessions",
    //   "alias" => "sessions"
    // );
    // $array2  = array(
    //   "name" => "sessions 2",
    //   "expression" => "ga:sessions",
    //   "alias" => "sessions"
    // );

    // // print_r($array);
    // // echo $array["expression"];
    // $master_array = [$array, $array2];
    // $total_array = array_map('generateMetrics', $master_array)
    // // print_r($total_array);

    // var_dump($total_array);

    $sessions = new Google_Service_AnalyticsReporting_Metric();
    $sessions->setExpression("ga:sessions");
    $sessions->setAlias("sessions");

    $bounces = new Google_Service_AnalyticsReporting_Metric();
    $bounces->setExpression("ga:bounces");
    $bounces->setAlias("bounces");

    $bounceRate = new Google_Service_AnalyticsReporting_Metric();
    $bounceRate->setExpression("ga:bounceRate");
    $bounceRate->setAlias("bounce rate");

    $load_time = new Google_Service_AnalyticsReporting_Metric();
    $load_time->setExpression("ga:pageLoadTime");
    $load_time->setAlias("Load Time");

    // Create the ReportRequest object.
    $request = new Google_Service_AnalyticsReporting_ReportRequest();
    $request->setViewId($VIEW_ID);
    $request->setDateRanges($dateRange);
    $request->setMetrics(array($sessions, $bounces, $bounceRate, $load_time));

    $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
    $body->setReportRequests(array($request));
    return $analytics->reports->batchGet($body);
  }

  /**
   * Parses and prints the Analytics Reporting API V4 response.
   *
   * @param An Analytics Reporting API V4 response.
   */
  protected function printResults($reports)
  {
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
        <ul>
          <?php

          for ($j = 0; $j < count($metrics); $j++) {
            $values = $metrics[$j]->getValues();
            for ($k = 0; $k < count($values); $k++) {
              $entry = $metricHeaders[$k];
              // print($entry->getName() . ": " . $values[$k] . "\n");
          ?>
              <li><?php echo $entry->getName() ?>: <?php echo $values[$k] ?></li>
          <?php

            }
          }
          ?>
        </ul>
<?php
      }
    }
  }
  public function report($view_id)
  {
    $analytics = $this->initializeAnalytics();
    $google_response = $this->getReport($analytics, $view_id);
    return $this->printResults($google_response);
  }
  // Create the Metrics objects
  public function generateMetrics($array)
  {
    $item = new Google_Service_AnalyticsReporting_Metric();
    $item->setExpression($array["expression"]);
    $item->setAlias($array["alias"]);
    return $item;
  }
}
