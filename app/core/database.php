<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function db_init()
{
    global $DB;
    $DB = mysql_connect(DB_HOST.':'.DB_PORT, DB_USERNAME, DB_PASSWORD);

    if (!$DB) {
        db_error();
    }

    if (!mysql_select_db(DB_DATABASE, $DB)) {
        db_error();
    };

    return $DB;
}

function db_close($DB)
{
    if (!empty($DB)) {
        mysql_close($DB);
    }
}

function db_error($DB = null, $transaction = false)
{
    if (mysql_errno() > 0) {
        $data = sprintf("%s -> %s : %s\n\n", date('Y-m-d H:i:s', time()), mysql_errno(), mysql_error());
        $date = date('Y-m-d', time());

        if ($transaction) {
            mysql_query("ROLLBACK", $DB);
        }

        if (!empty($DB)) {
            db_close($DB);
        }

        file_put_contents(app_path('logs/'.$date.'_error.log'), $data, FILE_APPEND);

        if (defined('ENVIRONMENT') && ENVIRONMENT == 'development') {
            die($data);
        }
        die();
    }
}

function generate_otp($cif)
{
    $identifier = random_str(64);
    $code       = random_str(5, 'ABCDEFGHJKLMNPQRTUVWXYZ2346789');

    $DB = db_init();

    $customerId = mysql_real_escape_string($cif, $DB);

    $statement = "UPDATE otp_tokens SET is_valid = 0 WHERE `accessible_id` = {$customerId} AND `accessible_type` = '".CUSTOMER_MODEL."'";
    $result    = mysql_query($statement, $DB);

    db_error();

    $accessible_id        = mysql_real_escape_string($customerId, $DB);
    $accessible_type      = CUSTOMER_MODEL;
    $entry_point          = 'web';
    $identifier           = mysql_real_escape_string($identifier, $DB);
    $verification_code    = mysql_real_escape_string($code, $DB);
    $is_valid             = 1;
    $generation_timestamp = date('Y-m-d H:i:s', time());
    $created_at           = date('Y-m-d H:i:s', time());
    $updated_at           = date('Y-m-d H:i:s', time());

    $statement
            = "INSERT INTO otp_tokens (accessible_id, accessible_type, entry_point, 
                                      identifier, verification_code, is_valid, 
                                      generation_timestamp, created_at, updated_at) 
               VALUES ({$accessible_id}, '{$accessible_type}', '{$entry_point}', 
                      '{$identifier}', '{$verification_code}', {$is_valid}, 
                      '{$generation_timestamp}', '{$created_at}', '{$updated_at}')";

    $result = mysql_query($statement, $DB);
    db_error();

    db_close($DB);

    return array($identifier, $code);
}

function verify_otp($identifier, $otp)
{
    $DB         = db_init();
    $identifier = mysql_real_escape_string($identifier, $DB);
    $otp        = mysql_real_escape_string($otp, $DB);

    $statement  = "SELECT `accessible_id` FROM `otp_tokens` WHERE `accessible_type` = '".CUSTOMER_MODEL."'
                            AND `identifier` = '{$identifier}' AND `verification_code` = '{$otp}' AND `is_valid` = 1 LIMIT 1";
    $result = mysql_query($statement, $DB);

    $customer = mysql_fetch_assoc($result);

    db_error();

    if (empty($customer)) {
        return false;
    }
    $id = $customer['accessible_id'];

    $statement = "UPDATE otp_tokens SET is_valid = 0 WHERE `accessible_id` = {$id} AND `accessible_type` = '".CUSTOMER_MODEL."'";
    $result    = mysql_query($statement, $DB);

    db_close($DB);

    return $id;
}

function find_form_by_type_title($type)
{
    $DB         = db_init();
    $type      = mysql_real_escape_string($type, $DB);
    $statement = "SELECT * FROM `service_forms` WHERE LOWER(`title`) = LOWER('$type') LIMIT 1";
    $result    = mysql_query($statement, $DB);
    db_error();

    $form = mysql_fetch_assoc($result);

    db_close($DB);

    return $form;
}

