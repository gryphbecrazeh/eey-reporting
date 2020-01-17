<?php

/**
 * Plugin Name: East End Yovth Reporting
 * Plugin URI: http://www.cordine.site/
 * Description: A custom plugin built by Christopher Cordine
 * Version: 1.2
 * Author: Christopher Cordine
 * Author URI: http://www.cordine.site/
 */

add_action('admin_bar_menu', 'eey_reporting_add_toolbar_items', 100);

add_action('wp_enqueue_scripts', 'eey_reporting_include_scripts');

add_action('eey_pagespeed_report', 'eey_reporting_page_speed');

add_shortcode('eey_pagespeed', 'eey_reporting_page_speed_2');

function eey_reporting_page_speed()
{
    $base_url = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=";
    $target = "https://eastendyovth.com";

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $base_url . $target
    ]);

    $res = curl_exec($curl);

    $decodedRes = json_decode($res);
    $lighthouse_result = $decodedRes->lighthouseResult;
    $audits = get_object_vars($lighthouse_result->audits);
    // Cycle through each element and output the title and value
    foreach ($audits as $index => $value) {
?>
        <div>
            <?php echo $value->title ?> : <?php echo $value->displayValue ?>
        </div>


    <?php
    }
    curl_close($curl);
    return 0;
}

function eey_reporting_page_speed_2()
{
    ?>
    <button onclick="">Click Me</button>
<?php
}

function eey_reporting_include_scripts()
{
    $google_uri_base = 'https://www.googleapis.com/webmasters/v3';
    $client_id = '258642766560-uv0tvs227beilrtceaco1tk7nth1p3p5.apps.googleusercontent.com';
    $client_secret = 'MffmMp-bzR44_a_-a5-4d4nQ';
    $api_key = "AIzaSyBhmbm2PC7uSvS2W1bfQ-xTNptpGOIQBjQ";
    $url = 'http://www.fallonfiberglass.com/';
    $url = preg_replace("/:/", "%3A", $url);
    $url = preg_replace("/\//", "%2F", $url);

    // Initialize cURL
    $curl = curl_init();

    // curl -H 'Content-Type: application/json' --data '{url: "http://fallonfiberglass.com"}' 'https://searchconsole.googleapis.com/v1/urlTestingTools/mobileFriendlyTest:run?key=AIzaSyBhmbm2PC7uSvS2W1bfQ-xTNptpGOIQBjQ'

    $headers = [
        "Authorization: Bearer $client_id",
        'Accept: application/json',
        'Content-Type: application/json'
    ];

    // Set Options
    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_URL => "$google_uri_base/sites/query?key=$api_key",
        CURLOPT_USERAGENT => 'Codular Sample cURL Request'
    ]);

    $res = curl_exec($curl);
    // echo $res;

    curl_close($curl);
}

function eey_reporting_add_toolbar_items($admin_bar)
{
    $admin_bar->add_menu(array(
        'id' => 'eey-adminbar',
        'title' => 'Reporting',
        'meta' => array(
            'title' => __('EEY Custom Plugin'),
        ),
    ));
}

// from analytics

// get

// aquisition

// and 

// audience
