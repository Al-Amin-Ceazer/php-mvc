<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function app_path($path)
{
    $path = trim($path, '/');

    return APPLICATION_PATH . "/$path";
}

/*function public_path($path)
{
    $path = trim($path, '/');

    return PUBLIC_PATH . "/$path";
}*/

function app_url($path)
{
    $path = trim($path, '/');

    return APP_URL . "/$path";
}

function auth_check($guard = 'customers', $redirect = true)
{
    $_customer   = get_session('AUTHCUSTOMER', false);
    $_admin      = get_session('AUTHADMIN', false);

    $_customerId = get_session('AUTHCUSTOMERID', false);
    $_adminId    = get_session('AUTHADMINID', false);

    $_authTime = get_session('AUTHLOGGED', 0);

    switch ($guard) {
        case 'customers':
            if ( ! ($_customer == 'customers')) {
                if ($redirect) {
                    redirect('login.php');
                }
                return false;
            }

            if (abs( time() - $_authTime ) >= 10*60*60) {
                redirect('logout.php');
            }

            put_session('AUTHLOGGED', time());
            return true;

        case 'admins':
            if ( ! ($_admin == 'admins')) {
                if ($redirect) {
                    redirect('admin/login.php');
                }
                return false;
            }

            if (abs( time() - $_authTime ) >= 10*60*60) {
                redirect('admin/logout.php');
            }

            put_session('AUTHLOGGED', time());
            return true;
    }

    return false;
}

function redirect($path)
{
    if ( stripos($path, APP_URL) == false ) {
        $path = app_url($path);
    }

    header("Location: $path");
    die();
}

function get_session($key, $default = null)
{
    $keys = explode('.', $key);

    $val = $_SESSION;

    foreach ($keys as $key) {
        $val = @$val[$key];

        if (empty($val)) {
            return $default;
        }
    }

    return $val;
}

function put_session($key, $value)
{
    $_SESSION[$key] = $value;
}

function has_flash($key)
{
    global $FLASH;
    return array_key_exists($key, $FLASH);
}

function get_flash($key, $default = null)
{
    global $FLASH;
    if (empty($FLASH)) {
        return $default;
    }

    return empty($FLASH[$key]) ? $default : $FLASH[$key];
}

function put_flash($key, $value)
{
    if (empty($_SESSION['__FLASH__'])) {
        $_SESSION['__FLASH__'] = array();
    }

    $_SESSION['__FLASH__'][$key] = $value;
}

function post_input($key, $default = null)
{
    return empty($_POST[$key]) ? $default : $_POST[$key];
}

function get_input($key, $default = null)
{
    return empty($_GET[$key]) ? $default : $_GET[$key];
}

function random_str($length = 10, $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $characters       = '2346789ABCDEFGHJKLMNPQRTWXYZ';
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}