function find_fields_by_form_id($form_id)
{
    $DB        = db_init();
    $form_id   = mysql_real_escape_string($form_id, $DB);
    $statement = "SELECT * FROM `service_items` WHERE `service_form_id` = '{$form_id}' ORDER BY `parent_id`, `index` ASC";
    $result    = mysql_query($statement, $DB);
    db_error();

    $items  = array();
    $_items = array(
        'left'  => array(),
        'right' => array()
    );

    while ($row = mysql_fetch_assoc($result)) {
        $items[ $row['id'] ] = $row;
        $items[ $row['id'] ]['children'] = array();
    }
    db_close($DB);

    return $items;
}

function store_service_request_submission($form)
{
    $DB = db_init();

    mysql_query("SET AUTOCOMMIT=0", $DB);
    mysql_query("START TRANSACTION", $DB);

    $service_form_id  = mysql_real_escape_string($form['form_id'], $DB);
    $customer_id      = mysql_real_escape_string($form['customer_id'], $DB);
    $type             = mysql_real_escape_string($form['type'], $DB);
    $product          = mysql_real_escape_string($form['product'], $DB);
    $account_number   = mysql_real_escape_string($form['account_number'], $DB);
    $contact_number   = mysql_real_escape_string($form['contact_number'], $DB);
    $customer_comment = mysql_real_escape_string($form['customer_comment'], $DB);
    $created_at       = mysql_real_escape_string(date('Y-m-d H:i:s', time()), $DB);
    $updated_at       = mysql_real_escape_string(date('Y-m-d H:i:s', time()), $DB);

    $statement = "INSERT INTO `service_requests` (
                    `service_form_id`, `customer_id`, `type`, `product`, `account_number`, 
                    `contact_number`, `customer_comment`, `approval_comment`, `completion_comment`, `created_at`, `updated_at`) 
                VALUES(
                    {$service_form_id}, {$customer_id}, '{$type}', '{$product}', '{$account_number}',
                    '{$contact_number}', '{$customer_comment}', '', '', '{$created_at}', '{$updated_at}')";

    $result = mysql_query($statement, $DB);
    db_error($DB, true);

    $requestId = mysql_insert_id($DB);

    if (empty($form['fields'])) {
        $form['fields'] = array();
    }

    $values = array();
    foreach ($form['fields'] as $idx => $field) {
        $field = trim($field);

        if (empty($field)) {
            continue;
        }

        $service_request_id = mysql_real_escape_string($requestId);
        $service_form_id    = mysql_real_escape_string($form['form_id'], $DB);
        $customer_id        = mysql_real_escape_string($form['customer_id'], $DB);
        $service_item_id    = mysql_real_escape_string($idx, $DB);
        $value              = mysql_real_escape_string($field, $DB);
        $created_at         = mysql_real_escape_string(date('Y-m-d H:i:s', time()), $DB);
        $updated_at         = mysql_real_escape_string(date('Y-m-d H:i:s', time()), $DB);

        $values[] = "({$service_request_id}, {$service_form_id}, {$customer_id}, 
                              {$service_item_id}, '{$value}', '{$created_at}', '{$updated_at}')";
    }

    if (!empty($values)) {
        $statement
            = "INSERT INTO `request_items` (
                            `service_request_id`, `service_form_id`, `customer_id`, 
                            `service_item_id`, `value`, `created_at`, `updated_at`)
                    VALUES ".implode(', ', $values);

        $result = mysql_query($statement, $DB);

        db_error($DB, true);
    }

    mysql_query("COMMIT", $DB);
    db_close($DB);

    return $requestId;
}

foreach (glob(__DIR__ . "/*.php") as $filename) {
    if (basename($filename) != basename(__FILE__)) {
        require $filename;
    }
}