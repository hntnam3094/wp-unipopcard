<?php /*
   Plugin Name: Klavioy custom for Ken
   Description: Klavioy custom for Ken
   Author: Thanh Nam
   Version: 1.0
   */



add_action('add_subscription', 'function_add_subscription', 10, 4);

function function_add_subscription($first_name, $last_name, $email, $listId) {
    global $va_options;
    $apiKey = $va_options['klavioy_api_key'];
    if (empty($listId) || empty($apiKey)) {
        return true;
    }

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://a.klaviyo.com/api/v2/list/'.$listId.'/members?api_key='.$apiKey,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'
        {
             "profiles": [
                  {
                       "email": "'.$email.'",
                       "first_name": "'.$first_name.'",
                       "last_name": "'.$last_name.'"
                  }
             ]
        }
        ',
        CURLOPT_HTTPHEADER => array(
            'accept: application/json',
            'content-type: application/json'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
}
