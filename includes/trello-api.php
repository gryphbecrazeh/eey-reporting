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
    function RenderResults($boardId)
    {

        $plugin_url = ABSPATH . 'wp-content/plugins/eey-reporting';

        $str = file_get_contents($plugin_url . '/includes/config/Trello-API.json');
        $json = json_decode($str, true);
        $key = $json["key"];
        $token = $json["defaultToken"];

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
            // function FilterList($item)
            // {
            //     if ($item->name === "Completed")
            //         return TRUE;
            //     else
            //         return FALSE;
            // }

            // foreach (array_filter($lists, "FilterList") as $list) {
            foreach (array_filter($lists, array($this, 'FilterList')) as $list) {

?>
                <p>Completed tasks in <?php echo date('M') ?></p>
                <ul>
                    <?php
                    foreach (array_filter($cards, "FilterCards") as $card) {
                        if ($card->idList === $list->id) {
                    ?>
                            <li><?php echo $card->name ?></li>
                    <?php
                        }
                    }

                    ?>
                </ul>
<?php
            }
        } else {
            echo 'Board Not Found...';
            echo '<br>';
            echo "Cannot find <a href='https://trello.com/b/$boardId'>https://trello.com/b/$boardId</a>...";
        }
        curl_close($curl);


        // #############################################################################################
        // End Trello API
        // #############################################################################################
    }
}
