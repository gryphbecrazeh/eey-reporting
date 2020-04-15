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
            // Check if the 'Completed Tasks' list is present

            if (!$list) {
            ?>
                <h3>'Completed Tasks' List is not found on that board</h3>
                <p>Please verify that that board's column is labeled correctly</p>
<?php
                die();
            }
            // Filter the cards to be exclusively from the 'Completed Tasks' list
            $list_cards = array_filter($cards, function ($card) use ($list) {
                $cardID = $card->idList;
                $listID = $list[10]->id;
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
