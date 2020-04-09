<?php
// Define all fields required for reporting
class GA_REPORT_FIELDS
{
    function __construct()
    {
        $this->report_fields = array(
            // 'new_users' => array(
            //     'alias' => 'New Users',
            //     'expression' => 'ga:newUsers'
            // ),
            // 'percent_new_sessions' => array(
            //     'alias' => '% of New Sessions',
            //     'expression' => 'ga:percentNewSessions'
            // ),
            // '1_day_users' => array(
            //     'alias' => '1 Day Active Users',
            //     'expression' => 'ga:1dayUsers'
            // ),
            // '7_day_users' => array(
            //     'alias' => '7 Day Active Users',
            //     'expression' => 'ga:7dayUsers'
            // ),
            // '14_day_users' => array(
            //     'alias' => '14 Day Active Users',
            //     'expression' => 'ga:14dayUsers'
            // ),
            // '28_day_users' => array(
            //     'alias' => '28 Day Active Users',
            //     'expression' => 'ga:28dayUsers'
            // ),
            // '30_day_users' => array(
            //     'alias' => '30 Day Active Users',
            //     'expression' => 'ga:30dayUsers'
            // ),
            'sessions' => array(
                'alias' => 'Sessions',
                'expression' => 'ga:sessions'
            ),
            'bounces' => array(
                'alias' => 'Bounces',
                'expression' => 'ga:bounces'
            ),
            'bounce_rate' => array(
                'alias' => 'Bounce Rate',
                'expression' => 'ga:bounceRate'
            ),
            'avg_session_duration' => array(
                'alias' => 'Average Session Duration',
                'expression' => 'ga:avgSessionDuration'
            ),
            'organic_searches' => array(
                'alias' => 'Organic Searches',
                'expression' => 'ga:organicSearches'
            ),
            'impressions' => array(
                'alias' => 'Impressions',
                'expression' => 'ga:impressions'
            ),
            'clicks' => array(
                'alias' => 'Clicks',
                'expression' => 'ga:adClicks'
            ),
            'cost' => array(
                'alias' => 'Cost',
                'expression' => 'ga:adCost'
            ),
            'cpm' => array(
                'alias' => 'CPM',
                'expression' => 'ga:CPM'
            ),
            'cpc' => array(
                'alias' => 'CPC',
                'expression' => 'ga:CPC'
            ),
            'ctr' => array(
                'alias' => 'CTR',
                'expression' => 'ga:CTR'
            ),
            'page_load_time' => array(
                'alias' => 'Page Load Time (ms)',
                'expression' => 'ga:pageLoadTime'
            ),
            'avg_page_load_time' => array(
                'alias' => 'Average Page Load Time (sec)',
                'expression' => 'ga:avgPageLoadTime'
            ),
            'page_download_time' => array(
                'alias' => 'Page Download Time (ms)',
                'expression' => 'ga:pageDownloadTime'
            )

        );
    }
    // Create the Metrics objects
    public function generateMetrics($item)
    {
        $metric = new Google_Service_AnalyticsReporting_Metric();
        $metric->setExpression($item["expression"]);
        $metric->setAlias($item["alias"]);

        return $metric;
    }

    public function mapMetrics($array)
    {
        // $map = array_map(array($this, 'generateMetrics'), $array);
        $map = [];
        foreach($array as $item) {
            array_push($map,$this->generateMetrics($item));
        }

        return $map;
    }
}
