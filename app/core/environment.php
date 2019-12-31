<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (defined('ENVIRONMENT'))
{
    switch (ENVIRONMENT)
    {
        case 'testing':
        case 'production':
            error_reporting(0);
            break;

        case 'development':
        default:
            error_reporting(E_ALL);
            break;
    }
}
