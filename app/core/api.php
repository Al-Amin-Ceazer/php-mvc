<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

const API_BASE_URL = 'http://i-trade.idlc.com/IDLCOutwardCommSvc/OnlineInterfaces.svc/';

function retrieve_account_list($cif)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, API_BASE_URL . "Customer/{$cif}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.16 (KHTML, like Gecko) \ Chrome/24.0.1304.0 Safari/537.16');
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,30);
    curl_setopt($ch,CURLOPT_TIMEOUT,40);
    $output = curl_exec($ch);

    if (! $output ) {
        trigger_error(curl_error($ch));
    }

    curl_close($ch);

    return json_decode($output, true);
}

function retrieve_account_details($account, $type)
{
    $account = trim($account);
    $type    = trim($type);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, API_BASE_URL . "AccountDetail/{$account}/{$type}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.16 (KHTML, like Gecko) \ Chrome/24.0.1304.0 Safari/537.16');
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,30);
    curl_setopt($ch,CURLOPT_TIMEOUT,40);
    $output = curl_exec($ch);

    if (! $output ) {
        trigger_error(curl_error($ch));
    }

    curl_close($ch);

    $response = json_decode($output, true);
    if (empty($response)) {
        return null;
    }

    return $response[0];
}

function send_sms($phone, $message)
{
    $message = str_replace(' ', '%20', $message);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, API_BASE_URL . "SendSms/{$phone}/{$message}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.16 (KHTML, like Gecko) \ Chrome/24.0.1304.0 Safari/537.16');
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,30);
    curl_setopt($ch,CURLOPT_TIMEOUT,40);
    $output = curl_exec($ch);

    if (! $output ) {
        trigger_error(curl_error($ch));
    }

    curl_close($ch);

    return $output;
}