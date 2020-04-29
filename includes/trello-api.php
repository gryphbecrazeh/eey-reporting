<?php

class TRELLO_API
{
    protected function FilterList($item)
    {
        if ($item->name === "Completed")
            return TRUE;
        else
            return FALSE;
    }
    protected function FilterCards($item)
    {
        $startDate = date('Y-m-d', strtotime('-1 month'));
        $cardID = $item->id;
        $createdDate = date('Y-m-d', hexdec(substr($cardID, 0, 8)));
        if ($createdDate > $startDate)
            return TRUE;
        else
            return FALSE;
    }
    // public function GetBoard()
    // {
    //     $curl = curl_init();
    //     // here is the issue where $url isn't defined
    //     curl_setopt($curl, CURLOPT_URL, $url);
    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //     $response = curl_exec($curl);
    //     $json = json_decode($response);
    //     return $json;
    // }
    function RenderResults($cards)
    {

?>
        <ul>
            <?php
            foreach (array_filter($cards, array($this, "FilterCards")) as $card) {
            ?>
                <li><?php echo $card->name ?></li>
            <?php
            }

            ?>
        </ul>
        <?php
    }
    function generateCSV($cards, $domain, $date_range)
    {
        $targetted_cards = array_filter($cards, function ($card) use ($date_range) {
            $startDate = $date_range['start'];
            $endDate = $date_range['end'];
            $cardID = $card->id;
            $createdDate = date('Y-m-d', hexdec(substr($cardID, 0, 8)));

            if ($createdDate >= $startDate && $createdDate <= $endDate)
                return TRUE;
            else
                return FALSE;
        });

        if (count($targetted_cards) > 0) {
            $cards = [];

            foreach ($targetted_cards as $card) {
                $report_title = array(
                    'Completed Tasks' => $card->name,
                    // 'completed' => 1
                );
                array_push($cards, $report_title);
            }

            if (count($cards) > 0) {
                $user_id = $_GET['id'];
                $date = Date('Y-m-d', strtotime('now'));
                $path = wp_upload_dir();
                $file_domain_name = preg_replace('/\W/','',$domain);
                $filename = "$file_domain_name-$date-trello-export.csv";
                $outstream = fopen($path['path'] . "$filename", 'w');
                $user = get_user_by('id', $user_id);
                // CSV Headers

                // $csv_id = array('ID', $domain);
                // fputcsv($outstream, $csv_id);
                // $csv_date = array('Date', $date_range['start'] . 'to' . $date_range['end']);
                // fputcsv($outstream, $csv_date);

                $header = array_keys($cards[0]);
                fputcsv($outstream, $header);
                // Output Data

                foreach ($cards as $row) {
                    fputcsv($outstream, $row);
                }
                fclose($outstream);
                echo '<a href=' . $path['url'] . $filename . "'>Download</a>";
            } else {
        ?>

                <div>
                    <strong>No Cards found in that time-frame</strong>
                    <p>Please verify that completed tasks are being added to the 'Completed Tasks' list</p>
                </div>
            <?php
                die();
            }
        } else {
            ?>

            <div>
                <strong>No Cards found in that time-frame</strong>
                <p>Please verify that completed tasks are being added to the 'Completed Tasks' list</p>
            </div>
            <?php
            die();
        }
    }

    function getData($boardId)
    {
        global $wpdb;

        $settings_table = $wpdb->prefix . 'eey_reporting_settings';

        $query = "SELECT * FROM $settings_table";

        $config = $wpdb->get_results($query)[0];

        $key = $config->trello_api_key;
        $token = $config->trello_default_token;

        // Initialize a start date from 1 month ago
        $startDate = date('Y-m-d', strtotime('-1 month'));

        // https://trello.com/b/9r0cWiUh
        // $boardId = "9r0cWiUh";

        $url = "https://api.trello.com/1/boards/$boardId/?lists=all&cards=all&key={$key}&token={$token}";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $json = json_decode($response);
        if ($json) {
            $lists = $json->lists;
            $cards = $json->cards;
    
            // If nothing is returned, somehting went wrong
            if (!$cards || !$lists) {
            ?>
                <script>
                    console.log($response);
                </script>
                <h3>An Error has occurred</h3>
                <p>The response object has been output to the console</p>
                <p>Please reach out to a coder for support</p>

            <?php
                die();
            }

            function FilterList($item)
            {
                if ($item->name === "Completed Tasks")
                    return TRUE;
                else
                    return FALSE;
            }
            function FilterCards($item)
            {
                $startDate = date('Y-m-d', strtotime('-1 month'));
                $cardID = $item->id;
                $createdDate = date('Y-m-d', hexdec(substr($cardID, 0, 8)));
                if ($createdDate > $startDate)
                    return TRUE;
                else
                    return FALSE;
            }

            $list = array_filter($lists, 'FilterList');
            $listID = "";
            foreach($list as $item) {
                if($item->id)
                {
                    $listID=$item->id;
                }
            }
            // Check if the 'Completed Tasks' list is present
            if (!$listID) {
            ?>
                <h3>'Completed Tasks' List is not found on that board</h3>
                <p>Please verify that that board's column is labeled correctly</p>
<?php
                die();
            }
            // Filter the cards to be exclusively from the 'Completed Tasks' list
            $list_cards = array_filter($cards, function ($card) use ($listID) {
                $cardID = $card->idList;
                if ($cardID == $listID) {
                    return true;
                } else {
                    return false;
                }
            });
            return $list_cards;
        } else {
            echo 'Board Not Found...';
            echo '<br>';
            echo "Cannot find <a href='https://trello.com/b/$boardId'>https://trello.com/b/$boardId</a>...";
            die();
        }
        curl_close($curl);
    }
}
