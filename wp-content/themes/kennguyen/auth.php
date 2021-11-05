<?php
global $va_options;

function callRPC($Request, $host, $Debug = true) {
    $curl = curl_init($host);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_VERBOSE, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSLVERSION, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
    $RequestString = json_encode($Request);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $RequestString);
    if ($Debug) {
        $RequestString;
    }
    $ResponseString = curl_exec($curl);
    if ($Debug) {
        $ResponseString;
    }
    if (!empty($ResponseString)) {
        $Response = json_decode($ResponseString);
        if (isset($Response->result)) {
            return $Response->result;
        }
        if (!is_null($Response->error)) {
            var_dump($Request->method, $Response->error);
        }
    } else {
        return null;
    }
}

$host = 'https://api.2checkout.com/rpc/6.0/';

$merchantCode = $va_options['kn_2co_account']; // your account's merchant code available in the 'System settings' area of the cPanel: https://secure.2checkout.com/cpanel/account_settings.php
$key = $va_options['kn_2co_serect_word']; // your account's secret key available in the 'System settings' area of the cPanel: https://secure.2checkout.com/cpanel/account_settings.php

$string = strlen($merchantCode) . $merchantCode . strlen(gmdate('Y-m-d H:i:s')) . gmdate('Y-m-d H:i:s');
$hash = hash_hmac('md5', $string, $key);

$i = 1;

$jsonRpcRequest = new stdClass();
$jsonRpcRequest->jsonrpc = '2.0';
$jsonRpcRequest->method = 'login';
$jsonRpcRequest->params = array($merchantCode, gmdate('Y-m-d H:i:s'), $hash);
$jsonRpcRequest->id = $i++;

$sessionID = callRPC($jsonRpcRequest, $host);
